<?php
	
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';
include_once 'app/models/JasminApi.php';

class Gerenciador_ContasController extends My_Controller 
{

	public function ini()
	{
		
		// PERMISSÃO PARA NIVEL 99
		
		$post = $this->_request->getPost();
		$params = $this->_request->getParams();
		
		// GERA O ID
		$this->view->id = $this->id = $params['id'];
		
		$this->view->cssPag = '<link rel="stylesheet" type="text/css" href="assets/site/css/index_new.css">';

		$this->usuarios = new Model_Data(new usuarios());
		$this->usuarios->_required(array('id_usuario', 'id_vendedor', 'tww', 'id_plano', 'name_user', 'empresa', 'cnpj', 'email', 'telefone', 'creditos', 'login_envio', 'senha_envio', 'modificado', 'criado'));
		$this->usuarios->_notNull(array());
		
		$this->login = new Model_Data(new login());
		$this->login->_required(array('login','senha','nivel','email','ativo','id_usuario','id_gerenciado'));
		$this->login->_notNull(array());
		
	}
	
	public function viewAction()
	{
		
		$get = $this->_request->getParams();
		$_SESSION['id_gerenciado'] = $this->me->id_usuario;
		$_SESSION['id_view'] = $get['id'];
		
		print_r($_SESSION); exit;
		
		$this->_redirect($this->view->GerenciadorCustom->slug);
		
	}
	
    public function indexAction ()
    {
    	
    	$get = $this->_request->getParams();
    	$where;
    	
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('LOGIN'=>$this->config->tb->login),array('*'))
    	
    		->joinLeft(array('USER'=>$this->config->tb->usuarios),
    			'USER.id_usuario = LOGIN.id_usuario',array('*'))
    			
    		->joinLeft(array('CAMPANHA'=>$this->config->tb->campanhas),
    			'CAMPANHA.id_usuario = USER.id_usuario',array('count(id_campanha) AS total_campanha'))
    	
    		->order('LOGIN.id_usuario DESC')
    		->group('USER.id_usuario');
    		$sql->where('LOGIN.id_gerenciado = ?',$this->me->id_usuario);
    	
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
    	
        $sql = new Zend_Db_Select($this->db);
        $sql->from(array('vendedores'=>$this->config->tb->vendedores),array('*'));
         
        $sql->joinLeft(array('login'=>$this->config->tb->login_sistema),
            'login.id_usuario = vendedores.id_vendedor',array('*'));
         
        $sql->where('login.nivel = 6');
        $sql->where('id_gerenciador_criado = ?', $this->me->id_usuario);
         
        $sql = $sql->query(Zend_Db::FETCH_OBJ);
        $this->view->vendedores = $sql->fetchAll();
        
    	$post = $this->_request->getPost();
    	$params = $this->_request->getParams();
    	
    	$permissoes = new permissoes();
    	$this->view->permissoes = $permissoes->fetchAll(NULL,'id_permissao ASC');
    	
    	$permissao_users = new usuarios_permissoes();
    	$this->view->permissao_user = $permissao_users->fetchAll('id_usuario = "'.$params['id_login'].'"');
    	
    	$permissao_user = array();
    	foreach ($this->view->permissao_user as $row){
    		$permissao_user[$row->id_permissao] = $row->id_permissao;
    	}
    	$this->view->permissao_user = $permissao_user;
    	
    	// CASO EXISTE ID, FAZ A SELECT
    	if ($this->id){
    		
    		$sql = new Zend_Db_Select($this->db);
    		$sql->from(array('USER'=>$this->config->tb->usuarios),array('*'))
    	
    			->joinLeft(array('LOGIN'=>$this->config->tb->login),
    				'USER.id_usuario = LOGIN.id_usuario',array('login','senha','ativo','id_login'))
    				
    			->order('USER.id_usuario DESC')
    			->where('USER.id_usuario = '.$this->id.' AND nivel = 3')
    			->group('USER.id_usuario');
    	
    		$sql = $sql->query(Zend_Db::FETCH_OBJ);
    		$this->view->result = $sql->fetchAll();
    		$this->view->row = $this->row = $this->view->result[0];
    		
    	}
    	
    	$json_sms = json_decode( $this->me->json_sms );
    	
    	$method = $_SERVER['REQUEST_METHOD'];
    	
