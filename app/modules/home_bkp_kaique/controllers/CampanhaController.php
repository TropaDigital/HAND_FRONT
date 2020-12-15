<?php
	include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';
include_once 'app/models/operadora/twwClass.php';

class CampanhaController extends My_Controller 
{
	
	public function ini()
	{
    	$this->view->jsPag = '<script src="assets/site/js/campanha.js"></script>';
    	
    	$params = $this->_request->getParams();
    	$this->id = $params['id'];
    	$this->salva = $params['salva'];
    	$this->view->id = $this->id;
    	$this->view->id_pagina = $this->id_pagina = $params['id_pagina'];
    	$this->view->infos = $this->infos = $params['infos'];
    	
    	$this->data = new Model_Data(new campanhas());
    	$this->data->_required(array('id_campanha', 'id_landing_page', 'id_usuario', 'id_lista', 'somente_sms', 'mensagem', 'agenda', 'campanha', 'status', 'status_enviado', 'enviado_em', 'entregue', 'erros', 'visualizacoes', 'modificado', 'enviando', 'pausa', 'data_envio', 'criado'));
    	$this->data->_notNull(array('id_usuario', 'id_lista', 'campanha'));
    	
	}
	
	public function campanhaPeriodoAction()
	{
	    
	    $get = $this->_request->getParams();
	    $post = $this->_request->getPost();
	     
	    $this->campanhas = new Model_Data(new campanhas());
	    $this->campanhas->_required(array('periodo_inicio','periodo_final'));
	    $this->campanhas->_notNull(array());
	    
	    $post['periodo_inicio'] = $post['data-inicio'].' '.$post['hora-inicio'];
	    $post['periodo_final'] = $post['data-final'].' '.$post['hora-final'];
	     
	    $edt = $this->campanhas->edit( $get['id'], $post, NULL, Model_Data::ATUALIZA );
	    
	    print_r($edt); exit;
	    
	}
	
	public function delContatoAvulsoAction()
	{
	    
	    $get = $this->_request->getParams();
	    
	    $url = $this->view->backend.'api/contatos/del-contato-unique?id_contato='.$get['id_contato'].'&id_lista='.$get['id_lista'].'&id_usuario='.$get['id_usuario'];
	    
	    $file = file_get_contents( $url );
	    
	    echo $file; exit;
	    
	}
	
	public function newListaAvulsoAction()
	{

	    $post = $this->_request->getPost();
	    
	    $campos = array();
	    
	    foreach ( $post['campos'] as $key => $row )
	    {
	        
	        $campos[$row['name']] = $row['value'];
	        
	    }
	    
	    if ( $_GET['id_lista'] != 'undefined' ) {
	        
	        $novaLista = $_GET['id_lista'];
	        
	    } else {
	        
    	    //insere a lista
    	    $novaLista = file_get_contents( $this->view->backend.'api/contatos/new-lista?id_usuario='.$this->me->id_usuario.'&lista='.time().'&oculto=1' );
    	    
	    }
	    
	    //insere o contato
	    $campos['id_lista'] = $novaLista;
	    
	    $opts = array('http' =>
	        array(
	            'method'  => 'POST',
	            'header'  => 'Content-type: application/x-www-form-urlencoded',
	            'content' => http_build_query( $campos )
	        )
	    );
	    
	    $context  = stream_context_create($opts);
	    
	    $novoUsuario = file_get_contents( $this->view->backend.'api/contatos/new-contato', false, $context);
	    
	    if ( $novaLista && $novoUsuario ) {
	        
	        echo json_encode( array('retorno'=>'true', 'id_lista'=> $novaLista, 'id_contato'=>$novoUsuario ) );
	        
	    } else {
	        
	        echo json_encode( array('retorno'=>'false', 'msg'=>'Não foi possivel realizar essa ação no momento, tente novamente mais tarde.' ) );
	        
	    }
	    
	    exit;
	    
	}
	
	public function uploadAction()
	{
	
		$file 		= $_FILES['uploadfile'];
		$path 		= '';
		@$options 	= array(	'path' 		=> '',
				'where' 	=> NULL,
				'sizeW' 	=> 100000,
				'type' 		=> 'image',
				'root' 		=> $this->pathUpload.'imagens/template_senha/id/'.$this->me->id_usuario.'/' );
		@$upload =  new App_File_Upload($file, $path, $options);
		echo '/assets/uploads/imagens/template_senha/id/'.$this->me->id_usuario.'/'.$upload->_where(); exit;
	
	}
	
