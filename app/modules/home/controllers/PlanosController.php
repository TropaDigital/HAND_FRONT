<?php

include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class PlanosController extends My_Controller 
{
	
	public function ini()
	{
		
		if ($this->me->nivel != 1 && $this->me->nivel != 4){
			$this->_redirect('/');
		}
		
    	$this->view->tituloPag 	= 'ZigZag • Planos';
    	$this->view->jsPag = '<link rel="stylesheet" type="text/css" href="assets/site/css/planos.css">';
    	
    	$this->contatos= new Model_Data(new contatos());
    	$this->contatos->_required(array('id_contato', 'id_lista', 'nome', 'sobrenome', 'data_nascimento', 'email', 'celular', 'campo1', 'campo2', 'campo3', 'campo4', 'campo5', 'campo6', 'campo7', 'campo8', 'campo9', 'campo10', 'campo11', 'campo12', 'campo13', 'campo14', 'campo15', 'campo16', 'campo17', 'campo18', 'campo19', 'campo20', 'modificado', 'criado'));
    	$this->contatos->_notNull(array('id_lista', 'nome', 'email', 'data_nascimento'));
    	
    	$params = $this->_request->getParams();
    	$this->id = $params['id'];
    	
    	$post = $this->_request->getPost();
 
	}
	
    public function indexAction ()
    {
    	
    	$planos = new planos();
    	$this->view->lista_planos = $planos->fetchAll('valor != \'0\'', 'valor');
    	
    }
    
}