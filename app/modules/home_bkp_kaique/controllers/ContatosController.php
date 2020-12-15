<?php

include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class ContatosController extends My_Controller 
{
	
	public function ini()
	{
    	$this->view->cssPag = '<link rel="stylesheet" type="text/css" href="assets/'.$this->view->baseModule.'/css/contatos.css">';
    	
    	$post = $this->_request->getPost();
 
	}
	
	public function exportarAction()
    {
    	$params = $this->_request->getParams();
    	
    	$url = $this->view->backend.'/api/contatos/get-geral?id_lista='.$params['id'].'&limit=99999999';
    	
    	$post['id_usuario'] = $this->me->id_usuario;
    	$this->view->result = json_decode(file_get_contents($url));
    	
    	$csv  = 'Nome;';
    	$csv .= 'Sobrenome;';
    	$csv .= 'Data de nascimento;';
    	$csv .= 'Email;';
    	$csv .= 'Celular;';
    	$csv .= 'CPF;';
    	$csv .= 'Empresa;';
    	$csv .= 'Cargo;';
    	$csv .= 'Telefone Comercial;';
    	$csv .= 'Telefone Residencial;';
    	$csv .= 'Pais;';
    	$csv .= 'Estado;';
    	$csv .= 'Cidade;';
    	$csv .= 'Bairro;';
    	$csv .= 'Endereco;';
    	$csv .= 'Cep;';
    	$csv .= 'Editavel 1;';
    	$csv .= 'Editavel 2;';
    	$csv .= 'Editavel 3;';
    	$csv .= 'Editavel 4;';
    	$csv .= 'Editavel 5;';
    	$csv .= 'Editavel 6;';
    	$csv .= 'Editavel 7;';
    	$csv .= 'Editavel 8;';
    	$csv .= 'Editavel 9;';
    	$csv .= 'Editavel 10;';
    	$csv .= 'Editavel 11;';
    	$csv .= 'Editavel 12;';
    	$csv .= 'Editavel 13;';
    	$csv .= 'Editavel 14;';
    	$csv .= 'Editavel 15;';
    	$csv .= 'Editavel 16;';
    	$csv .= 'Editavel 17;';
    	$csv .= 'Editavel 18;';
    	$csv .= 'Editavel 19;';
    	$csv .= 'Editavel 20;';
    	$csv .= 'Editavel 21;';
    	$csv .= 'Editavel 22;';
    	$csv .= 'Editavel 23;';
    	$csv .= 'Editavel 24;';
    	$csv .= 'Editavel 25;';
    	$csv .= 'Editavel 26;';
    	$csv .= 'Editavel 27;';
    	$csv .= 'Editavel 28;';
    	$csv .= 'Editavel 29;';
    	$csv .= 'Editavel 30;';
    	$csv .= 'Editavel 31;';
    	$csv .= 'Editavel 32;';
    	$csv .= 'Editavel 33;';
    	$csv .= 'Editavel 34;';
    	$csv .= 'Editavel 35;';
    	$csv .= 'Editavel 36;';
    	$csv .= 'Editavel 37;';
    	$csv .= 'Editavel 38;';
    	$csv .= 'Editavel 39;';
    	$csv .= 'Editavel 40;';
    	$csv .= 'Data;';
    	$csv .= PHP_EOL;
    	
    	foreach ( $this->view->result->registros as $row ) {
    		
    		$csv .= $row->nome . ';';
    		$csv .= $row->sobrenome . ';';
    		$csv .= $row->data_nascimento . ';';
    		$csv .= $row->email . ';';
    		$csv .= $row->celular . ';';
    		$csv .= $row->campo1 . ';';
    		$csv .= $row->campo2 . ';';
    		$csv .= $row->campo3 . ';';
    		$csv .= $row->campo4 . ';';
    		$csv .= $row->campo5 . ';';
    		$csv .= $row->campo6 . ';';
    		$csv .= $row->campo7 . ';';
    		$csv .= $row->campo8 . ';';
    		$csv .= $row->campo9 . ';';
    		$csv .= $row->campo10 . ';';
    		$csv .= $row->campo11 . ';';
    		$csv .= $row->editavel_1 . ';';
    		$csv .= $row->editavel_2 . ';';
    		$csv .= $row->editavel_3 . ';';
    		$csv .= $row->editavel_4 . ';';
    		$csv .= $row->editavel_5 . ';';
    		$csv .= $row->editavel_6 . ';';
    		$csv .= $row->editavel_7 . ';';
    		$csv .= $row->editavel_8 . ';';
    		$csv .= $row->editavel_9 . ';';
    		$csv .= $row->editavel_10 . ';';
    		$csv .= $row->editavel_11 . ';';
    		$csv .= $row->editavel_12 . ';';
    		$csv .= $row->editavel_13 . ';';
    		$csv .= $row->editavel_14 . ';';
    		$csv .= $row->editavel_15 . ';';
    		$csv .= $row->editavel_16 . ';';
    		$csv .= $row->editavel_17 . ';';
    		$csv .= $row->editavel_18 . ';';
    		$csv .= $row->editavel_19 . ';';
    		$csv .= $row->editavel_20 . ';';
    		$csv .= $row->editavel_21 . ';';
    		$csv .= $row->editavel_22 . ';';
    		$csv .= $row->editavel_23 . ';';
    		$csv .= $row->editavel_24 . ';';
    		$csv .= $row->editavel_25 . ';';
    		$csv .= $row->editavel_26 . ';';
    		$csv .= $row->editavel_27 . ';';
    		$csv .= $row->editavel_28 . ';';
    		$csv .= $row->editavel_29 . ';';
    		$csv .= $row->editavel_30 . ';';
    		$csv .= $row->editavel_31 . ';';
    		$csv .= $row->editavel_32 . ';';
    		$csv .= $row->editavel_33 . ';';
    		$csv .= $row->editavel_34 . ';';
    		$csv .= $row->editavel_35 . ';';
    		$csv .= $row->editavel_36 . ';';
    		$csv .= $row->editavel_37 . ';';
    		$csv .= $row->editavel_38 . ';';
    		$csv .= $row->editavel_39 . ';';
    		$csv .= $row->editavel_40 . ';';
    		$csv .= $row->criado . ';';
    		$csv .= PHP_EOL;
    		
    	}
    
    	header('Content-Type: application/force-download');
    	header('Content-Disposition: attachment; filename=contatos.csv');
    	header('Content-Encoding: UTF-8');
    	header('Pragma: no-cache');
    	echo $csv; exit;
    }
	
	public function importacaoAction()
	{
		
		$post = $this->_request->getPost();
		
		if ($_POST['fase']){
		
			$this->view->diretorio = $_POST['arquivo'];
			$this->diretorio = $this->view->diretorio;
		
			$this->view->tipo = $_POST['tipo'];
			$this->tipo = $this->view->tipo;
		
			$this->view->lista = $_POST['lista'];
			$this->lista = $this->view->lista;
		
		
		}
		 
		if ($_POST['fase'] == '3'){
		
			foreach($_POST["id"] as $key=>$value)
			{
				$celular = str_replace('(', '', $_POST["celular"][$key]);
				$celular = str_replace(' ', '', $celular);
				$celular = str_replace(')', '', $celular);
				$celular = str_replace('-', '', $celular);
		
				$post['nome'] = $_POST["nome"][$key];
				$post['email'] = $_POST["email"][$key];
				$post['celular'] = $celular;
				$post['id_lista'] = $post['lista'];
		
				$edt = $this->contatos->edit(NULL,$post,NULL,Model_Data::NOVO);
			}
		
			unlink($this->diretorio);
		
			$this->_messages->addMessage(array('success'=>'Registro(s) salvo(s) com sucesso.'));
			$this->_redirect('/'.$this->view->baseModule.'/contatos/');
			exit();
		
		}
		
		if ($_POST['upload'] == 'novo'){
			$file 		= $_FILES['uploadfile'];
			$path 		= '';
			$options 	= array(	'path' 		=> '',
					'where' 	=> NULL,
					'size' 	=> 1200,
					'type' 		=> 'file',
					'root' 		=> $this->pathUpload.'/csv/' );
			$upload =  new App_File_Upload($file, $path, $options);
			 
			$this->view->tipo = $_POST['tipo'];
			$this->tipo = $this->view->tipo;
			 
			$this->view->diretorio = 'assets/uploads/csv/'.$upload->_where();
			$this->diretorio = $this->view->diretorio;
			 
		}
		
	}
	
    public function indexAction ()
    {
    	$post = $this->_request->getPost();
    	$params = $this->_request->getParams();
    	$this->view->id = $this->id;
    	
    	$page = (isset($_GET['p'])) ? intval($_GET['p']) : 1;
    	
    	if ($params['t'] == 'g'):
    	
    		$this->view->tituloPag 	= 'Minhas listas de contato';

    		if ( !$params['id_usuario'] ) {
    			$params['id_usuario'] = array('0'=>'0');
    		}
    		
    		// FILTRO POR USUARIOS
    		if ( !array_diff ( $params['id_usuario'], $this->me->familia ) ){
    			$id_usuario = implode(',', $params['id_usuario']);
    		} else {
    			$id_usuario = implode(',', $this->me->familia);
    		}
    		
    		// RESULT SELECT
    		$url = $this->view->backend.'/api/contatos/get-listas?id_usuario='.$id_usuario.'&limit=99999&order=id_lista-DESC&oculto=0';
    		$this->view->result = json_decode( file_get_contents( $url ) );
    		$this->view->result = $this->view->result->registros;
    		
    	
    	else:
    	
	    	$duplicados = file_get_contents($this->view->backend.'api/contatos/get-duplicados?id_lista='.base64_encode($params['id_lista']).'&token='.base64_encode($this->me->id_usuario));
	    	$this->view->duplicados = json_decode($duplicados);
	    	
	    	$lista = file_get_contents($this->view->backend.'api/contatos/get-listas?id_lista='.$params['id_lista']);
	    	$this->view->lista = json_decode($lista);
	    	$this->view->lista = current($this->view->lista->registros);
	    	
	    	if ( $this->view->duplicados->total_registros > 0 && $this->view->lista->duplicados == 'manter-padrao' && $params['duplicados'] != 'true'){
	    		$this->_redirect($this->view->baseModule.'/contatos?t=c&id_lista='.$params['id_lista'].'&duplicados=true');
	    	}
    	
    		$this->view->tituloPag 	= 'Contatos - '.$this->view->lista->lista;
    		$this->view->jsPag = '<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js?v=1.12"></script>
    				<script src="assets/home/js/relatorios.js"></script>  ';
    		
    		
	    	// FILTRO DE LIMITE
			if ( $params['limit'] == NULL  ){
				
				$params['limit'] = 10;
				
			} else {
				
				if ( $params['limit'] != 10 && $params['limit'] != 25 && $params['limit'] != 50 && $params['limit'] != 100 && $params['limit'] != 250 && $params['limit'] != 500 ){
					
					$params['limit'] = 10;
					
				}
				
			}
			
			if ( $params['download'] ) {
				$params['limit'] = 2000;
			}
    		
    		$url = $this->view->backend.'/api/contatos/get-geral?id_lista='.$params['id_lista'].'&limit=20&p='.$page.'&celular='.$params['celular'].'&limit='.$params['limit'];
    		
    		$this->view->result = json_decode(file_get_contents( $url ) );
    		
    		$this->contatosDownload( $this->view->result, $params, ';' );
    	
    	endif;
    	
    	
    }
    
    private function contatosDownload( $result, $get, $formato )
    {
    
    	if ( $get['download'] ) {
    			
    		if ( $get['arquivo'] != '' ) {
    
    			$name = $get['arquivo'];
    
    		} else {
    
    			$name = time().$this->me->id_usuario.'.csv';
    
    		}
    			
    		$root = $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/csv/';
    			
    		// ABRE/CRIA O ARQUIVO
    		$fp = fopen($root.$name, 'a');
    			
    		// INICIA A VARIAVEL DO CSV
    		$csv = NULL;
    			
    		// MONTA O TOPO DO ARQUIVO
    		if ( $get['p'] == 1 ) {
    
    			$csv .= 'CELULAR';
    			$csv .= $formato;
    			
    			$csv .= 'NOME';
    			$csv .= $formato;
    			
    			$csv .= 'SOBRENOME';
    			$csv .= $formato;
    			
    			$csv .= 'DATA DE NASCIMENTO';
    			$csv .= $formato;
    			
    			$csv .= 'E-MAIL';
    			$csv .= $formato;
    			
    			$csv .= 'CPF';
    			$csv .= $formato;
    			
    			$csv .= 'EMPRESA';
    			$csv .= $formato;
    			
    			$csv .= 'CARGO';
    			$csv .= $formato;
    			
    			$csv .= 'TELEFONE COMERCIAL';
    			$csv .= $formato;
    			
    			$csv .= 'TELEFONE RESIDENCIAL';
    			$csv .= $formato;
    			
    			$csv .= 'PAIS';
    			$csv .= $formato;
    			
    			$csv .= 'ESTADO';
    			$csv .= $formato;
    			
    			$csv .= 'CIDADE';
    			$csv .= $formato;
    			
    			$csv .= 'BAIRRO';
    			$csv .= $formato;
    			
    			$csv .= 'ENDERECO';
    			$csv .= $formato;
    			
    			$csv .= 'CEP';
    			$csv .= $formato;
    			
    			for ($i = 1; $i <= 40; $i++) {
    			
    				$csv .= 'EDITAVEL '.$i;
    				$csv .= $formato;
    				
    			}
    			
    			
    			$csv .= PHP_EOL;
    
    		}
    			
    		foreach ( $result->registros as $row ):
    		
    			$row = (array)$row;
    			
	    		$csv .= $row['celular'];
	    		$csv .= $formato;
	    
	    		$csv .= $row['nome'];
	    		$csv .= $formato;
	    		
	    		$csv .= $row['sobrenome'];
	    		$csv .= $formato;
	    		
	    		$csv .= $row['data_nascimento'];
	    		$csv .= $formato;
	    		
	    		$csv .= $row['email'];
	    		$csv .= $formato;
	    		
	    		$csv .= $row['campo1'];
	    		$csv .= $formato;
	    		
	    		$csv .= $row['campo2'];
	    		$csv .= $formato;
	    		
	    		$csv .= $row['campo3'];
	    		$csv .= $formato;
	    		
	    		$csv .= $row['campo4'];
	    		$csv .= $formato;
	    		
	    		$csv .= $row['campo5'];
	    		$csv .= $formato;
	    		
	    		$csv .= $row['campo6'];
	    		$csv .= $formato;
	    		
	    		$csv .= $row['campo7'];
	    		$csv .= $formato;
	    		
	    		$csv .= $row['campo8'];
	    		$csv .= $formato;
	    		
	    		$csv .= $row['campo9'];
	    		$csv .= $formato;
	    		
	    		$csv .= $row['campo10'];
	    		$csv .= $formato;
	    		
	    		$csv .= $row['campo11'];
	    		$csv .= $formato;
	    		
	    		for ($i = 1; $i <= 40; $i++) {
	    			
	    			$csv .= $row['editavel_'.$i];
	    			$csv .= $formato;
	    			
	    		}
	    			
	    		$csv .= PHP_EOL;
    
    		endforeach;
    			
    		fwrite($fp, $csv);
    		fclose($fp);
    			
    		if ( $get['p'] == $result->total_page ) {
    			$refresh = '0';
    		} else {
    			$refresh = '1';
    		}
    			
    		$retorno = array('arquivo'=>$name, 'refresh'=>$refresh, 'next'=>$get['p'] + 1);
    			
    		echo json_encode( $retorno ); exit;
    			
    	}
    
    }
    
    public function duplicadosAction()
    {
    	
    	$get = $this->_request->getParams();
    	
    	$urlApi = $this->view->backend.'/api/contatos/';
    	
    	$id_lista = $get['token'];
    	$id_usuario = base64_encode($this->me->id_usuario);
    	
    	$acao = $get['acao'];
    	
    	if ($acao == 'manter'){
    		
    		$openStatus = file_get_contents($urlApi.'status-duplicados?id_lista='.$id_lista.'&token='.$id_usuario.'&duplicados=manter');
    		
    		$this->_messages->addMessage(array('success'=>'Salvo com sucesso.'));
    		$this->_redirect('/'.$this->view->baseModule.'/contatos?t=c&id_lista='.base64_decode($get['token']));
    		
    	} else {
    		
    		$openStatus = file_get_contents($urlApi.'status-duplicados?id_lista='.$id_lista.'&token='.$id_usuario.'&duplicados=excluir');
    		$openDel = file_get_contents($urlApi.'del-duplicados?id_lista='.$id_lista.'&token='.$id_usuario);
    		
    		$this->_messages->addMessage(array('success'=>$openDel));
    		$this->_redirect('/'.$this->view->baseModule.'/contatos?t=c&id_lista='.base64_decode($get['token']));
    		
    	}
    	
    	exit;
    	
    }
    
    // LISTA
    public function novaListaAction()
    {
    	
    	$params = $this->_request->getParams();
    	$post = $this->_request->getPost();
    	
    	$post['lista'] = $_POST['nome_lista'];
    	$post['id_usuario'] = $this->me->id_usuario;
    	
    	$edt = $this->insertPostgre('index','nova-lista',$post, $params);
    	echo $edt; exit;
    	
    }
    
    public function listaAtualAction()
    {
    	
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

    	$il = strip_tags($_GET['il']);
    	
    	foreach($this->view->lista_contatos as $row){
    		if ($il == $row->id_lista){
    			echo '<option selected value="'.$row->id_lista.'">'.$row->lista.'</option>';
    		} else {
    			echo '<option value="'.$row->id_lista.'">'.$row->lista.'</option>';
    		}
    	}
    	 
    	exit();
    }
    
    public function selectListaAction()
    {
    	
    	$post = $this->_request->getPost();
    	$post['id_usuario'] = $this->me->id_usuario;

    	// FILTRO POR USUARIOS
	    $id_usuario = implode(',', $this->me->familia);
    	
    	$result = json_decode( file_get_contents($this->view->backend.'api/contatos/get-listas?id_usuario='.$id_usuario.'&limit=99999&oculto=0') );
    	$result = $result->registros;
    	
    	echo '<select onchange="ajax_lista_all'.$_GET["class"].'(\''.$_GET[id].'\');" class="lista lista_contato_modal lista_contato'.$_GET["class"].' select_lista" style="width:100%;">';
    	echo '<option value="">Selecione uma lista</option>';
    	foreach($result as $row){
    	    echo '<option value="'.$row->id_lista.'">'.$row->lista.'</option>';
    	}
    	echo '</select>'; exit;
    	
    }
    
    public function deletaListaAction()
    {
    	$params = $this->_request->getParams();
    	$post = $this->_request->getPost();
    	
    	$post['id_usuario'] = $this->me->id_usuario;
    	$del = $this->insertPostgre('index', 'deleta-lista', $post, $params);
    	
    	echo $del; exit;
    	
    }
    
    // CONTATOS
    public function novoContatoAction()
    {
    	
    	$post = $this->_request->getPost();
    	$new = $this->insertPostgre('index', 'novo-contato', $post);
    	echo $new; exit;
    	
    }
    
    public function editarAction()
    {
    	
    	$post = $this->_request->getPost();
    	$params = $this->_request->getParams();
    	
    	$params['id_contato'] = $params['id'];
    	
    	$this->view->id = $params['id'];
    	
    	$this->view->listas = json_decode( file_get_contents( $this->view->backend.'api/contatos/get-listas?id_usuario='.$this->me->id_usuario.'&limit=99999' ) );
    	$this->view->listas = $this->view->listas->registros;
    	
    	$this->view->contatos = json_decode( file_get_contents( $this->view->backend.'api/contatos/get-geral?id_contato='.$this->view->id ) );
    	$this->view->contatos = current ( $this->view->contatos->registros );
    	
    }
    
    public function listaEditarAction()
    {
    	
    	$params = $this->_request->getParams();
    	$this->view->id = $params['id'];
    	
    	$params['id_lista'] = $params['id'];
    	$this->view->lista_contatos = (array)$this->postgre('index','lista-atual', $post, $params);
    	
    }
    
    public function updateAction()
    {
    	
    	$post = $this->_request->getPost();
    	$params = $this->_request->getParams();
    	
    	$this->id = $params['id'];
    	$params['id_contato'] = $this->id;
    	
    	$edt = $this->api('api/contatos/edit-contato', $post, $params);
    	
    	if ($edt){
    		$this->_messages->addMessage(array('success'=>'Registro salvo com sucesso.'));
    		$this->_redirect('/'.$this->view->baseModule.'/contatos?t=c&id_lista='.$params['il']);
    	} else {
    		$this->_messages->addMessage(array('success'=>'Erro ao salvar, tente novamente mais tarde.'));
    		$this->_redirect('/'.$this->view->baseModule.'/contatos/editar/id/'.$this->id.'?il='.$params['il']);
    	}
    	
    }
    
    public function updateListaAction()
    {
    	
    	$post = $this->_request->getPost();
    	$params = $this->_request->getParams();
    	
    	$this->id = $params['id'];
    	$params['id_lista'] = $this->id;
    	
    	$edt = $this->updatePostgre('index','update-lista',$post,$params);
    	
    	if ($edt != '{}'){
    		$this->_messages->addMessage(array('success'=>'Registro salvo com sucesso.'));
    		$this->_redirect('/'.$this->view->baseModule.'/contatos/lista-editar/id/'.$this->id);
    	} else {
    		$this->_messages->addMessage(array('success'=>'Erro ao salvar, tente novamente mais tarde.'));
    		$this->_redirect('/'.$this->view->baseModule.'/contatos/lista-editar/id/'.$this->id);
    	}
    	 
    }
    
    public function listagemContatosAction()
    {
    	$contatos = new contatos();
    	$this->view->contatos = $contatos->fetchAll('id_lista = '.$this->id.'');
    	
    	foreach($this->view->contatos as $row){
    		$table  = '';
    		$table .= '<tr class="contato_'.$row[id_contato].'">';
    		$table .= '<th width="1"><i style="cursor:pointer;" onclick="deletar_contato(\''.$row[id_contato].'\');" class="fa fa-times"></i></th>';
    		$table .= '<th width="1"><a style="color:#666;" target="_blank" href="/'.$this->view->baseModule.'/contatos/editar/id/'.$row[id_contato].'"><i style="cursor:pointer;" class="fa fa-pencil"></i></a></th>';
    		$table .= '<th>'.$row[nome].'</th>';
    		$table .= '<th>'.$row[email].'</th>';
    		$table .= '<th>'.$row[celular].'</th>';
    		$table .= '</tr>';
    		echo $table;
    	}
    	exit();
    }
    
    public function deletaContatoAction()
    {
    	
    	$params = $this->_request->getParams();
    	
    	$post['id'] = $params['id'];
    	$del = $this->insertPostgre('index','del-contato',$post,$params);
    	echo $del; exit;
    	
    }
    
    public function delAction()
    {
    	
    	$post = $this->_request->getPost();
    	$get = $this->_request->getParams();
    	
    	$http['ids'] = $post;
    	$http['id_usuario'] = $this->me->id_usuario;
    	$http['id_lista'] = $get['id_lista'];
    	
		$postdata = http_build_query($http);
	
		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);
	
		$context  = stream_context_create($opts);
		$result = file_get_contents( $this->view->backend.'api/contatos/del-contato' , false, $context);
		
		$this->_messages->addMessage(array('success'=>'Registros excluido com sucesso.'));
		$this->_redirect('/'.$this->view->baseModule.'/contatos?t=c&id_lista='.$get['id_lista']);
    	
		echo $result; exit;
		
    }
    
}