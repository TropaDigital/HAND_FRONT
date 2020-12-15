<?php
	
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';
include_once 'app/models/Usuarios.php';

class Sistema_AdministradoresController extends My_Controller 
{

	public function ini()
	{
	
		$params = $this->_request->getParams();
		$user = new UsuariosZigzag();
		
		$this->view->nivel = $user::nivelAdmin;
		$this->id = $this->view->id = $params['id'];
		
		$this->usuarios = new Model_Data(new usuarios_sistema());
		$this->usuarios->_required(array('nome','email','telefone','celular','modificado','criado'));
		$this->usuarios->_notNull(array());
		
		$this->login = new Model_Data(new login_sistema());
		$this->login->_required(array('login','senha','nivel','ativo','id_usuario'));
		$this->login->_notNull(array());
		
	}
	
    public function indexAction ()
    {
    	
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('USER'=>$this->config->tb->usuarios_sistema),array('*'));
    	 
    		$sql->joinLeft(array('LOGIN'=>$this->config->tb->login_sistema),
    			'USER.id_usuario = LOGIN.id_usuario',array('*'));
    			 
    		$sql->where('LOGIN.nivel = ?', $this->view->nivel);
    		$sql->order('USER.id_usuario DESC');
    			 
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$this->view->result = $sql->fetchAll();
    	
    }
    
    public function cadastrarAction()
    {
    	$this->render('edit');
    }
    
    public function editarAction()
    {
    	
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('USER'=>$this->config->tb->usuarios_sistema),array('*'));
    	
    		$sql->joinLeft(array('LOGIN'=>$this->config->tb->login_sistema),
    			'USER.id_usuario = LOGIN.id_usuario',array('*'));
    	
    		$sql->where('LOGIN.nivel = ?',$this->view->nivel);
    		$sql->where('USER.id_usuario = ?', $this->view->id);
    		$sql->order('USER.id_usuario DESC');
    	
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$result = $sql->fetchAll();
    	$this->view->row = $result[0];
    	
    	$this->render('edit');
    	
    }
    
    public function actionAction ()
    {
    	
    	$post = $this->_request->getPost();
    	$post['nivel'] = $this->view->nivel;
    	$params = $this->_request->getParams();
    	
    	// CASO EXISTE ID, FAZ A SELECT
    	if ($this->id){
    		 
    		$sql = new Zend_Db_Select($this->db);
	    	$sql->from(array('USER'=>$this->config->tb->usuarios_sistema),array('*'));
	    	
	    		$sql->joinLeft(array('LOGIN'=>$this->config->tb->login_sistema),
	    			'USER.id_usuario = LOGIN.id_usuario',array('*'));
	    	
	    		$sql->where('USER.id_usuario = ?', $this->view->id);
	    		$sql->order('USER.id_usuario DESC');
	    	
	    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
	    	$result = $sql->fetchAll();
    			  
    		$this->view->row = $this->row = $result[0];
    			  
    	}
    	
    	$method = $_SERVER['REQUEST_METHOD'];
    	
    	// VERIFICA SE EXISTE POST, SE EXISTE FAZ UMA VALIDAÇÃO DE INSERT OU UPDATE
    	if ($method == 'POST'){
    		
    		if ($this->id){
	    		
    			// UPDATE
    			if ($post['senha'] != $this->view->row->senha){
    				$post['senha'] = md5($post['senha']);
    			} else {
    				$post['senha'] = $this->view->row->senha;
    			}
    			
    			$db_user = $this->usuarios->edit($this->id,$post,NULL,Model_Data::ATUALIZA);
    			$db_login = $this->login->edit($this->view->row->login,$post,NULL,Model_Data::ATUALIZA);
    			
	    	} else { 
	    		
	    		$db_user = $this->usuarios->edit(NULL,$post,NULL,Model_Data::NOVO);
	    		$post['id_usuario'] = $db_user;
	    		$post['senha'] = md5($post['senha']);
	    		$db_login = $this->login->edit(NULL,$post,NULL,Model_Data::NOVO);
	    		 
    		}
    		
    		if ($db_user && $db_login){
    			
    			$this->_messages->addMessage('Registro salvo com sucesso.');
    			$this->_redirect('/'.$this->view->baseModule.'/'.$this->view->baseController);
    			
    		} else {
    			
    			$this->_messages->addMessage('Erro ao salvar.');
    			$this->_redirect($_SERVER['HTTP_REFERER']);
    	
    		}
    		
    	}
    		
    }
    
}