    	// VERIFICA SE EXISTE POST, SE EXISTE FAZ UMA VALIDAÇÃO DE INSERT OU UPDATE
    	if ($method == 'POST'){
    	    
    		$sql = new Zend_Db_Select($this->db);
    		$sql->from(array('USER'=>$this->config->tb->usuarios),array('*'));
    		 
    			$sql->joinLeft(array('LOGIN'=>$this->config->tb->login),
    				'LOGIN.id_usuario = USER.id_usuario',array('*'));
    		 
    			$sql->where('LOGIN.ativo = 1');
    			$sql->where('LOGIN.id_gerenciado = ?',$this->me->id_usuario);
    			$sql->group('USER.id_usuario');
    		 
    		$sql = $sql->query(Zend_Db::FETCH_OBJ);
    		$this->view->contas = $sql->fetchAll();
    		 
    		$meuPlano = new planos_gerenciador();
    		$fetchPlano = $meuPlano->fetchAll('id_plano = "'.$this->me->id_plano.'"');
    		 
    		if ($post['ativo_old'] == '0' && $post['ativo'] == '1'):
    		 
	    		if (count($this->view->contas) > count($fetchPlano)):
	    			$this->_messages->addMessage('Limite de usuários ativos atingido, inative algum outro usuario para criar mais contas.');
	    			$this->_redirect('/'.$this->view->baseModule.'/contas');
	    			exit;
	    		
    			endif;
    		 
    		endif;
    		
    		$post['new_creditos'] = $post['creditos'] - $post['creditos_old'] + $post['creditos_old_old'];
    		
    		if ($this->id){
    			
    			$postLogin = array();
    				
	    		// UPDATE
	    		if ($post['pass_user'] != $this->view->row->senha){
	    			$postLogin['senha'] = md5($post['pass_user']);
	    		} else {
	    			$postLogin['senha'] = $this->view->row->senha;
	    		}
	    			
	    		$postUser = array();
	    		$postUser['tww'] = 'default';
	    		$postUser['id_plano'] = 1;
	    		$postUser['empresa'] = $post['empresa'];
	    		$postUser['email'] = $post['email'];
	    		$postUser['telefone'] = $post['telefone'];
	    		$postUser['cnpj'] = $post['cnpj'];
	    		$postUser['name_user'] = $post['name_user'];
	    		$postUser['creditos'] = $post['new_creditos'];
	    		$postUser['login_envio'] = $post['login_envio'];
	    		$postUser['senha_envio'] = $post['senha_envio'];
	    		$postUser['id_vendedor'] = $post['id_vendedor'];
	    		
	    		$db_user = $this->usuarios->edit($this->id,$postUser,NULL,Model_Data::ATUALIZA);
	    		$postLogin['ativo'] = $post['ativo'];
	    		$db_login = $this->login->edit($params['id_login'],$postLogin,NULL,Model_Data::ATUALIZA);
	    			
	    		$json_sms = json_decode( $this->me->json_sms );
	    		
	    		if ( $json_sms == NULL ) {
	    		    $json_sms = json_decode( $this->view->GerenciadorCustom->json_sms );
	    		}
	    		
	    		$jasminApi = new jasminApi();
	    		$updateUser = $jasminApi->request('users/', $jasminApi::MT_PAYLOAD, ['uid'=>'u'.$this->id,'gid'=>$json_sms->gid,'username'=>$post['login_envio'],'password'=>$post['senha_envio']], ['Content-Type:application/json']);
	    		
	    		$reponse['jasmin'] = $updateUser;
	    		
	    	} else { 
	    		
	    		$postUser = array();
	    		$postUser['tww'] = 'default';
	    		$postUser['id_plano'] = 1;
    			$postUser['empresa'] = $post['empresa'];
    			$postUser['email'] = $post['email'];
    			$postUser['telefone'] = $post['telefone'];
    			$postUser['cnpj'] = $post['cnpj'];
    			$postUser['name_user'] = $post['name_user'];
    			$postUser['creditos'] = $post['new_creditos'];
    			
    			$postUser['login_envio'] = $post['login_envio'];
    			$postUser['senha_envio'] = $post['senha_envio'];
    			$postUser['id_vendedor'] = $post['id_vendedor'];
	    		
	    		$db_user = $this->usuarios->edit(NULL,$postUser,NULL,Model_Data::NOVO);
	    		$this->id = $db_user;
	    		
	    		$postLogin = array();
	    		$postLogin['id_gerenciado'] = $this->view->GerenciadorCustom->id_usuario;
	    		$postLogin['ativo'] = $post['ativo'];
	    		$postLogin['nivel'] = 3;
	    		$postLogin['email'] = $post['email_user'];
	    		$postLogin['login'] = $post['login_user'];
	    		$postLogin['senha'] = md5($post['pass_user']);
	    		$postLogin['id_usuario'] = $db_user;
	    		
	    		$db_login = $this->login->edit(NULL,$postLogin,NULL,Model_Data::NOVO);
	    		$params['id_login'] = $db_login;
	    		
	    		$json_sms = json_decode( $this->me->json_sms );
	    		
	    		$jasminApi = new jasminApi();
	    		$newUser = $jasminApi->request('users/', $jasminApi::MT_PAYLOAD, ['uid'=>'u'.$db_user,'gid'=>$json_sms->gid,'username'=>$postUser['login_envio'],'password'=>$postUser['senha_envio']], ['Content-Type:application/json']);
	    		
	    		$reponse['jasmin'] = $jasminApi;
	    		
// 	    		echo '<pre>'; print_r( $jasminApi->debug() ); print_r( ['uid'=>'u'.$db_user,'gid'=>$json_sms->gid,'username'=>$postUser['login_envio'],'password'=>$postUser['senha_envio']] ); exit;
	    		
    		}
    		
    		include 'app/models/RedisHand.php';
    		
    		$redisWhitelabel = new redisHand();
    		$setRedis = [];
    		$setRedis['week_start'] = 0;
    		$setRedis['week_end'] = 6;
    		$setRedis['time_start'] = '00:00';
    		$setRedis['time_end'] = '23:59';
    		$setRedis['ativo'] = 1;
    		$setRedis['saldo'] = 1;
    		$setRedis['cliente'] = 'hand';
    		$setRedis['revenda'] = $json_sms->gid;
    		
    		//echo '<pre>'; print_r( $post ); print_r( $setRedis ); exit;
    		
    		$setRedis = $redisWhitelabel->SetWhitelabel( $post['login_envio'], $setRedis );
    		
    		
    		if ( $setRedis != 1 ) {
    		    
    		    $this->_messages->addMessage('Registro salvo com erro code: r01');
    		    $this->_redirect('/'.$this->view->baseModule.'/contas/editar-usuario/id/'.$params['id'].'/id_login/'.$params['id_login']);
    		    
    		}
    		
    		$this->usuarios_permissoes = new Model_Data(new usuarios_permissoes());
    		$this->usuarios_permissoes->_required(array('id_permissao_usuario', 'id_permissao', 'id_usuario', 'modificado', 'criado'));
    		$this->usuarios_permissoes->_notNull(array());
    			
    		$this->usuarios_permissoes->_table()->getAdapter()->query('DELETE FROM zz_usuarios_permissoes WHERE id_usuario = "'.$params['id_login'].'"');
    			 
    		foreach($post['permissoes'] as $row){
    			$post['id_usuario'] = $params['id_login'];
    			$post['id_permissao'] = $row;
    			$usuarios_categorias = $this->usuarios_permissoes->edit(NULL,$post,NULL,Model_Data::NOVO);
    		}
    			
    		$this->_messages->addMessage('Registro salvo com sucesso.');
    		
    		if ( $params['id'] ){
    		    
    		    $this->_redirect('/'.$this->view->baseModule.'/');
    		    
    		} else {
    		    
    		    $this->_redirect('/'.$this->view->baseModule.'/'.$this->view->baseController.'/creditos/id/'.$db_user);
    		    
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
    
    public function alteraStatusAction()
    {
    	
    	$post = $this->_request->getPost();
    	$db_login = $this->login->edit($post['id'],$post,NULL,Model_Data::ATUALIZA);
    	
    }
    
    public function creditosAction()
    {
        
        $params = $this->_request->getParams();
        $post = $this->_request->getPost();
        
        $sql = new Zend_Db_Select($this->db);
        $sql->from(array('CREDITS'=>$this->config->tb->usuarios_creditos),array('*'));
        
        $sql->order('CREDITS.criado DESC');
        $sql->where('CREDITS.id_usuario = '.$params[id].'');
    
        $sql = $sql->query(Zend_Db::FETCH_OBJ);
        $this->view->creditos = $sql->fetchAll();
        
        $this->view->creditos_restante = $this->getCredits( $params['id'] );
        
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
            
            $this->cred = new Model_Data(new usuarios_creditos());
            $this->cred->_required(array('id_credito', 'id_usuario', 'creditos', 'modificado', 'criado'));
            $this->cred->_notNull(array());
            
            $post['id_usuario'] = $params['id'];
            
            $setCredit = $this->cred->edit(NULL,$post,NULL,Model_Data::NOVO);
            
            if ( $setCredit ) {
                
                $postUser = array();
                $postUser['creditos'] = $this->getCredits( $params['id'] );
                
                $setCredit = $this->usuarios->edit($params['id'],$postUser,NULL,Model_Data::ATUALIZA);
                
                $this->_messages->addMessage('Registro salvo com sucesso.');
                $this->_redirect($this->view->baseModule.'/contas/creditos/id/'.$params['id']);
                
            } else {
                
                $this->_messages->addMessage('Erro ao prosseguir.');
                $this->_redirect($this->view->baseModule.'/contas/creditos/id/'.$params['id']);
                
            }
            
        }
        
    }
    
}