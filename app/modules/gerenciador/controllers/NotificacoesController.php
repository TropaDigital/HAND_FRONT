<?php
	
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class Painel_NotificacoesController extends My_Controller 
{

	public function ini()
	{
		
		// PERMISSÃO PARA NIVEL 99
		$this->permissao(99, '/painel');
		
		$post = $this->_request->getPost();
		$params = $this->_request->getParams();
		
		// GERA O ID
		$this->view->id = $this->id = $params['id'];
		
		$this->view->tituloPag = 'ZigZag • notificacoes';
		$this->view->cssPag = '<link rel="stylesheet" type="text/css" href="assets/site/css/index_new.css">';

		$this->sql = new Model_Data(new notificacoes());
		$this->sql->_required(array('id_notificacao','id_usuario','mensagem','nivel','modificado','criado'));
		$this->sql->_notNull(array());
		
	}
	
    public function indexAction ()
    {
    	
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('notificacoes'=>$this->config->tb->notificacoes),array('*'))
    	
    		->joinLeft(array('U'=>$this->config->tb->usuarios),
    			'notificacoes.id_usuario = U.id_usuario',array('id_usuario AS user','name_user'))
    			
    		->order('notificacoes.id_notificacao DESC');
    	
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$this->view->result = $sql->fetchAll();
    	
    }
    
    public function editarAction ()
    {
    	
    	// POST/GET
    	$post = $this->_request->getPost();
    	$params = $this->_request->getParams();
    	
    	$usuario = new usuarios();
    	$this->view->usuarios = $usuario->fetchAll();
    	
    	// CASO EXISTE ID, FAZ A SELECT
    	if ($this->id){
    		 
    		$sql = new Zend_Db_Select($this->db);
	    	$sql->from(array('notificacoes'=>$this->config->tb->notificacoes),array('*'))
	    	
	    		->joinLeft(array('U'=>$this->config->tb->usuarios),
	    			'notificacoes.id_usuario = U.id_usuario',array('id_usuario AS user','name_user'))
	    			
	    		->where('id_notificacao = '.$this->id.' ');
	    	
	    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
	    	$this->view->result = $sql->fetchAll();
    			  
    		$this->view->row = $this->row = $this->view->result[0];
    			  
    	}
    	
    	$method = $_SERVER['REQUEST_METHOD'];
    	
    	// VERIFICA SE EXISTE POST, SE EXISTE FAZ UMA VALIDAÇÃO DE INSERT OU UPDATE
    	if ($method == 'POST'){
    		
    		if ($this->id){
	    		
    			$db = $this->sql->edit($this->id,$post,NULL,Model_Data::ATUALIZA);
    			
	    	} else { 
	    		
	    		$db = $this->sql->edit(NULL,$post,NULL,Model_Data::NOVO);
	    		 
    		}
    		
    		if ($db){
    			$this->_messages->addMessage('Registro salvo com sucesso.');
    			$this->_redirect('/'.$this->view->baseModule.'/'.$this->view->baseController);
    		} else {
    			$this->_messages->addMessage('Erro ao salvar.');
    			$this->_redirect('/'.$this->view->baseModule.'/'.$this->view->baseController.'/'.$this->view->baseAction.'/id/'.$this->id);
    		}
    		
    	}
    		
    }
    
    public function novoAction ()
    {
    	
    	$this->editarAction();
    	$this->render('editar');
    	
    }
    
    public function alteraStatusAction()
    {
    	 
    	$post = $this->_request->getPost();
    	$post['status'] = $post['ativo'];
    	$db_login = $this->sql->edit($post['id'],$post,NULL,Model_Data::ATUALIZA);
    	 
    }
    
    public function removerAction ()
    {
    	
    	$post = $this->_request->getPost();
    	
    	$this->sql->_table()->getAdapter()->query('DELETE FROM zz_notificacoes WHERE id_notificacao IN ('.$post[id].')');
    	
    	$this->_messages->addMessage('Registro(s) excluido com sucesso.');
    	$this->_redirect('/'.$this->view->baseModule.'/'.$this->view->baseController);
    	
    }

}