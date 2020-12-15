<?php
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';
include_once 'app/models/operadora/twwClass.php';

class CampanhaGerenciamentoController extends My_Controller 
{
	
	public function ini()
	{
		
		
	}
	
	public function dados($params)
	{
		
		
		$this->view->tituloPag = 'Gerenciamento de campanha';
		$this->view->cssPag = '
    			<link rel="stylesheet" type="text/css" href="assets/site/css/nova-campanha.css">
    			<link rel="stylesheet" type="text/css" href="assets/site/css/calendario.css">
    			';
		 
		$this->view->id = $this->id = $params['id'];
		
		$campanha = new campanhas();
		$this->view->campanhas = $campanha->fetchAll('id_campanha = '.$this->id.'');
		
		$getContatos = file_get_contents($this->view->backend.'/api/contatos/get-geral?id_lista='.$this->view->campanhas[0]->id_lista);
		$getContatos = json_decode($getContatos);
		
		$getLista = file_get_contents($this->view->backend.'/api/contatos/get-listas?id_lista='.$this->view->campanhas[0]->id_lista);
		$getLista = current(json_decode($getLista)->registros);
		
		$this->view->totalContatos = $getContatos->total_registros;
		$this->view->nomeLista = $getLista->lista;
		
		$campanha_envio = new campanhas_envio();
		$valida = $campanha_envio->fetchAll('id_campanha = '.$this->id.' AND tipo_status != "Selecionar" ');
			
		if ( count( $valida ) > 0){
				
			$this->_messages->addMessage(array('success'=>'Essa campanha não pode ser editada.'));
			$this->_redirect($this->view->baseModule.'/campanha/campanhas');
			
		}
		
	}
	
	public function agendarAction()
	{
		
		$this->view->tituloPag 	= 'ZigZag • Agendar campanha';
		$params = $this->_request->getParams();
		$this->dados($params);
		
	}
	
	public function enviarAction()
	{
		
		$user = new usuarios();
		$this->view->user = $user->fetchAll('id_usuario = '.$this->me->id_usuario);
		
		$this->view->tituloPag 	= 'Enviar campanha';
		$params = $this->_request->getParams();
		$this->dados($params);
			
		$total_ativo = new campanhas();
		$this->view->total_ativo = $total_ativo->fetchAll('status = "ativo" AND id_campanha != '.$this->id.' AND id_usuario = '.$this->me->id_usuario);
		
		
	}
	
	public function enviarLoteAction()
	{
	
		$user = new usuarios();
		$this->view->user = $user->fetchAll('id_usuario = '.$this->me->id_usuario);
		
		$this->view->tituloPag 	= 'Enviar campanha por lote';
		$params = $this->_request->getParams();
		
		$this->dados($params);
			
		$total_ativo = new campanhas();
		$this->view->total_ativo = $total_ativo->fetchAll('status = "ativo" AND id_campanha != '.$this->id.' AND id_usuario = '.$this->me->id_usuario);
	
	}
	
	protected function msg($mensagem, $row)
	{
		
		$row = (array)$row;
		
		// MENSAGEM]
		$msg = $mensagem;
		
		$msg = preg_replace('/\[(.*?)\]/i', '['.strtolower('\\1').']', $msg);
		
		$msg = str_replace(['\n', "\\n", '/\n', '\/n', '\nh', "\\nh"], '', $msg);
		
		$campos = array();
		$campos['nome'] 				= '[nome]';
		$campos['sobrenome'] 			= '[sobrenome]';
		$campos['celular'] 				= '[celular]';
		$campos['celular'] 				= '[celular]';
		$campos['data_nascimento'] 		= '[data_nascimento]';
		$campos['email'] 				= '[email]';
		$campos['campo1'] 				= '[cpf]';
		$campos['campo2'] 				= '[empresa]';
		$campos['campo3'] 				= '[cargo]';
		$campos['campo4'] 				= '[telefone_comercial]';
		$campos['campo5'] 				= '[telefone_residencial]';
		$campos['campo6'] 				= '[pais]';
		$campos['campo7'] 				= '[estado]';
		$campos['campo8']		 		= '[cidade]';
		$campos['campo9']		 		= '[bairro]';
		$campos['campo10']		 		= '[endereço]';
		$campos['campo11']		 		= '[cep]';
		$campos['referencia']		 	= '[referencia]';
		
		for ($i = 1; $i <= 40; $i++) {
				
			$campos['editavel_'.$i] = '[editavel_'.$i.']';
				
		}
		
		foreach ( $campos as $key => $campo )
		{
			
			$msg = str_replace($campo, $row[$key], $msg);
			$msg = str_replace(strtoupper( $campo ), $row[$key], $msg);
			
		}
		
		return $msg;
		
	}
	
	protected function geraUrl($campanha, $celular, $id_contato)
	{
		
// 		$input = $campanha.'-'.$celular.'-'.date('Y-m-d H:i:s').'-'.$id_contato.'-'.time();
// 		$output = $this->shorturl($input, $id_contato);
// 		return $output;
// 		return $output[0];

		return $this->alphaID($campanha.$id_contato);
		
	}
	
