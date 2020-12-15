<?php
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class RcController extends My_Controller 
{
	public function ini()
	{
		
		if ($this->me) {
			$this->_redirect('/');
		}
		
		$this->view->tituloPag 	= 'ZigZag • Recuperando a senha';
		
	}
	
	public function indexAction()
    {
		
    	$this->view->cssPag = '<link rel="stylesheet" type="text/css" href="/assets/home/css/login.css">';
    	
    	$params = $this->_request->getParams();
    	
    	$this->view->get = $this->get = $params['get'];
    	
    	$get = base64_decode($params['get']);
    	$row = explode('[-]',$get);
    	
    	$login  = $row[0];
    	$email  = $row[1];
    	$nivel  = $row[2];
    	$ativo  = $row[3];
    	$criado = $row[4];
    	
    	$usuario = new login();
    	$this->view->usuario = $usuario->fetchAll("login = '".$login."' AND nivel = '".$nivel."' AND ativo = '".$ativo."' AND criado = '".$criado."'");
    	$total = count($this->view->usuario);
    	
    	if ($total > 0){
    		
    		$method = $_SERVER['REQUEST_METHOD'];
    		
    		// VERIFICA SE EXISTE POST, SE EXISTE FAZ UMA VALIDAÇÃO DE INSERT OU UPDATE
    		if ($method == 'POST'){
    			
    			$post = $this->_request->getPost();
    			
    			$this->data = new Model_Data(new login());
    			$this->data->_required(array('senha'));
    			$this->data->_notNull(array('senha'));
    			
    			if ($post['senha'] == $post['repitaSenha']){
    				
    				$post['senha'] = md5($post['senha']);
    				$edt = $this->data->edit($this->view->usuario[0]->id_login,$post,NULL,Model_Data::ATUALIZA);
    				
    				if ($edt){
    					echo 'true';
    				} else {
    					echo 'Erro ao salvar a senha, tente novamente mais tade.';
    				}
    			} else {
    				echo 'Senhas não conferem.';
    			}
    			
 				exit();
    			
    		}
    		
    	} else {
    		
    		$this->_redirect('/');
    		
    	}
    	
    }
    
}