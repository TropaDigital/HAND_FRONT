<?php

include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class CaixaEntradaController extends My_Controller 
{
	
	public function ini()
	{
 
	}
	

	public function indexAction()
	{
		
		$this->view->tituloPag 	= 'Caixa de entrada';
		$this->view->cssPag = '<link rel="stylesheet" type="text/css" href="assets/site/css/calendario.css">';
		 
		$post = $this->_request->getPost();
		$params = $this->_request->getParams();
		
		$params = $this->_request->getParams();
		$params['id_usuario'] = $this->me->id_usuario;
		$params['limit'] = '0,1';
		
		$campanhas = new campanhas();
		$this->view->campanhas = $campanhas->fetchAll('id_usuario = '.$this->me->id_usuario);
		
		//echo $this->insertPostgre('index','caixa-entrada', NULL, $params); exit;
		
		$this->view->sms = $this->postgre('index','caixa-entrada', NULL, $params);
		
	}
	
}