	public function apiCreateCampanhaAction()
	{
	    
	    $this->data = new Model_Data(new campanhas());
	    $this->data->_required(array('id_campanha', 'id_landing_page', 'id_usuario', 'id_lista', 'somente_sms', 'retorno_relatorio', 'status', 'campanha', 'mensagem', 'bloqueio', 'periodo_inicio', 'periodo_final', 'modificado', 'criado'));
	    $this->data->_notNull(array('id_usuario', 'id_lista', 'campanha'));
	    
	    $this->envio = new Model_Data(new campanhas_envio());
	    $this->envio->_required(array('id_envio', 'id_campanha', 'status', 'tipo_status', 'modificado', 'criado'));
	    $this->envio->_notNull(array('id_campanha'));
	    
	    $this->lote = new Model_Data(new campanhas_envio_lote());
	    $this->lote->_required(array('id_lote', 'id_campanha', 'data_i', 'data_f', 'status', 'qtdade', 'inseridos', 'paginacao', 'modificado', 'criado'));
	    $this->lote->_notNull(array('id_campanha', 'data_i', 'data_f'));
	    
	    $get = $this->_request->getParams();
	    
	    $get['periodo_inicio'] = date('Y-m-d H:i');
	    $get['periodo_final'] = date('Y-m-d H:i', strtotime("+60 days", strtotime( date('Y-m-d H:i') ) ) ); 
	    
	    $get['status'] = 'ativo';
	    $get['somente_sms'] = 'nao';
	    $get['bloqueio'] = '{"bloqueio":"n","tipo":null,"senha":null,"titulo_block":"","img":"\/assets\/uploads\/contas\/logo\/logosolo.png","bg":"#ff7a08","total_senha":"","botao_cancel":"sim","tipo_cancel":"url","url_botao_cancel":"","nome_botao_cancel":""}';
	    $campanha = $this->data->edit( NULL, $get, NULL, Model_Data::NOVO);
	    
	    if ( $campanha ) 
	    {
	        
	        $envioPost = [];
	        $envioPost['id_campanha'] = $campanha;
	        $envioPost['status'] = 'Preparando Campanha';
	        $envioPost['tipo_status'] = 'FTP';
	        $envio = $this->envio->edit( NULL, $envioPost, NULL, Model_Data::NOVO);
    	    
    	    if ( $envio )
    	    {
    	        
    	        $lotePost = [];
    	        $lotePost['id_campanha'] = $campanha;
    	        $lotePost['data_i'] = $get['data_i'];
    	        $lotePost['data_f'] = $get['data_f'];
    	        $lotePost['status'] = '1';
    	        $lotePost['paginacao'] = '1';
    	        $lotePost['qtdade'] = $get['qtdade'];
    	        $lotePost['inseridos'] = $get['inseridos'];
    	        $lote = $this->lote->edit( NULL, $lotePost, NULL, Model_Data::NOVO);
    	        
    	        echo json_encode( array( 'id_campanha'=>$campanha, 'id_envio'=>$envio, 'id_lote'=>$lote ) ); exit;
    	        
    	    }
    	    
	    }
	    
	   die('false');
	    
	}
	
	public function apiCreateTxtCampanhaAction()
	{
	    
	    $get = $_REQUEST;
	    
	    $dir = $_SERVER['DOCUMENT_ROOT'].'/lotes/ftp/';
	    $arquivo = str_replace('-', '', str_replace(' ', '', str_replace(':', '', $get['data_i'] ) ) ).'-'.$get['id_lote'].'.txt';
	    
	    $fp = fopen( $dir.$arquivo, 'a' );
	    fwrite( $fp, $get['json'] );
	    fclose( $fp );
	    
	    die('');
	    
	}
	
	public function paginasLandingAction(){
	
		function slug($str){
			$str = strtolower(trim($str));
				
			$str = preg_replace('/[^a-z0-9-]/', '-', $str);
			$str = preg_replace('/-+/', "-", $str);
				
			return $str;
		}
	
		$post = $this->_request->getPost();
	
		$this->pag = new Model_Data(new paginas_landing());
		$this->pag->_required(array('id_pagina', 'nome', 'html', 'slug', 'ordem', 'tag', 'id_landing_page', 'modificado', 'criado'));
		$this->pag->_notNull(array());
	
		$total_paginas = new paginas_landing();
		$this->view->total_paginas = $total_paginas->fetchAll('id_landing_page = '.$post['id']);
			
		$post = $this->_request->getPost();
		$post['tag'] = substr($post['nome'], 0, 3);
		$post['slug'] = slug($post['nome']);
		$post['id_landing_page'] = $post['id'];
		$post['ordem'] = count($this->view->total_paginas) + 1;
		$edt = $this->pag->edit(NULL,$post,NULL,Model_Data::NOVO);
	
		if ($edt){
			echo 'true';
		} else {
			echo 'false';
		}
	
		exit;
	
	}
	
