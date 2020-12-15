<?php
	
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class Gerenciador_ContasIntegracaoController extends My_Controller 
{

	public function ini()
	{
		
		
		$post = $this->_request->getPost();
		$params = $this->_request->getParams();
		
		// GERA O ID
		$this->view->id = $this->id = $params['id'];
		
		$this->view->cssPag = '<link rel="stylesheet" type="text/css" href="assets/site/css/index_new.css">';

		$this->usuarios = new Model_Data(new usuarios());
		$this->usuarios->_required(array('login_envio','senha_envio','status'));
		$this->usuarios->_notNull(array());
		
	}
	
    public function indexAction ()
    {

		$usuarios = new usuarios();
		$this->view->result = $usuarios->fetchAll('status = "integracao"');
    	
    }
    
    public function editarUsuarioAction ()
    {
    	
    	$post = $this->_request->getPost();
    	$params = $this->_request->getParams();
    	
    	// CASO EXISTE ID, FAZ A SELECT
    	if ($this->id){
    		
    		$usuarios = new usuarios();
			$this->view->result = $usuarios->fetchAll('id_usuario = "'.$this->id.'"');
    			  
    		$this->view->row = $this->row = $this->view->result[0];
    			  
    	}
    	
    	$method = $_SERVER['REQUEST_METHOD'];
    	
    	if ($method == 'POST'){
    		
    		if ( $this->id ){
    			
    			$registros = $usuarios->fetchAll('login_envio = "'.$post['login_envio_old'].'"');
    			
    			foreach ( $registros as $row ){
    				
    				if ( $row->id_usuario == $this->id )
    					$post['status'] = 'integracao';
    				
    				$db_user = $this->usuarios->edit($row->id_usuario,$post,NULL,Model_Data::ATUALIZA);
    				
    			}
    			
    		} else {
    			
    			$post['status'] = 'integracao';
    			$db_user = $this->usuarios->edit(NULL,$post,NULL,Model_Data::NOVO);
    			
    		}
    		
    		if ( $db_user ){
    			
    			$this->_messages->addMessage('Registro salvo com sucesso.');
    			
    		} else {
    			
    			$this->_messages->addMessage('Erro ao salvar registro.');
    			
    		}
    	
    		$this->_redirect('/'.$this->view->baseModule.'/contas-integracao');
    		
    	}
    		
    }
    
    public function novoUsuarioAction ()
    {
    	
    	$this->editarUsuarioAction();
    	$this->render('editar-usuario');
    	
    }
    
}