	protected function alteraSaldo($quantidade, $id_usuario)
	{
	
		$this->plano_usuario = new Model_Data(new usuarios_planos());
		$this->plano_usuario->_required(array('sms_disponivel','id_usuario'));
		$this->plano_usuario->_notNull(array('sms_disponivel'));
	
		$usuarios_planos = new usuarios_planos();
		$this->view->usuarios_planos = $usuarios_planos->fetchAll('id_usuario = '.$id_usuario.' AND tipo = \'principal\'');
	
		$saldo = array();
		$saldo['sms_disponivel'] = $this->view->usuarios_planos[0]->sms_disponivel - $quantidade;
	
		if ($saldo['sms_disponivel'] == 0){
			$saldo['sms_disponivel'] = 'zero';
		}
	
		$updt = $this->plano_usuario->edit($this->view->usuarios_planos[0]->id_usuario_plano,$saldo,NULL,Model_Data::ATUALIZA);
	
		if ($updt){
			$result_updt = 'true';
		} else {
			$result_updt = 'false';
		}
	
		$result_saldo = array('saldo'=>$saldo['sms_disponivel'], 'result_updt'=>$result_updt);
	
		return $result_saldo;
	
	}
	
	protected function sendSms($msg, $celular, $url = null, $id_usuario, $login_sms, $password_sms)
	{
		
// 		usleep(25000);
		
		$result = array();
		
		$celular = str_replace('(', '', $celular);
		$celular = str_replace(')', '', $celular);
		$celular = str_replace(' ', '', $celular);
		$celular = str_replace('-', '', $celular);
		
		$numberTotal = strlen($celular);
		if ($numberTotal <= 11){
			$celular = '55'.$celular;
		}
		
		$user = new usuarios();
		$this->view->usuarios = $user->fetchAll('id_usuario = "'.$id_usuario.'"');
		$this->view->user = $this->view->usuarios[0];
		
		
		$dados = array();
		$dados['to'] = $celular;
		$dados['content'] = $msg.' '.$url;
		$dados['dlr'] = 'yes';
		$dados['dlr-url'] = 'http://backend.zigzag.net.br/api/callback';
		$dados['dlr-level'] = 1;
		$open = $this->enviarSms($dados, $login_sms, $password_sms);
			
		// DESCONTA NO SALDO, SOMENTE OS QUE FORAM ENVIADOS
		if ($open['retorno'] != 'false'){
		
			array_push($result, array(
					'sms'=>'true',
					'message_id'=>$open['message_id']
				)
			);
		
		} else {
			array_push($result, array(
					'sms'=>'false',
					'erro'=>$open['retorno']
				)
			);
		}
		
		return json_encode($result);
		
	}
	
	private function alteraCampanha($id, $campo)
	{
		
		$this->envio = new Model_Data(new campanhas_envio());
		$this->envio->_required(array(key($campo), 'modificado'));
		$this->envio->_notNull(array(key($campo)));
		
		$enviado = $this->envio->edit($id,$campo,NULL,Model_Data::ATUALIZA);
		
	}
	
	public function alteraCampanhaAction()
	{
	
		$this->campanha = new Model_Data(new campanhas());
		$this->campanha->_required(array('id_campanha','status'));
		$this->campanha->_notNull(array());
		
		$campo = $this->_request->getPost();
		
		if ($campo['status'] == 'inativo'){
			
			$enviado = $this->campanha->edit($campo['id'],$campo,NULL,Model_Data::ATUALIZA);
				
			if (!$enviado){
				$result = array('erro'=>'false','retorno'=>'Erro ao salvar, tente novamente mais tarde.');
			} else {
				$result = array('erro'=>'true');
			}
			
			echo json_encode($result); exit;
			
		}
		
		$campanha = new campanhas();
		$this->view->campanhas = $campanha->fetchAll('status = "ativo" AND id_usuario = '.$this->me->id_usuario);
		
		if ($this->view->planos[0]->campanhas_ativa <= count($this->view->campanhas)){
			
			$result = array('erro'=>'false','retorno'=>'Você atingiu o numero máximo de campahas ativa ('.$this->view->planos[0]->campanhas_ativa.'), aprimore seu plano ou inative outra campanha.');
		
		} else {
			
			$enviado = $this->campanha->edit($campo['id'],$campo,NULL,Model_Data::ATUALIZA);
			
			if (!$enviado){
				$result = array('erro'=>'false','retorno'=>'Erro ao salvar, tente novamente mais tarde.');
			} else {
				$result = array('erro'=>'true');
			}
			
		}
		
		echo json_encode($result); exit;

	}
	
	public function alteraStatusAction ()
	{
	
		$post = $this->_request->getPost();
		$params = $this->_request->getParams();
		
		$this->campanha = new Model_Data(new campanhas_envio());
		$this->campanha->_required(array('status', 'data_agenda', 'modificado'));
		$this->campanha->_notNull(array());
		
		$campanha = new campanhas_envio();
		$this->view->campanha = $campanha->fetchAll('id_campanha = '.$params['id']);
		
		$post['data_agenda'] = date('Y-m-d H-i', strtotime($post['data_agenda']));
		$enviado = $this->campanha->edit($this->view->campanha[0]->id_envio,$post,NULL,Model_Data::ATUALIZA);
		
		if ($enviado){
			
			$arquivo = 'assets/campanhas/agendamento/'.$this->view->campanha[0]->data_agenda.'~'.$this->view->campanha[0]->id_campanha.'.txt';
			if (file_exists($arquivo)){
				unlink($arquivo);
			}
			
			$infos = array();
			$infos['id'] = $this->view->campanha[0]->id_campanha;
			$infos['retorno'] = 'refresh';
			$infos['whitelabel'] = $this->view->GerenciadorCustom->slug;
				
			$name = 'assets/campanhas/agendamento/'.$post['data_agenda'].'~'.$infos['id'].'.txt';
			$text = json_encode($infos);
			$file = fopen($name, 'a');
			fwrite($file, $text);
			fclose($file);
			echo 'true';
			
			exit;
			
		}
		
	
	}
	