	public function editarPaginaAction()
	{
	
		function slug($str){
			$str = strtolower(trim($str));
	
			$str = preg_replace('/[^a-z0-9-]/', '-', $str);
			$str = preg_replace('/-+/', "-", $str);
	
			return $str;
		}
	
		$this->pag = new Model_Data(new paginas_landing());
		$this->pag->_required(array('id_pagina', 'nome', 'slug', 'ordem', 'tag', 'modificado'));
		$this->pag->_notNull(array());
			
		$post = $this->_request->getPost();
		$post['tag'] = substr($post['nome'], 0, 3);
		$post['slug'] = slug($post['nome']);
		$post['id_landing_page'] = $post['id_landing_page'];
	
		if ($post['del'] == 'true'){
			$edt = $this->pag->_table()->getAdapter()->query('DELETE FROM zz_paginas_landing WHERE id_pagina = '.$post['id_pagina']);
		} else {
			$edt = $this->pag->edit($post['id_pagina'],$post,NULL,Model_Data::ATUALIZA);
		}
	
		if ($edt){
			echo 'true';
		} else {
			echo 'false';
		}
	
		exit;
	
	}
	
	public function campanhasNovoAction()
	{
	
		// POST
		$post = $this->_request->getPost();
	
		// DATA - CAMPANHAS
		$this->data = new Model_Data(new campanhas());
		$this->data->_required(array('id_campanha', 'id_landing_page', 'id_usuario', 'id_lista', 'referencia', 'somente_sms', 'status', 'campanha', 'mensagem', 'bloqueio', 'periodo_inicio', 'periodo_final', 'modificado', 'criado'));
		$this->data->_notNull(array('id_usuario', 'id_lista', 'campanha'));
	
		if ($post['block'] == 's'):
	
		if ($post['types'] == 'v'):
			$post['senha_campanha'] = $post['senha_variavel'];
		else:
			$post['senha_campanha'] = $post['senha_fixa'];
		endif;
	
		endif;
	
		$bloqueio = array();
		$bloqueio['bloqueio'] = $post['block'];
		$bloqueio['tipo'] = $post['types'];
		$bloqueio['senha'] = $post['senha_campanha'];
		$bloqueio['titulo_block'] = $post['titulo_block'];
		$bloqueio['img'] = $post['senha_img'];
		$bloqueio['bg'] = $post['senha_bg'];
		$bloqueio['total_senha'] = $post['total_senha'];
		$bloqueio['botao_cancel'] = $post['botao_cancel'];
		$bloqueio['tipo_cancel'] = $post['tipo_cancel'];
		$bloqueio['url_botao_cancel'] = $post['url_botao_cancel'];
		$bloqueio['nome_botao_cancel'] = $post['nome_botao_cancel'];
	
		$post['bloqueio'] = json_encode($bloqueio);
	
		// SELECT
		$campanhas = new campanhas();
		$this->view->campanhas = $campanhas->fetchAll(NULL, 'criado DESC', '1,0');
	
		// LISTAS
		$id_lista = implode(',', $post['id_lista']);
		$post['id_lista'] = $id_lista;
	
		// LANDING PAGE
		if ($post['id_landing']){
			$post['id_landing_page'] = $post['id_landing'];
		} else {
			$post['id_landing_page'] = 0;
		}
	
		// ID DO USUARIO
		$post['id_usuario'] = $this->me->id_usuario;
// 		$POST['MENSAGEM'] = STRIP_TAGS( $MENSAGEM );
		$edt = $this->data->edit(NULL,$post,NULL,Model_Data::NOVO);
	
		// ACRESCENTANDO ID_CAMPANHA NO ARRAY POST
		$post['id_campanha'] = $edt;
	
		if ($edt){
				
			$this->envio = new Model_Data(new campanhas_envio());
			$this->envio->_required(array('id_envio', 'id_campanha', 'status', 'tipo_status', 'modificado', 'criado'));
			$this->envio->_notNull(array('id_campanha'));
				
			$new = array();
			$new['id_campanha'] = $post['id_campanha'];
			$edt = $this->envio->edit(NULL,$new,NULL,Model_Data::NOVO);
				
			echo json_encode($post);
			exit;
				
		} else {
				
			echo json_encode(array('erro'=>'false'));
			exit;
				
		}
	
	}
	
