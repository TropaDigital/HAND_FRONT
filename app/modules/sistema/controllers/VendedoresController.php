<?php
	
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class Sistema_VendedoresController extends My_Controller 
{

	public function ini()
	{
	
		$params = $this->_request->getParams();
		
		$this->id = $this->view->id = $params['id'];
		
		$this->dbVendedores = new Model_Data(new vendedores());
		$this->dbVendedores->_required(array('id_vendedor', 'vendedor','modificado','criado'));
		$this->dbVendedores->_notNull(array());
		
		$this->dbLogin = new Model_Data(new login_sistema());
		$this->dbLogin->_required(array('id_usuario','login','senha','nivel','ativo','criado'));
		$this->dbLogin->_notNull(array());
		
	}
	
    public function indexAction ()
    {
    	
    	
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('vendedores'=>$this->config->tb->vendedores),array('*'));
    	
    	$sql->joinLeft(array('login'=>$this->config->tb->login_sistema),
    	    'login.id_usuario = vendedores.id_vendedor',array('*'));
    	
    	$sql->where('login.nivel = 5');
    	
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
    	$sql->from(array('vendedores'=>$this->config->tb->vendedores),array('*'));
    	
    	$sql->joinLeft(array('login'=>$this->config->tb->login_sistema),
    	    'login.id_usuario = vendedores.id_vendedor',array('*'));
    	
    	$sql->where('nivel = 5');
    	$sql->where('id_vendedor = ?', $this->id);
    	
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$result = $sql->fetchAll();
    	
    	$this->view->row = $result[0];
    	
    	$this->render('edit');
    	
    }
    
    public function actionAction ()
    {
    	
    	$post = $this->_request->getPost();
    	$params = $this->_request->getParams();
    	
    	$method = $_SERVER['REQUEST_METHOD'];
    	
    	if ( $post['senha'] != $post['senha_old'] ){
    	    $post['senha'] = md5($post['senha']);
    	} else {
    	    unset($post['senha']);
    	}
    	
    	$post['nivel'] = 5;
    	$post['ativo'] = 1;
    	
    	$this->id = $params['id'];
    	
    	// VERIFICA SE EXISTE POST, SE EXISTE FAZ UMA VALIDAÇÃO DE INSERT OU UPDATE
    	if ($method == 'POST'){
    		
    	    try {
    	    
    	        $sql = new Zend_Db_Select($this->db);
    	        $sql->from(array('login_sistema'=>$this->config->tb->login_sistema),array('*'));
    	        
    	        $sql->where('login = ?', $post['login']);
    	        $sql->where('login != ?', $post['login_old']);
    	        
    	        $sql = $sql->query(Zend_Db::FETCH_OBJ);
    	        $result = $sql->fetchAll();
    	        
    	        if ( count($result) ) {
    	            throw new \Exception('Esse login já existe, altere para avançar.');
    	        }
    	        
        		if ($this->id){
    	    		
        			$db = $this->dbVendedores->edit($this->id,$post,NULL,Model_Data::ATUALIZA);
        			$db = $this->dbLogin->edit($post['login_old'],$post,NULL,Model_Data::ATUALIZA);
        			
    	    	} else { 
    	    		
    	    		$db = $this->dbVendedores->edit(NULL,$post,NULL,Model_Data::NOVO);
    	    		$post['id_usuario'] = $db;
    	    		
    	    		$db = $this->dbLogin->edit(NULL,$post,NULL,Model_Data::NOVO);
    	    		 
        		}
        		
        		if ( !$db ) {
        		    throw new \Exception('Erro ao salvar.');
        		}
        		
        		$this->_messages->addMessage('Registro salvo com sucesso.');
        		$this->_redirect('/'.$this->view->baseModule.'/'.$this->view->baseController);
        		
    		} catch ( \Exception $e ) {
    		     
    		    $this->_messages->addMessage($e->getMessage());
    		    $this->_redirect($_SERVER['HTTP_REFERER']);
    		    
    		}
    		
    		
    	}
    		
    }
    
    public function excluirAction ()
    {
    	 
    	$post = $this->_request->getPost();
    	 
    	$this->data->_table()->getAdapter()->query('DELETE FROM zz_categorias WHERE id_categoria IN ('.implode(',',$post[id]).')');
    	 
    	$this->_messages->addMessage('Registro(s) excluido com sucesso.');
    	$this->_redirect('/'.$this->view->baseModule.'/'.$this->view->baseController);
    	 
    }
    
}