	public function rotinaFtpAction()
	{
	    
	    $dirFtp = $_SERVER['DOCUMENT_ROOT'].'/lotes/ftp/';
        
	    $fila = scandir( $dirFtp );
	    unset( $fila[0] );
	    unset( $fila[1] );
	    
	    foreach ( $fila as $arquivo )
	    {
	    
	        $fp = fopen($dirFtp.$arquivo, 'r');
            $dados = json_decode( fgets( $fp ) );
            fclose($fp);
            
            $url = $this->view->backend.'api/importacao/consulta-pasta?pasta='.$dados->diretorio;
            $openUrl = file_get_contents( $url );
            
            if ( $openUrl == 'false' ) {
                
                $dados->campanha = str_replace(' ', '%20', $dados->campanha);
                
                $urlRelatorio = $this->view->backend.'api/ftp-campanhas/rotina-relatorio?retorno_relatorio='.$dados->retorno_relatorio.'&campanha='.$dados->campanha.'&id_campanha='.$dados->id_campanha.'&pasta_usuario='.$dados->pasta_usuario.'&id_usuario='.$dados->id_usuario;
                $openRelatorio = file_get_contents( $urlRelatorio );
                
                echo $dados->diretorio.': Importado com sucesso.<br/>';
                echo $dados->diretorio.': Acessou a url '.$urlRelatorio.'<br/><br/>';
                
                copy($dirFtp.$arquivo, $_SERVER['DOCUMENT_ROOT'].'/lotes/fila/'.$arquivo);
                unlink($dirFtp.$arquivo);
                
            } else {
                
                echo $dados->diretorio.': Importando contatos.';
                
            }
            
	    }
        
        exit;

// 	    http://homologacao.backend.naichesms.com.br/api/importacao/consulta-pasta?pasta=1512579757
	    
	}
	
	public function cronLoteAction()
	{
		
		$limite = 5000;
		$dir = $_SERVER['DOCUMENT_ROOT'].'/lotes';
		
		$fila = $dir.'/fila';
		$finalizado = $dir.'/finalizado';
		$pausa = $dir.'/pausa';
		
		$files = scandir($fila);
		unset($files[0]);
		unset($files[1]);
		$totalPastas = count($files);
		 
		if ($totalPastas == 0){
		
			die('Nenhum lote.');
		
		} else {
			
			// LE QUAL PAGINAÇÃO ESTÁ E FECHA
			$fp = fopen($fila.'/'.$files[2], "r");
			$dados = fgetcsv($fp, 0, ';');
			fclose($fp); 
			
// 			print_r(json_decode($dados[0]));
			
			$dados = $dados[0];
			$dados = json_decode($dados);
			$lote = $this->lote($dados, $limite);
			
			if ($lote['retorno'] == 'failed'){
			    
// 			    echo '<pre>'; print_r($files); print_r($dados); exit;
				
				$conteudoLog = json_encode($lote);
				
				$criaErro = fopen($dir.'/error_log/'. time() . '.txt', 'w');
				fwrite($criaErro, $conteudoLog);
				fclose($criaErro);
				
				if ( $_GET['admin'] == 'true' ){
					echo '<pre>';
					print_r($lote);
				}
				
				echo '<pre>';
				print_r( $dados );
				print_r( $lote ); exit;
				
			}
			
			// ATUALIZA A PAGINAÇÃO
			$fp = fopen($fila.'/'.$files[2], "w");
			// NEXT + INSERIDOS
			$dados->inseridos = intval ( $dados->inseridos ) + intval($limite);
			// CONTEUDO
			$conteudo = json_encode($dados);
			// ESCREVE
			$atualiza = fwrite($fp, $conteudo);
			// FECHA
			fclose($fp);
			
			if ($lote['retorno'] == 'break'){

				// ENVIA PARA O BACKEND A CAMPANHA E QUANTIDADE DO LOTE QUE DEVE SER ENVIADO
				$backend = array();
				$backend['referencia'] = $dados->referencia;
				$backend['total'] = $dados->total;
				$backend['offset'] = $dados->offset;
				$backend['id_lote'] = $dados->id_lote;
				$backend['id_campanha'] = $dados->id_campanha;
				$backend['login_envio'] = $dados->login_envio;
				$backend['senha_envio'] = $dados->senha_envio;
				$backend['nome_arquivo'] = $dados->data_i.'@'.$dados->id_campanha.'@'.$dados->id_lote;
				
				$this->httpPost($this->view->backend.'/api/lotes/recebe-lote', $backend);
				
				// CRIA CAMPANHA NO REDIS PELO BACKEND
				$sql = new Zend_Db_Select($this->db);
				$sql->from(array('CAMPANHA'=>$this->config->tb->campanhas),array('id_campanha'));
				
				$sql->joinLeft(array('USER'=>$this->config->tb->usuarios),
				    'USER.id_usuario = CAMPANHA.id_usuario',array('*'));
				
				$sql->joinLeft(array('LOTES'=>$this->config->tb->campanhas_envio_lote),
				    'LOTES.id_campanha = CAMPANHA.id_campanha',array('*'));
				
				$sql->where('CAMPANHA.id_campanha = "'.$dados->id_campanha.'"');
				$sql->group('LOTES.id_lote');
				
				$sql = $sql->query(Zend_Db::FETCH_OBJ);
				$campanha = $sql->fetchAll();
				
				$campanha[0]->json_sms = json_decode( $this->view->GerenciadorCustom->json_sms );
				
				$redisCampanha = $this->httpPost($this->view->backend.'/api/lotes/redis-campanha', $campanha);
				
// 				echo '<pre>'; print_r( $campanha ); print_r( $redisCampanha ); print_r( $backend ); exit;
				
				// LE QUAL PAGINAÇÃO ESTA E FECHA
				$fpProx = fopen($fila.'/'.$files[3], "r");
				$getProx = fgetcsv($fpProx, 0, ';');
				fclose($fpProx);
				$getProx = $getProx[0];
				$getProx = json_decode($getProx);
				
				// SE FOR DA MESMA CAMPANHA, ELE VAI ATUALIZAR A PAGINAÇÃO
				if ($getProx->id_campanha == $dados->id_campanha){
					
					$fpProx = fopen($fila.'/'.$files[3], "w");
					
					// ATUALIZAR PARA SABER ONDE ESTÁ PARADO.
					$getProx->inseridos = intval ( $dados->qtdade );
					$getProx->qtdade = intval ( $getProx->qtdade ) + intval ( $dados->qtdade );
					
					// CONTEUDO
					$conteudo = json_encode($getProx);
					// ESCREVE
					$update = fwrite($fpProx, $conteudo);
					
					fclose($fpProx);
					
				}
				
				// E MOVE O ARQUIVO QUE TERMINOU PARA FINALIZADO
				rename($fila.'/'.$files[2], $finalizado.'/'.$files[2]);
				
				die('break');
				
			} else {
				
				print_r($lote); exit;
				
			}
				
			
			
		}
		
	}
	