	public function campanhasAvulsoNovoAction()
	{
	    
	    // POST
	    $post = $this->_request->getPost();
	    
	    if ( empty($post['campanha']) ) {
	        
	        $retorno = array('retorno'=>'false', 'mensagem'=>'Preencha o nome da campanha.', 'classe'=>'.campanha');
	        
	    } elseif ( empty($post['id_landing']) ) {
	        
	        $retorno = array('retorno'=>'false', 'mensagem'=>'Preencha um template.', 'classe'=>'.page_id_landing_page');
	        
	    } elseif ( empty($post['id_lista']) ) {
	        
	        $retorno = array('retorno'=>'false', 'mensagem'=>'Preencha algum celular para receber essa campanha.', 'classe'=>'.adicionar-contato-avulso');
	        
	    } elseif ( empty($post['mensagem']) ) {
	        
	        $retorno = array('retorno'=>'false', 'mensagem'=>'Preencha a mensagem da campanha.', 'classe'=>'.mensagem_sms');
	        
	    } elseif ( empty($post['periodo_inicio']) ) {
	        
	        $retorno = array('retorno'=>'false', 'mensagem'=>'Preencha o periodo inicial da campanha.', 'classe'=>'.calendario-inicio');
	        
	    } elseif ( empty($post['periodo_final']) ) {
	        
	        $retorno = array('retorno'=>'false', 'mensagem'=>'Preencha o periodo final da campanha.', 'classe'=>'.calendario-sobre-inicio');
	        
	    } else {
	    
    	    // DATA - CAMPANHAS
    	    $this->data = new Model_Data(new campanhas());
    	    $this->data->_required(array('id_campanha', 'id_landing_page', 'id_usuario', 'id_lista', 'referencia', 'somente_sms', 'status', 'campanha', 'mensagem', 'bloqueio', 'periodo_inicio', 'periodo_final', 'modificado', 'criado'));
    	    $this->data->_notNull(array('id_usuario', 'id_lista', 'campanha'));
    	    
    	    if ($post['block'] == 's'):
    	    
        	    if ($post['types'] == 'v'):
        	       $post['senha_campanha'] = $post['senha_variavel'];
        	    else:
        	        $post['senha_campanha'] = $post['senha_fixa'];
        	    endif;
    	    
    	    endif;
    	    
    	    $bloqueio = array();
    	    $bloqueio['bloqueio'] = $post['block'];
    	    $bloqueio['tipo'] = $post['types'];
    	    $bloqueio['senha'] = $post['senha_campanha'];
    	    $bloqueio['titulo_block'] = $post['titulo_block'];
    	    $bloqueio['img'] = $post['senha_img'];
    	    $bloqueio['bg'] = $post['senha_bg'];
    	    $bloqueio['total_senha'] = $post['total_senha'];
    	    $bloqueio['botao_cancel'] = $post['botao_cancel'];
    	    $bloqueio['tipo_cancel'] = $post['tipo_cancel'];
    	    $bloqueio['url_botao_cancel'] = $post['url_botao_cancel'];
    	    $bloqueio['nome_botao_cancel'] = $post['nome_botao_cancel'];
    	    
    	    $post['bloqueio'] = json_encode($bloqueio);
    	    
    	    // SELECT
    	    $campanhas = new campanhas();
    	    $this->view->campanhas = $campanhas->fetchAll(NULL, 'criado DESC', '1,0');
    	    
    	    // LISTAS
    	    $id_lista = $post['id_lista'];
    	    $post['id_lista'] = $id_lista;
    	    
    	    // LANDING PAGE
    	    if ($post['id_landing']){
    	        $post['id_landing_page'] = $post['id_landing'];
    	    } else {
    	        $post['id_landing_page'] = 0;
    	    }
    	    
    	    // ID DO USUARIO
    	    $post['id_usuario'] = $this->me->id_usuario;
    	    
    	    $campanha = $this->data->edit(NULL, $post, NULL, Model_Data::NOVO);
    	    
    	    // ACRESCENTANDO ID_CAMPANHA NO ARRAY POST
    	    $post['id_campanha'] = $campanha;
    	    
    	    if ( $campanha ) {
    	    
                $this->envio = new Model_Data(new campanhas_envio());
                $this->envio->_required(array('id_envio', 'id_campanha', 'status', 'tipo_status', 'modificado', 'criado'));
                $this->envio->_notNull(array('id_campanha'));
        	        
                $new['id_campanha'] = $campanha;
                
                $edt = $this->envio->edit(NULL, $new, NULL, Model_Data::NOVO);
                
                $post['id_campanha_envio'] = $edt;
                
                $retorno = array('retorno'=>'true', 'id_campanha'=>$campanha);
                
    	    } else {
    	        
    	        $retorno = array('retorno'=>'false', 'mensagem'=>'Erro ao enviar campanha, tente novamente mais tarde.', 'classe'=>'.campanha');
    	        
    	    }
	    
	    }
	    
	    echo json_encode( $retorno ); exit;
        
	}
	
