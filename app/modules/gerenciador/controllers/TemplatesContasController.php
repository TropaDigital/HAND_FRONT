<?php
	
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class Gerenciador_TemplatesContasController extends My_Controller 
{

	public function ini()
	{
		
		// PERMISSÃO PARA NIVEL 99
		
		$post = $this->_request->getPost();
		$params = $this->_request->getParams();
		
		// GERA O ID
		$this->view->id = $this->id = $params['id'];
		
		$this->landing_page = new Model_Data(new landing_page());
		$this->landing_page->_required(array('id_usuario', 'modificado', 'criado'));
		$this->landing_page->_notNull(array());
		
	}
	
    public function indexAction ()
    {
    	
        $sql = new Zend_Db_Select($this->db);
        $sql->from(array('USUARIO'=>$this->config->tb->usuarios),array('*'));
        
        $sql->joinLeft(array('LOGIN'=>$this->config->tb->login),
            'USUARIO.id_usuario = LOGIN.id_usuario',array('login'));
        
        $sql->where('LOGIN.id_gerenciado = "'.$this->view->GerenciadorCustom->id_usuario.'"');
        
        $sql = $sql->query(Zend_Db::FETCH_OBJ);
        $this->view->result = $sql->fetchAll();
    	
    }
    
    public function searchAction (){
    
    	$post = $this->_request->getPost();
    	 
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('LP'=>$this->config->tb->landing_page),array('id_landing_page','nome'));
    	
    	$sql->joinLeft(array('USUARIO'=>$this->config->tb->usuarios),
    	    'USUARIO.id_usuario = LP.id_usuario AND USUARIO.id_usuario IS NOT NULL',array('login_envio', 'name_user'));
    	
    	$sql->joinLeft(array('LOGIN'=>$this->config->tb->login),
    	    'USUARIO.id_usuario = LOGIN.id_usuario',array('id_gerenciado', 'login'));
    	
    	$sql->where('USUARIO.login_envio LIKE "%'.$_GET['busca'].'%" OR USUARIO.email LIKE "%'.$_GET['busca'].'%" OR LP.nome LIKE "%'.$_GET['busca'].'%"');
    	$sql->where('LOGIN.id_gerenciado = "'.$this->view->GerenciadorCustom->id_usuario.'"');
    	$sql->group('LP.id_landing_page');
    	
        $sql = $sql->query(Zend_Db::FETCH_OBJ);
        $result = $sql->fetchAll();
        
        echo json_encode($result); exit;
    
    }
    
    public function sendAction()
    {

        $post = $this->_request->getPost();
        
        $result = $this->landing_page->edit( $post['id_landing_page'], $post, NULL, Model_Data::ATUALIZA);
        
        $this->_messages->addMessage('Registro salvo com sucesso.');
        $this->_redirect('/'.$this->view->baseModule.'/templates-contas');
        
    }
    
}