	public function lote($periodos, $limite = 10)
	{
		
		$offset = $periodos->inseridos;
		
		if ($limite > $periodos->qtdade){
			$limite = $periodos->qtdade;
		}
		
// 		echo '<pre>'; print_r( $periodos ); exit;
		
		$apiUrl = $this->view->backend.'/api/contatos/get-nao-duplicados?id_lista='.$periodos->id_lista.'&limit='.$limite.'&offset='.$offset;
		
		if ( $this->verificarLink( $apiUrl ) ){
		
			$celulares = file_get_contents($apiUrl);
			$celulares = json_decode($celulares);
			
			if ( count( $celulares ) == 0 ){
				
				return array('retorno'=>'failed','url'=>$apiUrl, 'erro'=>$celulares);
				die();
				
			}
			
			$celulares = $celulares->registros;
			
			$totalCelulares = count($celulares);
			
			$data_i = $periodos->data_i;
			$data_f = $periodos->data_f;
			
			
			// PEGANDO OS MINUTOS ENTRE OS PERIODOS
			$unix_data1 = strtotime($data_i);
			$unix_data2 = strtotime($data_f);
			
			$nHoras   = ($unix_data2 - $unix_data1) / 3600;
			$nMinutos = (($unix_data2 - $unix_data1) % 3600) / 60;
			
			$totalMinutos = $nHoras * 60;
			$totalMinutosDividido = $totalMinutos / $periodos->qtdade;
			
			$post = array();
			
			$i = $offset;
			
			if ( count( $celulares ) == 0 ){
				$retorno = array('retorno'=>'break','url'=>$apiUrl);
			}
			
			foreach($celulares as $row){
				
				// CASO CHEGUE AO NUMERO EXATO QUE TEM Q SER INSERIDO, ELE BREKA TUDO
				if ($i == $periodos->qtdade || $i > $periodos->qtdade):
					
					$retorno = array('retorno'=>'break','url'=>$apiUrl);
				
				else:
				
					$meuMinuto = ceil($totalMinutosDividido * $i);
					$minhaData = date('Y-m-d H:i', strtotime("+".$meuMinuto." minute",strtotime($data_i)));
					
					// MONTA URL
					$shorturl = $this->geraUrl($periodos->id_campanha, $row->celular, $row->id_contato);
					$url = $periodos->shorturl.'/m/'.$shorturl;
					
					// INSERE NO BANCO
					$post[$i]['id_contato'] = $row->id_contato;
					$post[$i]['id_landing_page'] = $periodos->id_landing_page;
					$post[$i]['id_campanha'] = $periodos->id_campanha;
					$post[$i]['shorturl'] = $shorturl;
					
					$post[$i]['login_jasmin'] = $periodos->login_envio;
					$post[$i]['smsc'] = '0000-00-00';
					$post[$i]['data_recibo'] = '0000-00-00';
					$post[$i]['data_dlr'] = '0000-00-00';
					
					$post[$i]['id_usuario'] = $periodos->id_usuario;
					$post[$i]['campanha'] = $periodos->campanha;
					$post[$i]['celular'] = $row->celular;
					$post[$i]['celular'] = str_replace(' ', '', $post[$i]['celular']);
					$post[$i]['celular'] = str_replace('(', '', $post[$i]['celular']);
					$post[$i]['celular'] = str_replace(')', '', $post[$i]['celular']);
					$post[$i]['celular'] = str_replace('-', '', $post[$i]['celular']);
					$post[$i]['celular'] = str_replace('.', '', $post[$i]['celular']);
					$post[$i]['data_lote'] = $minhaData;
					
					if ( $periodos->referencia == 1 ) {
					    $post[$i]['referencia'] = $row->referencia;
					}
					
					// MONTA MENSAGEM COM VARIAVEIS
					$post[$i]['mensagem'] = $this->msg($periodos->mensagem, $row);
					$post[$i]['mensagem'] = preg_replace(array("/(ç)/","/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","c a A e E i I o O u U n N"),$post[$i]['mensagem']);
					$post[$i]['mensagem'] = $post[$i]['mensagem'];
					
					/*
					 * coloquei 130 pq com 134 ainda ta cortando @capetão
					 */
					$post[$i]['mensagem'] = substr($this->antiInjection($post[$i]['mensagem']), 0, 150).' '.$url;
					
					$retorno = array('retorno'=>'refresh','url'=>$apiUrl);
				
				endif;
				
				$i++;
				
			}
			
// 			echo '<pre>'; print_r( $post ); exit;
			
			$url = $this->view->backend.'/api/sms/insert-multiplos?id_campanha='.$periodos->id_campanha;
			$envia = $this->httpPost($url, $post);
//             $envia = 'true-insert';
			
// 			echo '<pre>'; print_r( $envia ); print_r( $post ); exit;
			
			if ( $envia == 'true-insert' || $envia == 'true-delete' ) {
			    
			    $retorno['envia'] = $envia;
			    
			} else {
			    
			    $retorno = array('retorno'=>'failed','url'=>$url,'response'=>$envia);
			    
			}
		
		} else {
				
			$retorno = array('retorno'=>'failed','url'=>$apiUrl);
				
		}
		
		return $retorno;
		
	}
	