	public function statusAction()
	{
		
		$post = $this->_request->getParams();
		
		$sql = new Zend_Db_Select($this->db);
		$sql->from(array('CAMPANHA'=>$this->config->tb->campanhas),array('*'));
		
		$sql->joinLeft(array('ENVIO'=>$this->config->tb->campanhas_envio),
		    'CAMPANHA.id_campanha = ENVIO.id_campanha',array('id_envio'));
		
		$sql->where('CAMPANHA.id_campanha = "'.$post['id'].'"');
		
		$sql = $sql->query(Zend_Db::FETCH_OBJ);
		$fetch = $sql->fetchAll();
		
		$this->campanhas = new Model_Data(new campanhas_envio());
		$this->campanhas->_required(array('status'));
		$this->campanhas->_notNull(array());
		
		$edt = $this->campanhas->edit( $fetch[0]->id_envio, $post, NULL, Model_Data::ATUALIZA );
		
		print_r( $edt ); exit;
		
	}
	
	public function statusEnvioAction()
	{
	    
	    $get = $this->_request->getParams();
	    $post = $this->_request->getPost();

        //remove credito bloqueado
        $this->bloq = new Model_Data(new usuarios_creditos_bloqueados());
        $this->bloq->_required(array('status', 'id_campanha', 'modificado'));
        $this->bloq->_notNull(array());
        $usuarios_creditos_bloqueados = new usuarios_creditos_bloqueados();
        $id_credito_bloqueado = $usuarios_creditos_bloqueados->fetchAll('id_campanha = '.$get['id']);
        $id_credito_bloqueado = current($id_credito_bloqueado)->id_credito_bloqueado;

        if ( $post['status_envio_redis'] == 'cancel' ){
            $edt_envi = $this->bloq->edit(NULL, array('status'=>0), NULL,Model_Data::ATUALIZA );
        }
	    
	    $this->campanhas = new Model_Data(new campanhas());
	    $this->campanhas->_required(array('status_envio_redis'));
	    $this->campanhas->_notNull(array());
	    
	    $edt = $this->campanhas->edit( $get['id'], $post, NULL, Model_Data::ATUALIZA );

	    include 'app/models/RedisHand.php';
	     
	    //start, pause, cancel, resume ou edit
	     
	    $redis = new redisHand();
	    $data = [
	        'idCampaign'=> $get['id'],
	        'idLot'=>'None',
	        'action'=>$post['status_envio_redis']
	    ];
	    
	    if ( $this->view->production != 'test' ){
	       $set = $redis->redis_campanha->lpush( 'load', json_encode($data) );
	    } else {
	        $set = $data;
	    }
	    
	    $result = [];
	    $result['db'] = $edt;
	    $result['redis'] = $set;
	    $result['data'] = $data;
	    $result['data_json'] = json_encode($data);
	    
	    echo json_encode($result); exit;
	    
	}
	
	public function novaCampanhaAction()
	{
		
		$this->view->tituloPag 	= 'Criar nova campanha';
		
		$this->view->cssPag = '
			<link rel="stylesheet" type="text/css" href="assets/site/css/nova-campanha.css?v=4">
			<link rel="stylesheet" type="text/css" href="assets/site/css/calendario.css?v=4">
			<link rel="stylesheet" type="text/css" href="assets/site/css/campanhas.css?v=4">
		';
		
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
		
		$landing_page = new landing_page();
		$this->view->landing_page = $landing_page->fetchAll("id_usuario IN (".$id_usuario.") AND status NOT IN ('excluido','template') AND nome IS NOT NULL ");
	
	}
	
	public function novaCampanhaAvulsoAction()
	{
		
		$this->view->tituloPag 	= 'Criar nova campanha';
		
		$this->view->cssPag = '
			<link rel="stylesheet" type="text/css" href="assets/site/css/nova-campanha-avulso.css?v=4">
			<link rel="stylesheet" type="text/css" href="assets/site/css/calendario.css?v=4">
			<link rel="stylesheet" type="text/css" href="assets/site/css/campanhas.css?v=4">
		';
		
		$this->view->jsPag = '<script src="assets/site/js/campanha.js?v=2"></script>';
		
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
		
		$landing_page = new landing_page();
		$this->view->landing_page = $landing_page->fetchAll("id_usuario IN (".$id_usuario.") AND status NOT IN ('excluido','template') AND nome IS NOT NULL ");
		
	}
	
