<?php
// set_time_limit(90);
// ini_set('memory_limit', '256M');

include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class BancoDadosController extends My_Controller 
{
	
	public function ini()
	{
    	$this->view->tituloPag 	= 'Importar contatos';
    	
    	$params = $this->_request->getParams();
    	$this->id = $params['id'];
    	
    	$post = $this->_request->getPost();
    	//$params = $this->_request->getParams();
 
	}
	
	
	public function importarCsvAction ()
	{	
		// nome do arquivo
		$arquivo = 'assets/uploads/csv/csvvirgulaCSV.csv';
		
		// ponteiro para o arquivo
		$fp = fopen($arquivo, "r");
		
		// processa os dados do arquivo
		$linha = 0;
		while(($dados = fgetcsv($fp, 0, ";")) !== FALSE){
			
			$quant_campos = count($dados);
			for($i = 0; $i < $quant_campos; $i++){
				if ($linha == 0){
					$topo[$i] = $dados[$i];
				} else {
					//echo $topo[$i]; echo ': '; echo $dados[$i] . "<br>";
				}
			}
			
			if ($linha != 0){
				//echo "<br>";
			}
			
			$edt = $this->insertPostgre('index','new-contato', $post);
			
			$linha ++;
			
		}
		
		fclose($fp);
		
		for($a = 0; $a < $i; $a++){
			echo $topo[$a];
		}
		
		exit();
		
	}
	
    public function indexAction ()
    {
    	
    	$post = $this->_request->getPost();
    	$get = $this->_request->getParams();
    	
    	if ( !$get['id_usuario'] ) {
    		$get['id_usuario'] = array('0'=>'0');
    	}
    	
    	// FILTRO POR USUARIOS
    	if ( !array_diff ( $get['id_usuario'], $this->me->familia ) ){
    		$id_usuario = implode(',', $get['id_usuario']);
    	} else {
    		$id_usuario = implode(',', $this->me->familia);
    	}
    	
    	$this->view->lista_contatos = json_decode(file_get_contents($this->view->backend.'/api/contatos/get-listas?id_usuario='.$id_usuario.'&limit=9999&oculto=0'));
    	$this->view->lista_contatos = $this->view->lista_contatos->registros;
    	
    }
    
    public function uploadArquivoAction()
    {
    	
    	$post = $this->_request->getPost();
    	$get = $this->_request->getParams();
    	
    	if ($_POST['upload'] == 'novo'){
    	
    		// UPLOAD DO CSV
    		$file 		= $_FILES['uploadfile'];
    		$path 		= '';
    		$options 	= array(	'path' 		=> '',
    				'where' 	=> NULL,
    				'size' 	=> 500000,
    				'type' 		=> 'file',
    				'root' 		=> $this->pathUpload.'csv/' );
    		$upload =  new App_File_Upload($file, $path, $options);
    	
    		// TIPO DE ARQUIVO, SE É SEPARADO POR , OU ;
    		$get['tipo'] = $_POST['tipo'];
    	
    		// DIRETORIO DO ARQUIVO CSV
    		$diretorio = 'assets/uploads/csv/'.$upload->_where();
    	
    		// VE SE A EXTENSÃO É VÁLIDA
    		$extensao = explode('.', $diretorio);
    		$extensao = $extensao[1];
    	
    		// DIRETORIO DOS CSV QUEBRADO
    		$config = array();
    		$config['arquivo'] = $diretorio;
    		$config['tipo'] = $get['tipo'];
    		$config['lista'] = $post['lista'];
    		$config['topo'] = $post['topo'];
    	
//     		echo '<pre>';print_r($post); exit;
    		
    		$diretorioQuebrado = $this->arquivaContatos($config);
    		$get['diretorioQuebrado'] = $diretorioQuebrado;
    	
    		$get['arquivo'] = $upload->_where();
    		
    		// VERIFICA SE A EXTENSÃO É VALIDA E PERMITE A CONTINUAÇÃO DA IMPORTAÇÃO
    		if ($extensao != 'csv' && $extensao != 'CSV'):
    	
    			$this->_messages->addMessage(array('Arquivo com formato inválido, é aceito apenas CSV.'));
    			$this->_redirect('/'.$this->view->baseModule.'/banco-dados/index');
    	
    		else:
    	
    			$this->redirect_post('/'.$this->view->baseModule.'/banco-dados/campos', $get);
    	
    		endif;
    		 
    	}
    	
    }
    
    public function camposAction()
    {
    	
    	$get = $this->_request->getPost();
    	$get = (object)$get;
    	unset($get->controller);
    	unset($get->whitelabel);
    	unset($get->action);
    	unset($get->module);
    	unset($get->upload);
    	
//     	print_r($get); exit;
    	
    	$this->view->cabecalho = $get->topo;
    	
    	
    	// MANDA ALGUMAS INFOS PRA VIEW
    	$this->view->topo = $get->topo_csv;
    	$this->view->campos = $get->campos;
    	$this->view->tipo = $get->tipo;
    	$this->view->lista = $get->lista;
    	$this->view->diretorio = $get->diretorioQuebrado;
    	$this->view->diretorio_old = $get->arquivo;
    	
    }
    
    public function sendAction()
    {
    	
    	// ESSA ETAPA CRIA O CONFIG DENTRO DA PASTA
    	$post = $this->_request->getPost();
    	$post['topo'] = json_decode($post['topo']);
    	
    	
    	$dir = $_SERVER['DOCUMENT_ROOT'].'/assets/importacao/'.$post['diretorio'].'/config.txt';
    	
    	$dirPasta = $_SERVER['DOCUMENT_ROOT'].'/assets/importacao/'.$post['diretorio'];
    	$dirNovo = $_SERVER['DOCUMENT_ROOT'].'/importacao/'.$post['diretorio'];
    	
    	$myfile = fopen($dir, "w+") or die("Unable to open file!");
    	fwrite($myfile, json_encode($post));
    	fclose($myfile);
    	
    	echo $dirPasta;
    	echo '<br/>';
    	echo $dirNovo;
    	
    	$this->copiar_diretorio($dirPasta, $dirNovo);
    	
    	$this->_redirect($this->view->baseModule.'/banco-dados/processando?key='.$post['diretorio']);
    	
    }
    
    public function cronImportacaoAction()
    {
    	
    	$dir = $_SERVER['DOCUMENT_ROOT'].'/importacao';
    	$files = scandir($dir);
    	unset($files[0]);
    	unset($files[1]);
    	$totalPastas = count($files);
    	
    	if ($totalPastas == 0){
    		
    		die('Nenhuma importação.');
    		
    	} else {
    		
    		$primeiroFila = $files[2];
    		$diretorioPrimeiroFila = $dir.'/'.$primeiroFila;
    		$files = scandir($diretorioPrimeiroFila);
    		$config = $files[2];
    		unset($files[0]);
    		unset($files[1]);
    		unset($files[2]);
    		$totalArquivos = count($files);
    		
    		if ($totalArquivos == 0){
    			
    			unlink($diretorioPrimeiroFila.'/'.$config);
    			rmdir($diretorioPrimeiroFila);
    			die('Removeu uma pasta da fila.');
    			
    		} else {
    			
	    		$contatos = $files[3];
				
	    		$insere = $this->importaCsvContatosMultiplos($primeiroFila, $contatos);
	    		
	    		if ($insere == 'true'){
	    			
	    			unlink($diretorioPrimeiroFila.'/'.$contatos);
	    			die('remove '.$diretorioPrimeiroFila.'/'.$contatos);
	    			
	    		} else {
	    			
	    			echo $insere;
// 	    			$this->delTree($diretorioPrimeiroFila);
	    			die('Erro interno na importação.');
	    			
	    		}
    		
    		}
    		
    	}
    	
    	
    }
    
    public function acompanhamentoAction()
    {
    	
    	$get = $this->_request->getParams();
    	
    	if ($get['type'] == 'start'){
    		
    		$url = $this->view->backend.'api/importacao/acompanhamento?key='.$get['key'].'&type=start';
    		
    	} else {
    		
    		$url = $this->view->backend.'api/importacao/acompanhamento?key='.$get['key'].'&total='.$get['total'];
    		
    	}
    	
    	
    	echo file_get_contents($url); exit;
    	
    }
    
    public function processandoAction()
    {
    	
    	$get = $this->_request->getParams();
    	
    }
    
    private function importaCsvContatosMultiplos($diretorio, $arquivo)
    {
    	
    	exit;
    	
    	$dir = $_SERVER['DOCUMENT_ROOT'].'/importacao/'.$diretorio.'/';
    	$config = $dir.'config.txt';
    	
    	$myfile = fopen($config, "r") or die( $this->delTree($dir) );
    	$conteudo = fgets ($myfile);
    	fclose($myfile);
    	
    	$postGet = json_decode($conteudo);
    	$postGet = (array)$postGet;
    	
    	// REMONTA O POSTGET
    	foreach($postGet as $key => $row)
    	{
    		
    		if (is_array($row)){
    			
    			$postGet[$key] = array();
    			
    			foreach($row as $keyd => $rowd){
    				
    				$postGet[$key][$keyd] = $rowd;
    				
    			}
    			
    		} else {
    			
    			$postGet[(string)$key] = $row;
    			
    		}
    		
    		
    	}
    	
    	$diretorio 		= $dir.$arquivo;
    	$topo_conf		= $postGet['cabecalho'];
    	$tipo 			= $postGet['tipo'];
    	$lista	 		= $postGet['id_lista'];
    	$cerca 			= '"';
    	
    	// TOTAL DE LINHAS (REGISTROS)
    	$totalLinhas = count( file( $diretorio ) );
    	
    	// ABRE O ARQUIVO
    	$fp = fopen($diretorio, "r");
    	
    	// MONTA O ARRAY CORRETO COM TODOS OS REGISTROS
    	$linha = 0;
   		while(($dados = fgetcsv($fp, 0, $tipo)) !== FALSE){
    		
    		$quant_campos = count($dados);
    		
    		for($i = 0; $i < $quant_campos; $i++){
    			
    			//echo $linha;
    			
    			if ($linha == 0){
    				
    				if ($diretorio == $dir.'contatos00'){
    					
    					$topo[$i] = $dados[$i];
    					
    				} else {
    					
    					$topo[$i] = $postGet['topo'][$i];
    					
    					echo $i;
    					
    				}
	    			
	    			$topo[$i] = $this->limpaCampo($topo[$i], true);
					
	    			if ($diretorio != $dir.'contatos00'){
	    				
	    				$post[$linha][$postGet[$topo[$i]]] = utf8_encode($dados[$i]);
	    				$post[$linha]['id_lista'] = $lista;
	    				
	    			} else {
	    				
						if ($topo_conf == 'nao'){
								
							$post[$linha][$postGet[$topo[$i]]] = utf8_encode($dados[$i]);
							$post[$linha]['id_lista'] = $lista;
							
						}
						
	    			}
	    			
    			} else {
    				
    				$post[ $linha ][ $postGet[ $topo[$i] ] ] = $this->limpaCampo(utf8_encode($dados[$i]));
    				$post[ $linha ]['id_lista'] = $lista;
    				
    			}
    			
    		}
    		
    		$linha ++;
    		
    	}
    	
    	// ENVIA TODOS CONTATOS MULTIPLOS PARA O POSTGRESQL
    	$file = $this->view->backend.'/api/contatos/new-contato-multiplos';
    	$result = $this->httpPost($file, $post);
    	
    	return $result;
    	
    }
    
    private function limpaCampo($string, $topo = NULL) {
    	
    	if ($topo){
    		$string = str_replace(' ', '-', $string);
    		$string = str_replace('@', '-', $string);
    		$string = str_replace('(', '', $string);
    		$string = str_replace(')', '', $string);
    		$string = str_replace('.', '-', $string);
    	}
    	
    	return $string;
    	
    }
    
    private function copiar_diretorio($diretorio, $destino, $ver_acao = false)
    {
      
		if ($destino{strlen($destino) - 1} == '/'){
			$destino = substr($destino, 0, -1);
		}
     
		if (!is_dir($destino)){
			
			if ($ver_acao){
				
				echo "Criando diretorio {$destino}\n";
				
			}
			
			mkdir($destino, 0755);
         
		}
         
		$folder = opendir($diretorio);
         
		while ($item = readdir($folder)){
			
			if ($item == '.' || $item == '..'){
				continue;
            }
            
			if (is_dir("{$diretorio}/{$item}")){
				
				copy_dir("{$diretorio}/{$item}", "{$destino}/{$item}", $ver_acao);
				
			}else{
				
				if ($ver_acao){
					
					echo "Copiando {$item} para {$destino}"."\n";
					
				}
				
				copy("{$diretorio}/{$item}", "{$destino}/{$item}");
			}
			
		}
      
	}
    
    private function delTree($dir) {
		
    	$files = array_diff(scandir($dir), array('.','..'));
		foreach ($files as $file) {
			(is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
		}
    	return rmdir($dir);
    	
    }
    
    private function redirect_post($url, array $data)
	{
    
		echo '<html xmlns="http://www.w3.org/1999/xhtml">';
		echo '<head>';
		echo '<script type="text/javascript">';
		echo 'function closethisasap() {';
		echo 'document.forms["redirectpost"].submit();';
		echo '}';
		echo '</script>';
		echo '</head>';
		echo '<body onload="closethisasap();">';
		echo '<form name="redirectpost" method="post" action="'.$url.'">';
			if ( !is_null($data) ) {
				foreach ($data as $k => $v) {
					
					if (is_array($v)){
						
						foreach($v as $key => $var){
							
							echo '<input type="hidden" name="' . $k . '[]" value="' . $var . '">';
							
						}
						
					} else {
						echo '<input type="hidden" name="' . $k . '" value="' . $v . '">';
					}
					
				}
			}
		echo ' </form>';
		echo '</body>';
		echo '</html>';
	    exit;
	    
	}
    
    protected function arquivaContatos($config)
    {
    	 
    	$diretorioPasta = $_SERVER['DOCUMENT_ROOT'].'/assets/importacao/'.time();
    	$criaPasta = mkdir($diretorioPasta, 0777);
    	 
    	$shell = shell_exec('split -d -l 2000 '.$_SERVER['DOCUMENT_ROOT'].'/'.$config['arquivo'].' '.$diretorioPasta.'/contatos ');
    	 
    	return time();
    	 
    }
    
	protected function httpPost($url,$params)
    {

    	$postData = http_build_query($params);
    	
		$ch = curl_init();
		
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, count($postData));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		
		$output = curl_exec($ch);
		curl_close($ch);
		
		return $output;
		
    }

}