	public function delAction()
	{
	    
	    try {
	        
    	    $id = $this->_request->getParam('id');
    	    
    	    $this->data = new Model_Data(new campanhas());
    	    $this->data->_required(array('id_campanha'));
    	    $this->data->_notNull(array());
    	    
    	    $this->data2 = new Model_Data(new campanhas_envio());
    	    $this->data2->_required(array('id_campanha'));
    	    $this->data2->_notNull(array());
    	    
    	    $campanhas = new campanhas();
    	    $fetch = $campanhas->fetchAll("id_campanha = '".$id."' AND id_usuario = '".$this->view->me->id_usuario."'");
    	    
    	    if ( count($fetch) == 0 ){
    	        throw new \Exception('1');
    	    } else if ( $fetch[0]->status != 'inativo' ) {
    	        throw new \Exception('2');
    	    }
    	    
    	    $campanhas_envio = new campanhas_envio();
    	    $fetch_envio = $campanhas_envio->fetchAll("id_campanha = '".$id."'");
    	    
    	    if ( count($fetch_envio) == 0 ){
    	        throw new \Exception('3');
    	    } else if ( $fetch_envio[0]->status != 'Preparando Campanha' ) {
    	        throw new \Exception('4');
    	    } else if ( $fetch_envio[0]->tipo_status != 'Selecionar' ) {
    	        throw new \Exception('5');
    	    }
    	    
    	    $del = $this->data->_table()->getAdapter()->query('DELETE FROM zz_campanhas WHERE id_campanha = '.$id);
    	    $del2 = $this->data2->_table()->getAdapter()->query('DELETE FROM zz_campanhas_envio WHERE id_campanha = '.$id);
    	    
    	    if ( !$del && !$del2 ){
    	        throw new \Exception('6');
    	    }
    	    
    	    $this->_messages->addMessage(array('success'=>'Campanha cancelada com sucesso.'));
    	    $this->_redirect($this->view->baseModule.'/campanha/campanhas');
	    	
	    } catch ( \Exception $e ) {
	        
	        $this->_messages->addMessage(array('error'=>'Não foi possivel realizar essa ação no momento. COD: '.$e->getMessage()));
			$this->_redirect($_SERVER['HTTP_REFERER']);
	        
	    }
	    
	    exit;
	    
	    
	}
	