	public function campanhasOldAction()
	{

		$this->view->tituloPag 	= 'Minhas campanhas';
		
		 $params = $this->_request->getParams();
		
		$this->view->busca_i = $busca_i;
		$this->view->busca_f = $busca_f;
		
		$this->view->cssPag = '
				<link rel="stylesheet" type="text/css" href="assets/'.$this->view->baseModule.'/css/campanhas.css">
				<link rel="stylesheet" type="text/css" href="assets/'.$this->view->baseModule.'/css/calendario.css">';
		
		$this->view->jsPag = '<link rel="stylesheet" type="text/css" href="assets/site/css/relatorios.css">
    			<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    			<script src="assets/home/js/relatorios.js"></script>';
		
		// GET PAGINAÇÃO
		if ($_GET['p']){
			$pagina = $_GET['p'];
		} else {
			$pagina = 0;
		}
		
		$db = new campanhas();
		$sql = $db->select()->from(array('CAMPANHAS'=>$this->config->tb->campanhas),array('*','status AS link'))
		
			->joinLeft(array('E'=>$this->config->tb->campanhas_envio),
				'CAMPANHAS.id_campanha = E.id_campanha',array('*','status AS status_enviado'))
				
			->where('CAMPANHAS.id_usuario = '.$this->me->id_usuario);
			
			if (!empty($params['data_i'])){
				$sql->where('CAMPANHAS.criado >= "'.($params['data_i']. '00:00:00').'"');
			}
			if (!empty($params['data_f'])){
				$sql->where('CAMPANHAS.criado <= "'.($params['data_f']. '99:99:99').'"');
			}
				
			if ($params['nome']){
				$sql->where('CAMPANHAS.campanha LIKE "%'.$params['nome'].'%"');
			}
			
			if (!empty($params['status'])){
				
				if ($params['status'] == 'ativas'):
				
					$sql->where('CAMPANHAS.status = "ativo"');
				
				else:
				
					if ($params['status'] != 'all' && $params['status'] != 'mes'):
					
						$sql->where('E.status = "'.$params['status'].'"');
						
					endif;
					
				endif;
			}
			
			$sql->order('CAMPANHAS.id_campanha DESC');
		
		$sql->setIntegrityCheck(false);
		
		$adapter = new Zend_Paginator_Adapter_DbSelect($sql);
		$paginator = new Zend_Paginator($adapter);
		$paginator->setItemCountPerPage ( 4 );
		$paginator->setPageRange ( 10 );
		$paginator->setCurrentPageNumber ( $pagina );
		$this->view->campanhas = $paginator;
		
	}
	
