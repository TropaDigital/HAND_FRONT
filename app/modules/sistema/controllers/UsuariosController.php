<?php
	
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class Painel_UsuariosController extends My_Controller 
{

	public function ini()
	{
		
		// PERMISSÃO PARA NIVEL 99
		$this->permissao(99, '/painel');
		
		$post = $this->_request->getPost();
		$params = $this->_request->getParams();
		
		// GERA O ID
		$this->view->id = $this->id = $params['id'];
		
		$this->view->tituloPag = 'ZigZag • Usuários';
		$this->view->cssPag = '<link rel="stylesheet" type="text/css" href="assets/site/css/index_new.css">';

		$this->usuarios = new Model_Data(new usuarios());
		$this->usuarios->_required(array('plano_zoug','callback','source_addr_sms','login_sms','password_sms','id_usuario','user','pass','empresa','emailEmp','telEmp','cnpj','name_user','email_user','sexo','tel_user','time','dias','type','expira','id_zoug','modificado','criado'));
		$this->usuarios->_notNull(array());
		
		$this->login = new Model_Data(new login());
		$this->login->_required(array('login','senha','nivel','email','ativo','id_usuario'));
		$this->login->_notNull(array());
		
		$this->plano = new Model_Data(new usuarios_planos());
		$this->plano->_required(array('id_usuario_plano','id_plano','id_usuario','tipo','sms_disponivel','modificado','criado'));
		$this->plano->_notNull(array());
		
	}
	
    public function indexAction ()
    {
    	
    	$get = $this->_request->getParams();
    	$where;
    	
    	if ($get['pi']){
    		$where .= ' AND USER.criado >= \''.$get[pi].'\' ';
    	}
    	
    	if ($get['pf']){
    		$where .= ' AND USER.criado <= \''.$get[pf].'\' ';
    	}
    	
    	if ($get['u']){
    		$where .= ' AND USER.empresa LIKE \'%'.$get[u].'%\' ';
    	}
    	
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('LOGIN'=>$this->config->tb->login),array('*'))
    	
    		->joinLeft(array('USER'=>$this->config->tb->usuarios),
    			'USER.id_usuario = LOGIN.id_usuario',array('*'))
    			
    		->joinLeft(array('CAMPANHA'=>$this->config->tb->campanhas),
    			'CAMPANHA.id_usuario = USER.id_usuario',array('count(id_campanha) AS total_campanha'))
    	
    		->where('LOGIN.nivel = 1'.$where)
    		->order('LOGIN.id_usuario DESC')
    		->group('USER.id_usuario');
    	
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$this->view->result = $sql->fetchAll();
    	
    }
    
    public function validaLoginAction (){
    
    	$post = $this->_request->getPost();
    	 
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('LOGIN'=>$this->config->tb->login),array('*'))
    
    	->where('LOGIN.login = \''.$post[login].'\'');
    
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$this->view->result = $sql->fetchAll();
    
    	$totalUser = count($this->view->result);
    	 
    	echo $totalUser == 0 ? $post['login'] : $post['login'].$totalUser;
    	exit();
    
    }
    
    public function editarUsuarioAction ()
    {
    	
    	
    	$post = $this->_request->getPost();
    	$params = $this->_request->getParams();
    	
    	//LOGIN
    	$post['user'] = 'zigzag';
    	$post['pass'] = 'zigzag';
    	$post['callback'] = 'backend.zigzag.net.br/callback/';
    	
    	// CASO EXISTE ID, FAZ A SELECT
    	if ($this->id){
    		
    		$planos = new planos();
    		$this->view->planos = $planos->fetchAll(NULL, 'valor ASC');
    		
    		$sql = new Zend_Db_Select($this->db);
    		$sql->from(array('USER'=>$this->config->tb->usuarios),array('*'))
    	
    			->joinLeft(array('LOGIN'=>$this->config->tb->login),
    				'USER.id_usuario = LOGIN.id_usuario',array('*'))
    				
    			->joinLeft(array('PLANO'=>$this->config->tb->usuarios_planos),
    				'PLANO.id_usuario = USER.id_usuario',array('*'))
    				
    			->order('USER.id_usuario DESC')
    			->where('USER.id_usuario = '.$this->id.' AND nivel = 1')
    			->group('USER.id_usuario');
    	
    		$sql = $sql->query(Zend_Db::FETCH_OBJ);
    		$this->view->result = $sql->fetchAll();
    			  
    		$this->view->row = $this->row = $this->view->result[0];
    			  
    	}
    	
    	$method = $_SERVER['REQUEST_METHOD'];
    	
    	// VERIFICA SE EXISTE POST, SE EXISTE FAZ UMA VALIDAÇÃO DE INSERT OU UPDATE
    	if ($method == 'POST'){
    		
    		$post['time'] = $post['time_inicio'].':'.$post['time_fim'];
    		
    		if ($this->id){
    			
    			$get = 'http://portal.zoug.net.br/api/editCentro';
    			$postdata = http_build_query($post);
    			
    			$opts = array('http' =>
    				array(
    					'method'  => 'POST',
    					'header'  => 'Content-type: application/x-www-form-urlencoded',
    					'content' => $postdata
    				)
    			);
    			
    			$context  = stream_context_create($opts);
    			$result = file_get_contents($get, false, $context);
    			 
    			$zoug = json_decode($result);
    			
    			if ($zoug){
    				
	    			// UPDATE
	    			if ($post['senha_user'] != $this->view->row->senha){
	    				$post['senha'] = md5($post['senha_user']);
	    			} else {
	    				$post['senha'] = $this->view->row->senha;
	    			}
	    			
	    			$postUser = array();
	    			$postUser['empresa'] = $post['empresa'];
	    			$postUser['emailEmp'] = $post['emailEmp'];
	    			$postUser['telEmp'] = $post['telEmp'];
	    			$postUser['cnpj'] = $post['cnpj'];
	    			$postUser['name_user'] = $post['name_user'];
	    			$postUser['email_user'] = $post['email_user'];
	    			$postUser['sexo'] = $post['sexo'];
	    			$postUser['tel_user'] = $post['tel_user'];
	    			$postUser['time'] = $post['time'];
	    			$postUser['dias'] = $post['dias'];
	    			$postUser['type'] = $post['type'];
	    			$postUser['expira'] = $post['expira'];
	    			$postUser['callback'] = $post['callback'];
	    			
	    			$db_user = $this->usuarios->edit($this->id,$postUser,NULL,Model_Data::ATUALIZA);
	    			$db_login = $this->login->edit($this->view->row->login,$post,NULL,Model_Data::ATUALIZA);
	    			
    			}
    			
	    	} else { 

	    		$get = 'http://portal.zoug.net.br/api/centro';
	    		$postdata = http_build_query($post);
	    		 
	    		$opts = array('http' =>
	    			array(
	    					'method'  => 'POST',
	    					'header'  => 'Content-type: application/x-www-form-urlencoded',
	    					'content' => $postdata
	    			)
	    		);
	    		 
	    		$context  = stream_context_create($opts);
	    		$result = file_get_contents($get, false, $context);
	    		
	    		$zoug = json_decode($result);
	    		
	    		$postUser = array();

	    		// VERIFICA A INTEGRAÇÃO COM A ZOUG
	    		if ($zoug[1]->error){
	    			
	    			$this->_messages->addMessage($zoug[1]->error);
	    			$this->_redirect('/'.$this->view->baseModule.'/'.$this->view->baseController.'/'.$this->view->baseAction.'/id/'.$this->id);
	    		
	    		} else {
	    			
	    			$postUser['login_sms'] = $zoug[1]->login;
	    			$postUser['source_addr_sms'] = $zoug[1]->source_address;
	    			$postUser['password_sms'] = $zoug[1]->password;
	    			$postUser['id_zoug'] = $zoug[1]->id_zoug;
	    		
	    		}
	    		
	    		$postUser['empresa'] = $post['empresa'];
	    		$postUser['emailEmp'] = $post['emailEmp'];
	    		$postUser['telEmp'] = $post['telEmp'];
	    		$postUser['cnpj'] = $post['cnpj'];
	    		$postUser['name_user'] = $post['name_user'];
	    		$postUser['email_user'] = $post['email_user'];
	    		$postUser['sexo'] = $post['sexo'];
	    		$postUser['tel_user'] = $post['tel_user'];
	    		$postUser['time'] = $post['time'];
	    		$postUser['dias'] = $post['dias'];
	    		$postUser['type'] = $post['type'];
	    		$postUser['expira'] = $post['expira'];
	    		$postUser['callback'] = $post['callback'];
	    		
	    		$db_user = $this->usuarios->edit(NULL,$postUser,NULL,Model_Data::NOVO);
	    		
	    		$postLogin = array();
	    		$postLogin['ativo'] = $post['ativo'];
	    		$postLogin['nivel'] = 1;
	    		$postLogin['email'] = $post['email_user'];
	    		$postLogin['login'] = $post['login_user'];
	    		$postLogin['senha'] = md5($post['senha_user']);
	    		$postLogin['id_usuario'] = $db_user;
	    		
	    		$db_login = $this->login->edit(NULL,$postLogin,NULL,Model_Data::NOVO);
	    		 
    		}
    		
    		
    		if ($db_user && $db_login){
    			$this->_messages->addMessage('Registro salvo com sucesso.');
    			$this->_redirect('/'.$this->view->baseModule.'/');
    		} else {
    			$this->_messages->addMessage('Erro ao salvar.');
    			$this->_redirect('/'.$this->view->baseModule.'/');
    		}
    		
    	}
    		
    }
    
    public function novoUsuarioAction ()
    {
    	
    	$this->editarUsuarioAction();
    	$this->render('editar-usuario');
    	
    }
    
    public function planoUserAction()
    {
    	
    	$params = $this->_request->getParams();
    	
    	$planos = new usuarios_planos();
    	$this->view->planos = $planos->fetchAll('id_usuario = '.$params[id].' ', 'criado ASC');

    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('USER_PLANOS'=>$this->config->tb->usuarios_planos),array('*'))
    	 
    		->joinLeft(array('PLANOS'=>$this->config->tb->planos),
    			'USER_PLANOS.id_plano = PLANOS.id_plano',array('plano'))
    	
    		->order('USER_PLANOS.criado ASC')
    		->where('USER_PLANOS.id_usuario = '.$params[id].'');
    					 
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$this->view->planos = $sql->fetchAll();
    	
    	$total = count($this->view->planos);
    	
    	$array = array();
    	foreach($this->view->planos as $row){
    		array_push($array, 
    			array(
    				'id_usuario_plano'=>$row->id_usuario_plano,
    				'plano'=>$row->plano,
    				'id_usuario'=>$row->id_usuario,
    				'id_plano'=>$row->id_plano,
    				'sms_disponivel'=>$row->sms_disponivel,
    				'tipo'=>$row->tipo,
    				'modificado'=>$row->modificado,
    				'criado'=>$row->criado,
    				'total'=>$total
    			)
    		);
    	}
    	
    	echo json_encode($array);
    	exit();
    	
    }
    
    public function planosAction()
    {
    	 
    	$params = $this->_request->getParams();
    	 
    	$planos = new planos();
    	$this->view->planos = $planos->fetchAll(NULL, 'criado ASC');
    			 
    	$array = array();
    	foreach($this->view->planos as $row){
    		array_push($array,
    			array(
    				'id_plano'=>$row->id_plano,
    				'plano'=>$row->plano,
    				'valor'=>$row->valor,
    				'num_sms'=>$row->num_sms,
    				'campanhas_ativas'=>$row->campanhas_ativa
    			)
    		);
    	}
    			 
    	echo json_encode($array);
    	exit();
    			 
    }
    
    public function adcPlanoUsuarioAction ()
    {
    	
    	$post = $this->_request->getPost();
    	
    	$users = new usuarios();
    	$this->view->users = $users->fetchAll('id_usuario = '.$post[id_usuario].'');
    	
    	$planos = new planos();
    	$this->view->planos = $planos->fetchAll('id_plano = '.$post[id_plano].'', 'plano ASC');
    	
    	if ($post['tipo'] == 'principal'){
    		
	    	$id_zoug = $this->view->users[0]->id_zoug;
	    	$type = 0;
	    	@$credit = $this->view->planos[0]->valor;
	    	@$sms = $this->view->planos[0]->num_sms;
	    	
	    	@$plano_zoug = $credit / $sms;
	    	
	    	if ($plano_zoug == '0.2'){
	    		@$plano_zoug = '0.20';
	    	}
	    	
	    	if ($plano_zoug == '0.1'){
	    		@$plano_zoug = '0.10';
	    	}
	    	
	    	$postUser = array();
	    	$postUser['plano_zoug'] = $plano_zoug;
	    	
	    	$db_user = $this->usuarios->edit($post[id_usuario],$postUser,NULL,Model_Data::ATUALIZA);
	    	
	    	if ($db_user){
	    		$credita = $this->creditoUser($id_zoug, $type, $credit, $description, $sms);
	    		$atualiza_plano = $this->atualizaPlano($plano_zoug, $id_zoug);
	    	}
	    	
    	}
    	
    	$post['sms_disponivel'] = $this->view->planos[0]->num_sms;
    	$result = $this->plano->edit(NULL,$post,NULL,Model_Data::NOVO);
    		
    	if ($result){
    		echo 'true';
    	} else {
    		echo 'false';
    	}
    	
    	exit();
    	
    }
    
    public function removerPlanoAction()
    {
    	
    	$params = $this->_request->getParams();
    	$this->plano->_table()->getAdapter()->query('DELETE FROM zz_usuarios_planos WHERE id_usuario_plano = '.$params[id].'');
   		
    }
    
    public function atualizaPlano($plano, $id_zoug){
    	 
    	$post = array();
    	
    	$post['user'] = 'zigzag';
    	$post['pass'] = 'zigzag';
    	$post['id_zoug'] = $id_zoug;
    	$post['plano'] = $plano;
    	 
    	$get = 'http://portal.zoug.net.br/api/editCentro';
    	$postdata = http_build_query($post);
    
    	$opts = array('http' =>
    		array(
    			'method'  => 'POST',
    			'header'  => 'Content-type: application/x-www-form-urlencoded',
    			'content' => $postdata
    		)
    	);
    
    	$context  = stream_context_create($opts);
    	$result = file_get_contents($get, false, $context);
    	 
    	//print_r($result);
    	 
    }
    
    public function creditoUser($id_zoug, $type, $credit, $description, $sms)
    {
    	
    	$post = $this->_request->getPost();
    	 
    	$post['user'] = 'zigzag';
    	$post['pass'] = 'zigzag';
    	$post['id_zoug'] = $id_zoug;
    	$post['type'] = $type;
    	$post['credit'] = $credit;
    	$post['description'] = $description;
    	
    	$get = 'http://portal.zoug.net.br/api/credit';
    	$postdata = http_build_query($post);
    	 
    	$opts = array('http' =>
    		array(
    			'method'  => 'POST',
    			'header'  => 'Content-type: application/x-www-form-urlencoded',
    			'content' => $postdata
    		)
    	);
    	 
    	$context  = stream_context_create($opts);
    	$result = file_get_contents($get, false, $context);
    	
    	$zoug = json_decode($result);
    	 
    	//print_r($result);
    	
    }
    
    public function creditoUserAction()
    {
    	 
    	$get = $this->_request->getParams();
    
    	$post['user'] = 'zigzag';
    	$post['pass'] = 'zigzag';
    	$post['id_zoug'] = $get['id'];
    	$post['type'] = $get['type'];
    	$post['credit'] = $get['credit'];
    	 
    	$get = 'http://portal.zoug.net.br/api/credit';
    	$postdata = http_build_query($post);
    
    	$opts = array('http' =>
    		array(
    			'method'  => 'POST',
    			'header'  => 'Content-type: application/x-www-form-urlencoded',
    			'content' => $postdata
    		)
    	);
    
    	$context  = stream_context_create($opts);
    	$result = file_get_contents($get, false, $context);
    	 
    	print_r($result);
    	exit();
       
    }
    
	public function saldoUserAction ()
	{
		 
		$get = $this->_request->getParams();
		 
		$post['user'] = 'zigzag';
		$post['pass'] = 'zigzag';
		$post['id_zoug'] = $get['id'];
		 
		$get = 'http://portal.zoug.net.br/api/saldo';
		$postdata = http_build_query($post);
		 
		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);
		 
		$context  = stream_context_create($opts);
		$result = file_get_contents($get, false, $context);
	
		$zoug = json_decode($result);
		 
		print_r($result);
		exit();
		 
	}
    
    public function campanhasAction()
    {
    	
    	$get = $this->_request->getParams();
    	$where;
    	if (!empty($get['pi'])){
    		$where .= ' AND CAMPANHA.criado >= \''.$get[pi].'\' ';
    	}
    	 
    	if (!empty($get['pf'])){
    		$where .= ' AND CAMPANHA.criado <= \''.$get[pf].'\' ';
    	}
    	 
    	if (!empty($get['c'])){
    		$where .= ' AND CAMPANHA.campanha LIKE \'%'.$get[c].'%\' ';
    	}
    	 
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('CAMPANHA'=>$this->config->tb->campanhas),array('*'))
    			 
    		->order('CAMPANHA.id_campanha DESC')
    		->where('CAMPANHA.id_usuario = '.$this->id.''.$where)
    		->group('CAMPANHA.id_campanha');
    			 
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$this->view->result = $sql->fetchAll(); 	
    }
    
    public function alteraStatusAction()
    {
    	
    	$post = $this->_request->getPost();
    	$db_login = $this->login->edit($post['id'],$post,NULL,Model_Data::ATUALIZA);
    	
    }
    
    public function quantidadeContatosAction()
    {
    	$params = $this->_request->getParams();
    
    	$campanhas = new campanhas();
    	$this->view->campanhas = $campanhas->fetchAll('id_campanha = '.$params[id].'');
    
    	$grupos = new Zend_Db_Select($this->db);
    	$grupos->from(array('GRUPOS'=>$this->config->tb->lista_contatos),array('*'))
    
	    	->joinLeft(array('CONTATOS'=>$this->config->tb->contatos),
	    			'CONTATOS.id_lista = GRUPOS.id_lista',array('count(id_contato) AS total'))
    
    		->group('GRUPOS.id_lista')
    		->where('GRUPOS.id_lista IN ('.$this->view->campanhas[0]->id_lista.')');
    
    	$grupos = $grupos->query(Zend_Db::FETCH_OBJ);
    	$this->view->grupos = $grupos->fetchAll();
    
    				
    	$montaArray = array();
    	foreach($this->view->grupos as $row){
    		array_push($montaArray,
    				array(
    					'grupo' => $row->lista,
    					'total' => $row->total
    				)
    			);
    		}
    
    	echo json_encode($montaArray);
    	exit();
    
    }
    
}