	private function verificarLink($url, $limite = 120){
		
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_TIMEOUT, $limite);
	    curl_setopt($curl, CURLOPT_NOBODY, true);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	
	    curl_exec($curl);
	    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE) == 200;
	    curl_close($curl);
	
	    return $status;
	    
	}
	
	public function delLoteAction()
	{
		
		$get = $this->_request->getParams();
		
		header('Content-Type: text/html; charset=utf-8');
		include_once 'app/models/tww/TWWLibrary.php';
		
		$tww = new tww($this->me->login_envio, $this->me->senha_envio);
		define("__TWW_NUMUSU__", $tww->login);
		define("__TWW_SENHA__", $tww->login);
		define("__TWW_URL__",  "https://webservices2.twwwireless.com.br/reluzcap/");
		
		$minhaCampanha = new campanhas();
		$minhaCampanha = $minhaCampanha->fetchAll('id_usuario = "'.$this->me->id_usuario.'" AND id_campanha = "'.$get['id_campanha'].'"');
		$minhaCampanha = count($minhaCampanha);

		if ($minhaCampanha > 0):
		
			$get['p'] = $get['p'] == NULL ? '0' : $get['p'];
		
			$enviados = file_get_contents($this->view->backend.'/api/sms/get-enviados?id_campanha='.$get['id_campanha'].'&p='.$get['p'].'&limit=20');
			echo $enviados;
			$enviados = json_decode($enviados);
			$enviados = $enviados->registros;
			
			$tww = new tww();
			
			foreach($enviados as $row):
			
				$dados = array();
				$dados['Agendamento'] = $row->data_lote;
				$dados['SeuNum'] = $row->id_sms_enviado;
				$del = $tww->delSms($dados);
				
				$dados = array();
				$dados['status'] = 'cancelado';
				$alteraCampanha = $this->alteraCampanha($get['id_campanha'], $dados);
				
				if ($del == 'OK'):
				
					$delSMS = file_get_contents($this->view->backend.'/api/sms/del-enviados?id='.$row->id_sms_enviado);
					echo $delSMS;
				
				endif;
				
			endforeach;
			
			
		endif;
		
		exit;
		
	}
	
	public function newLoteAction()
	{
		
		$this->data_lote = new Model_Data(new campanhas_envio_lote());
		$this->data_lote->_required(array('id_lote', 'id_campanha', 'data_i', 'data_f', 'status', 'qtdade', 'inseridos', 'paginacao', 'modificado', 'criado'));
		$this->data_lote->_notNull(array());
		
		$this->data_envi = new Model_Data(new campanhas_envio());
		$this->data_envi->_required(array('tipo_status'));
		$this->data_envi->_notNull(array());
		
		$this->data_camp = new Model_Data(new campanhas());
		$this->data_camp->_required(array('status'));
		$this->data_camp->_notNull(array());
		
		$this->bloq = new Model_Data(new usuarios_creditos_bloqueados());
		$this->bloq->_required(array('id_credito_bloqueado', 'id_campanha', 'id_usuario', 'creditos', 'status', 'modificado', 'criado'));
		$this->bloq->_notNull(array());
		
		$post = $this->_request->getPost();
		
		$creditos = 0;
		foreach ( $post['qtdade'] as $row ){
		    
		    foreach ( $row as $cred ){
		      $creditos = $creditos + $cred;
		    }
		    
		}
		
		$postBloq = array();
		$postBloq['id_campanha'] = $post['id_campanha'];
		$postBloq['id_usuario'] = $this->me->id_usuario;
		$postBloq['creditos'] = $creditos;
		
		$edt_envi = $this->bloq->edit(NULL,$postBloq,NULL,Model_Data::NOVO);
		
		$id = $post['id_campanha'];
		
		$total = count($post['data'][0]) - 1;
		
		$campanha_envio = new campanhas_envio();
		$campanha_envio = $campanha_envio->fetchAll('id_campanha = "'.$post['id_campanha'].'"');
		
		$campanha = new campanhas();
		$campanha = $campanha->fetchAll('id_campanha = "'.$post['id_campanha'].'"');
		
		$result = array();		
		for ($i = 0; $i <= $total; $i++) {
			
			$result[$i]['data_i'] = $post['data'][0][$i].' '.$post['hora_i'][0][$i];
			$result[$i]['data_f'] = $post['data'][0][$i].' '.$post['hora_f'][0][$i];
			$result[$i]['qtdade'] = $post['qtdade'][0][$i];
			$result[$i]['total'] = $post['total'];
			$result[$i]['id_campanha'] = $post['id_campanha'];
			$result[$i]['status'] = 0;
			$result[$i]['inseridos'] = 0;
			$result[$i]['paginacao'] = 0;
			$result[$i]['referencia'] = $campanha[0]->referencia;
			
		}
		
		$postAtualiza = array();
		$postAtualiza['tipo_status'] = $post['status'];
		$edt_envi = $this->data_envi->edit($campanha_envio[0]->id_envio,$postAtualiza,NULL,Model_Data::ATUALIZA);
		
// 		print_r($postAtualiza); exit;
		
		$postAtualiza = array();
		$postAtualiza['status'] = 'ativo';
		$edt_envi = $this->data_camp->edit($post['id_campanha'],$postAtualiza,NULL,Model_Data::ATUALIZA);
		
		if ( $_SESSION['lote_campanha_'.$id] != 'true' ){
			
			$offset = 0;
            $iConta = 0;	
            $iTotal = count( $result );
            $totalSms = 0;
            
			foreach($result as $post){
				
			    $iConta++;
			    
				$edt_lote = $this->data_lote->edit(NULL,$post,NULL,Model_Data::NOVO);
				
				$post['mensagem'] = str_replace(['\n', '\nh', '\\nh','\\n', "\n", "\\n", "\/n", "\\//n", "/\n", "//\\n"], '', $campanha[0]->mensagem);
				$post['id_lista'] = $campanha[0]->id_lista;
				$post['campanha'] = $campanha[0]->campanha;
				$post['id_landing_page'] = $campanha[0]->id_landing_page;
				$post['id_usuario'] = $campanha[0]->id_usuario;
				$post['total'] = $post['qtdade'];
				$post['offset'] = $offset;
				$post['message_id'] = 'LOTE';
				$post['id_lote'] = $edt_lote;
				$post['shorturl'] = $this->view->GerenciadorCustom->shorturl;
				
				$post['login_envio'] = $this->me->login_envio;
				$post['senha_envio'] = $this->me->senha_envio;

				$dadosEnvios = json_decode( $this->view->GerenciadorCustom->json_sms );
				
// 				$post['login_envio'] = $dadosEnvios->sms->username_sms;
// 	       		$post['senha_envio'] = $dadosEnvios->sms->password_sms;
				
				$totalSms = $post['qtdade'] + $totalSms;
				
				if ( $iConta == $iTotal ) {
    				
				    $post['total'] = $totalSms;
				    $post['qtdade'] = $totalSms;
				    $post['offset'] = 0;
				    
				    $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/lotes/fila/'.$this->limpaNomeArquivo($post['data_i']).'-'.$edt_lote.'.txt', "a");
    				$escreve = fwrite($fp, json_encode($post));
    				fclose($fp);
    				
				}
				
				$offset = $post['qtdade'] + $post['offset'];
				
			}
			
			$_SESSION['lote_campanha_'.$id] = 'true';
		
		}
		
		$this->_redirect($this->view->baseModule.'/campanha/campanhas');
		
	}
	
	public function sendCampanhaAction()
	{
		
		$get = $this->_request->getParams();
		$post = $this->_request->getPost();
		
		$campanha = new campanhas_envio();
		$this->view->campanha = $campanha->fetchAll('id_campanha = "'.$get['id'].'"');
		
		if ($this->view->campanha[0]->status == 'incompleto' || $this->view->campanha[0]->status == 'agendado'){
		
			$this->envio = new Model_Data(new campanhas_envio());
			$this->envio->_required(array('data_agenda','status', 'modificado'));
			$this->envio->_notNull(array());
			
			$post['data_agenda'] = date('Y-m-d H-i');
			$post['status'] = 'processando';
			
			$edt = $this->envio->edit($this->view->campanha[0]->id_envio,$post,NULL,Model_Data::ATUALIZA);
			
			$arquivo = 'assets/campanhas/agendamento/'.$this->view->campanha[0]->data_agenda.'~'.$this->view->campanha[0]->id_campanha.'.txt';
			if (file_exists($arquivo)){
				unlink($arquivo);
			}
			
			$infos = array();
			$infos['id'] = $get['id'];
			$infos['retorno'] = 'refresh';
			$infos['whitelabel'] = $this->view->GerenciadorCustom->slug;
			
			$name = 'assets/campanhas/agendamento/'.date('Y-m-d H-i').'~'.$infos['id'].'.txt';
			$text = json_encode($infos);
			$file = fopen($name, 'a');
			fwrite($file, $text);
			fclose($file);
			
			echo 'assets/campanhas/agendamento/'.date('Y-m-d H-i').'.txt';
		
		} else {
			
			echo 'false';
			
		}
		
		exit;
		
	}
	
	public function sendCampanhaPausaAction()
	{
		
		$get = $this->_request->getParams();
		$post = array();
		
		$this->envio = new Model_Data(new campanhas_envio());
		$this->envio->_required(array('status', 'pagina_pausa', 'pausa', 'modificado'));
		$this->envio->_notNull(array());
		
		$campanha = new campanhas_envio();
		$this->view->campanha_envio = $campanha->fetchAll('id_campanha = "'.$get['id'].'"');
		
		print_r($this->view->campanha_envio);
		
		if ($get['tipo'] == 'pausa'){
			
			$post['status'] = 'pausado';
			$post['pausa'] = 'true';
			
			$origem = 'assets/campanhas/agendamento/'.$this->view->campanha_envio[0]->data_agenda.'~'.$this->view->campanha_envio[0]->id_campanha.'.txt';
			$destino = 'assets/campanhas/pausa/'.$this->view->campanha_envio[0]->data_agenda.'~'.$this->view->campanha_envio[0]->id_campanha.'.txt';
			copy($origem, $destino);
			unlink($origem);
			
			echo 'pausa';
			
		} else {
			
			$post['status'] = 'processando';
			$post['pausa'] = 'false';
			
			$origem = 'assets/campanhas/pausa/'.$this->view->campanha_envio[0]->data_agenda.'~'.$this->view->campanha_envio[0]->id_campanha.'.txt';
			$destino = 'assets/campanhas/agendamento/'.$this->view->campanha_envio[0]->data_agenda.'~'.$this->view->campanha_envio[0]->id_campanha.'.txt';
			copy($origem, $destino);
			unlink($origem);
			
			echo 'despausa';
			
		}
		
		$edt = $this->envio->edit($this->view->campanha_envio[0]->id_envio,$post,NULL,Model_Data::ATUALIZA);
		
		print_r($edt);
		
		exit;
		
	}
	
	public function sendEnvioAction()
	{
		
		$post = $this->_request->getPost();
		$params = $this->_request->getParams();
		
		// ARRAY RESULT
		$result = array();
		
		$sql = new Zend_Db_Select($this->db);
		$sql->from(array('CAMPANHA'=>$this->config->tb->campanhas),array('*'));
		
			$sql->joinLeft(array('USER'=>$this->config->tb->usuarios),
				'USER.id_usuario = CAMPANHA.id_usuario',array('login_envio','senha_envio'));
		
			$sql->where('CAMPANHA.id_campanha = "'.$params['id'].'"');
			$sql->group('CAMPANHA.id_campanha');
		
		$sql = $sql->query(Zend_Db::FETCH_OBJ);
		$this->view->campanha = $sql->fetchAll();
		
		// INFORMAÇÃO DO ENVIO DA CAMPANHA
		$campanha_envio = new campanhas_envio();
		$this->view->campanha_envio = $campanha_envio->fetchAll('id_campanha = "'.$this->view->campanha[0]->id_campanha.'"');
		
		if ($this->view->campanha_envio[0]->status == 'processando' || $this->view->campanha_envio[0]->status == 'agendado'){
		
			// MONTANDO O GET/POST PARA LISTAR CONTATOS
			$params['p'] = $this->view->campanha_envio[0]->pagina_pausa + 1;
			$post['id_lista'] = $this->view->campanha[0]->id_lista;
			
			// LISTANDO CONTATOS/TOTAL DE CONTATOS/TOTAL DE PÁGINAS
			$contatos = json_decode(file_get_contents($this->view->backend.'/api/contatos/get-geral?id_lista='.$post['id_lista'].'&limit=10&p='.$params['p']));
			
			$totalContato = $contatos->total_registros;
			$totalPage = $contatos->total_page;
			$post['porcentagem'] = ceil($params['p'] / $totalPage * 100);
			
			if ($this->view->campanha_envio[0]->pagina_pausa < $totalPage){
				
				$infos = array(
						'id_usuario'=>$this->view->campanha[0]->id_usuario,
						'id_campanha'=>$this->view->campanha[0]->id_campanha,
						'porcentagem'=>$post['porcentagem'],
						'campanha'=>$this->view->campanha[0]->campanha
				);
					
				if ($params['p'] == 1){
					$tipoOpen = 'a';
				} else {
					$tipoOpen = 'r+';
				}
				
				$name = 'assets/campanhas/status/'.$this->view->campanha[0]->id_campanha.'.txt';
				$text = json_encode($infos);
				$file = fopen($name, $tipoOpen);
				fwrite($file, $text);
				fclose($file);
				
				array_push($result, array('retorno'=>'refresh', 'porcentagem'=>$post['porcentagem']));
				
				// ALTERANDO O STATUS DA CAMPANHA
				$this->campanha = new Model_Data(new campanhas());
				$this->campanha->_required(array('status', 'modificado'));
				$this->campanha->_notNull(array('status'));
				
				$campo = array();
				$campo['status'] = 'ativo';
				$campanha = $this->campanha->edit($params['id'],$campo,NULL,Model_Data::ATUALIZA);
				
				// PAGINA ATUALD O ENVIO (PAUSADA)
				$pagina_pausa['pagina_pausa'] = $this->view->campanha_envio[0]->pagina_pausa + 1;
				$this->alteraCampanha($this->view->campanha_envio[0]->id_envio, $pagina_pausa);
				
				foreach($contatos->registros as $row){
					
					// MONTA A MENSAGEM
					$mensagem = $this->msg($this->view->campanha[0]->mensagem, $row);
					
					if ($this->view->campanha[0]->id_landing_page){
						
						// MONTA URL
						$shorturl = $this->geraUrl($this->view->campanha[0]->id_campanha, $row->celular, $row->id_contato);
						$url = $this->view->GerenciadorCustom->shorturl.'/m/'.$shorturl;
						
					} else {
						
						$url = NULL;
						
					}
					
					// INSERE NO BANCO
					$post['id_contato'] = $row->id_contato;
					$post['id_landing_page'] = $this->view->campanha[0]->id_landing_page;
					$post['id_campanha'] = $this->view->campanha[0]->id_campanha;
					$post['shorturl'] = $shorturl;
					
					$post['id_usuario'] = $this->view->campanha[0]->id_usuario;
					$post['campanha'] = $this->view->campanha[0]->campanha;
					$post['mensagem'] = $mensagem;
					$post['celular'] = $row->celular;
					$post['celular'] = str_replace(' ', '', $post['celular']);
					$post['celular'] = str_replace('(', '', $post['celular']);
					$post['celular'] = str_replace(')', '', $post['celular']);
					$post['celular'] = str_replace('-', '', $post['celular']);
					
					$insereBanco = $this->insertPostgre('envio','new-enviado', $post, $params);
					
					// ENVIA SMS
					$tww = new tww($this->view->campanha[0]->login_envio, $this->view->campanha[0]->senha_envio);
					$dados = array();
					$dados['Celular'] = $row->celular;
					$dados['Mensagem'] = $mensagem.' '.$url;
					$dados['SeuNum'] = $insereBanco.'-'.$this->view->campanha[0]->id_usuario;
					$envia = $tww->enviarSms($dados);
					
					$postEdit = array();
					$postEdit['id'] = $insereBanco;
					$postEdit['message_id'] = $envia;
					$editBanco = file_get_contents($this->view->backend.'/envio/edit-enviado/?id='.$insereBanco.'&message_id='.$envia);
					
					$resultInsert = array('insert'=>$insereBanco,'retorno-sms'=>$envia);
					$resultEdit = array('edit'=>$editBanco);
					
					array_push($result, $post);
					array_push($result, $postEdit);
					array_push($result, $resultEdit);
					array_push($result, $resultInsert);
					
				}
				
			} else {
				
				// STATUS
				$status['status'] = 'finalizado';
				$this->alteraCampanha($this->view->campanha_envio[0]->id_envio, $status);
				
				$data_envio['data_envio'] = date('Y-m-d H:i');
				$this->alteraCampanha($this->view->campanha_envio[0]->id_envio, $data_envio);
				array_push($result, array('retorno'=>'final'));
				
				$origem = 'assets/campanhas/agendamento/'.$this->view->campanha_envio[0]->data_agenda.'~'.$this->view->campanha_envio[0]->id_campanha.'.txt';
				$destino = 'assets/campanhas/finalizado/'.$this->view->campanha_envio[0]->data_agenda.'~'.$this->view->campanha_envio[0]->id_campanha.'.txt';
				copy($origem, $destino);
				unlink($origem);
				
			}
			
			array_push($result, array('total_page'=>$totalPage));
		
		} else {
			
			array_push($result, array('retorno'=>'pausado'));
			
		}
		
		
		echo json_encode($result);
		exit;
		
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
	
	private function limpaNomeArquivo($name)
	{
	
		$name = str_replace('-', '', $name);
		$name = str_replace(' ', '', $name);
		$name = str_replace(':', '', $name);
		return $name;
	
	}
	
	private function antiInjection($sql){
	
		$sql = str_replace("'", "`", $sql);
		$sql = addslashes($sql);
		$sql = trim($sql);
		$sql = strip_tags($sql);
		$sql = (get_magic_quotes_gpc()) ? $sql : addslashes($sql);
		return $sql;
	
	}
	
	
}