	public function campanhasAction()
	{
	
	    include 'app/models/RedisHand.php';
	    
	    $redis = new redisHand();
	    $this->view->redisCampanha = $redis->redis_campanha;;
	    
		$this->view->tituloPag 	= 'Minhas campanhas';
	
		$this->campanhas = new Model_Data(new campanhas_envio());
		$this->campanhas->_required(array('status'));
		$this->campanhas->_notNull(array());
		
		$this->view->data = $this->campanhas;
		
		// DATA - CAMPANHAS
		$this->dataCamp = new Model_Data(new campanhas());
		$this->dataCamp->_required(array('status'));
		$this->dataCamp->_notNull(array());
		
		$this->view->dataCamp = $this->dataCamp;
		
		$params = $this->_request->getParams();
	
		$this->view->busca_i = $busca_i;
		$this->view->busca_f = $busca_f;
	
		$this->view->cssPag = '
				<link rel="stylesheet" type="text/css" href="assets/'.$this->view->baseModule.'/css/campanhas.css">
				<link rel="stylesheet" type="text/css" href="assets/'.$this->view->baseModule.'/css/calendario.css">';
	
		// GET PAGINAÇÃO
		if ($_GET['p']){
			$pagina = $_GET['p'];
		} else {
			$pagina = 0;
		}
		
		if ( !$params['id_usuario'] ) {
			$params['id_usuario'] = array('0'=>'0');
		}
		
		// FILTRO POR USUARIOS
		if ( !array_diff ( $params['id_usuario'], $this->me->familia ) ){
			$id_usuario = implode(',', $params['id_usuario']);
		} else {
			$id_usuario = implode(',', $this->me->familia);
		}
		
		$db = new campanhas();
		$sql = $db->select()->from(array('CAMPANHAS'=>$this->config->tb->campanhas),array('*','status AS link', 'modificado AS atualizado'));
	
			$sql->joinLeft(array('E'=>$this->config->tb->campanhas_envio),
				'CAMPANHAS.id_campanha = E.id_campanha',array('*','status AS status_enviado'));
			
			$sql->joinLeft(array('U'=>$this->config->tb->usuarios),
				'CAMPANHAS.id_usuario = U.id_usuario',array('name_user AS nome'));
			
			$sql->joinLeft(array('L'=>$this->config->tb->campanhas_envio_lote),
				'CAMPANHAS.id_campanha = L.id_campanha',array('data_i', 'data_f'));
	
			// FILTRO POR USUARIOS
			$sql->where('CAMPANHAS.id_usuario IN ('. $id_usuario .')') ;
				
			
				
			if (!empty($params['data_i'])){
				
				$sql->where('CAMPANHAS.criado >= "'.($params['data_i']. '00:00:00').'"');
				
			}
			if (!empty($params['data_f'])){
				
				$sql->where('CAMPANHAS.criado <= "'.($params['data_f']. '99:99:99').'"');
				
			}
			
			if (!empty($params['data_i_periodo'])){
			
			    $sql->where('CAMPANHAS.periodo_inicio >= "'.($params['data_i_periodo']. '00:00:00').'"');
			
			}
			if (!empty($params['data_f_periodo'])){
			
			    $sql->where('CAMPANHAS.periodo_final <= "'.($params['data_f_periodo']. '99:99:99').'"');
			
			}

			if ($params['nome']){
				
				$sql->where('CAMPANHAS.campanha LIKE "%'.$params['nome'].'%"');
				
			}
			
			if ($params['status']){
				
				$sql->where('E.status = "'.$params['status'].'"');
				
			}
			
			if ($params['tipo_status']){
				
				$sql->where('E.tipo_status = "'.$params['tipo_status'].'"');
				
			}
				
			if (!empty($params['status'])){

				if ($params['status'] == 'ativas'):

					$sql->where('CAMPANHAS.status = "ativo"');

				else:

				if ($params['status'] != 'all' && $params['status'] != 'mes'):
					
					$sql->where('E.status = "'.$params['status'].'"');

				endif;
					
				endif;
			}
				
		$sql->group('CAMPANHAS.id_campanha');
		$sql->order('CAMPANHAS.id_campanha DESC');

		$sql->setIntegrityCheck(false);

		$adapter = new Zend_Paginator_Adapter_DbSelect($sql);
		$paginator = new Zend_Paginator($adapter);
		$paginator->setItemCountPerPage ( 4 );
		$paginator->setPageRange ( 10 );
		$paginator->setCurrentPageNumber ( $pagina );
		$this->view->campanhas = $paginator;
		
		
		// MONTA OS PERIODOS DAS CAMPANHAS
		$camp_periodo = new campanhas_envio_lote();
		
		$periodos = array();
		
		foreach( $this->view->campanhas as $row ){ $row = (object)$row;
			
			$fetch_periodo = $camp_periodo->fetchAll('id_campanha = "'.$row->id_campanha.'" ');
			$periodos[$row->id_campanha] = array();
			
			$i=0;
			foreach( $fetch_periodo as $rew ) {
				
				$periodos[$row->id_campanha][$i]['data_i'] = $rew['data_i'];
				$periodos[$row->id_campanha][$i]['data_f'] = $rew['data_f'];
				$periodos[$row->id_campanha][$i]['qtdade'] = $rew['qtdade'];
				
				$i++;
				
			}
			
		}
		
		$this->view->camp_periodo = $periodos;
		
	}
	
	public function relatorioAction()
	{
		
		$get = $this->_request->getParams();
		
		$campanhas = new campanhas();
		$this->view->row = $campanhas->fetchAll('id_campanha = '.$get['id']);
		$this->view->row = $this->view->row[0];
		
		$this->view->relatorio = current( json_decode( file_get_contents( $this->view->backend.'api/relatorios/get-campanha?id='. $this->view->row->id_campanha .'&id_lista='. $this->view->row->id_lista .'' ) ) );
		
// 		echo '<pre>'; print_r( $relatorio ); exit;
		
	}
	
	public function contatosDuplicadosAction()
	{
		
		$post = $this->_request->getPost();
		$get = $this->_request->getParams();
		
		$id_usuario = base64_encode($this->me->id_usuario);
		$id_lista = base64_encode($get['id']);
		
		$url = $this->view->backend.'api/contatos/get-duplicados?id_lista='.$id_lista.'&token='.$id_usuario;
		
		$getDuplicados = file_get_contents($url);
		
		echo $getDuplicados; exit;
		
	}
	
	public function campanhaApagarAction()
	{
		
		$this->data->_table()->getAdapter()->query('DELETE F FROM zz_campanhas F WHERE F.id_campanha = "'.$this->id.'" AND id_usuario = "'.$this->me->id_usuario.'"');
		echo $this->id; exit;
		
	}
	
	public function indexAction()
	{
		$this->_redirect('/');
	}
	
	public function enviarsmsAction()
	{
			
		$post = $this->_request->getPost();
			
		if ($post['id_landing']){
			$url = $this->view->GerenciadorCustom->shorturl.'/l/'.$post[id_landing];
		}
	
		$celulares = explode(',', $post['celular_sms']);
		
		$postSend = array();
		$i=0;
		foreach($celulares as $row){

		    $row = str_replace([')','(', ' ', '-'], '', $row);
		    
			$msg = preg_replace(array("/(ç)/","/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","c a A e E i I o O u U n N"),$post['msg']);
			$msg = substr($this->antiInjection($msg), 0, 134).' '.$url;
			$msg = str_replace(' ', '%20', $msg);
			
			$curl = curl_init();
			curl_setopt_array($curl, array(
			    CURLOPT_URL => "http://186.226.57.97:1401/send?to=".$row."&content=".$msg."&username=".$this->me->login_envio."&password=".$this->me->senha_envio.'&dlr-url=http://172.17.33.3:8789/&dlr-level=3&dlr-method=GET',
			    CURLOPT_RETURNTRANSFER => true,
			    CURLOPT_ENCODING => "",
			    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			    CURLOPT_CUSTOMREQUEST => "GET",
			    CURLOPT_POSTFIELDS => "",
			    CURLOPT_HTTPHEADER => array(
			        "cache-control: no-cache"
			    ),
			));
			
			$response = curl_exec($curl);
			$err = curl_error($curl);
			$info = curl_getinfo($curl);
			curl_close($curl);
			
			$msg = str_replace('%20', ' ', $msg);
			
			$postSend[$i]['id_contato'] = '0';
			$postSend[$i]['id_landing_page'] = '0';
			$postSend[$i]['id_campanha'] = '0';
			$postSend[$i]['shorturl'] = $post[id_landing];
			$postSend[$i]['celular'] = $row;
			$postSend[$i]['id_usuario'] = $this->me->id_usuario;
			$postSend[$i]['campanha'] = '0';
			$postSend[$i]['mensagem'] = $msg;
			$postSend[$i]['status'] = 'Teste';
			$postSend[$i]['referencia'] = '0';
			$postSend[$i]['id_mt'] = '0';
			$postSend[$i]['login_jasmin'] = $this->me->login_envio;
			$postSend[$i]['smsc'] = '0';
			$postSend[$i]['data_lote'] = date('Y-m-d H:i');
			
			if ( $err ) {
			    echo "cURL Error #:" . $err;
			} else {
			    echo $response;
			}
			
			$i++;
			
		}
		
		$url = $this->view->backend.'/api/sms/insert-multiplos?id_campanha=0';
		$envia = $this->httpPost($url, $postSend);
		
		print_r( $post );
		
		echo $envia;
		
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
	
	private function antiInjection($sql){
	
		$sql = str_replace("'", "`", $sql);
		$sql = addslashes($sql);
		$sql = trim($sql);
		$sql = strip_tags($sql);
		$sql = (get_magic_quotes_gpc()) ? $sql : addslashes($sql);
		return $sql;
	
	}
	
	public function cancelarAction()
	{
		
		$post = $this->_request->getPost();

        //remove credito bloqueado
        $this->bloq = new Model_Data(new usuarios_creditos_bloqueados());
        $this->bloq->_required(array('status', 'id_campanha', 'modificado'));
        $this->bloq->_notNull(array());
        $usuarios_creditos_bloqueados = new usuarios_creditos_bloqueados();
        $id_credito_bloqueado = $usuarios_creditos_bloqueados->fetchAll('id_campanha = '.$post['id'])->toArray();
        $id_credito_bloqueado = current($id_credito_bloqueado)->id_credito_bloqueado;

        echo $id_credito_bloqueado; exit;
		
		// STATUS
		$this->campanhas = new Model_Data(new campanhas_envio());
		$this->campanhas->_required(array('status'));
		$this->campanhas->_notNull(array());
		
		$post['status'] = 'Campanha cancelada';
		$edt = $this->campanhas->edit($post['id'],$post,NULL,Model_Data::ATUALIZA);
		
		// REMOVE NO FRONT
		$campanha_envios = new campanhas_envio_lote();
		$lotes = $campanha_envios->fetchAll('id_campanha = "'.$post['id'].'"');
		
		foreach ( $lotes as $row ) {
			
			$delTxtFront = unlink( $_SERVER['DOCUMENT_ROOT'].'/lotes/fila/'.date('YmdHi', strtotime($row->data_i)).'-'.$row->id_lote.'.txt' );
			
		}
		
		// URL BACKEND
		$url = $this->view->backend.'/api/lotes/cancel?id='.$post['id'].'&numusu='.$post['numusu'].'&senha='.$post['senha'];
		$file = file_get_contents( $url );

        $edt_envi = $this->bloq->edit(NULL, array('status'=>0), NULL,Model_Data::ATUALIZA );

        $this->_messages->addMessage(array('success'=>'Envios cancelado com sucesso.'));
		$this->_redirect( $this->view->baseModule.'/campanha/campanhas' );
		
		exit;
		
	}
	
}