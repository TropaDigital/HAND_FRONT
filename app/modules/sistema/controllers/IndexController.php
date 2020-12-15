<?php
	
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';
include_once 'app/models/Usuarios.php';
include_once 'app/models/operadora/twwClass.php';

class Sistema_IndexController extends My_Controller 
{

	public function ini()
	{
		
	}
	
    public function indexAction ()
    {
    
    	$user = new UsuariosZigzag();
    	
    	$contas = new usuarios_gerenciador();
    	$this->view->contas = $contas->fetchAll();
    	
    }
    
    public function creditosAction()
    {
    	
    	$tww = new tww();
    	echo $tww->creditos(); 
    	exit;
    	
    }
    
    public function creditosValidadeAction()
    {
    	
    	$tww = new tww();
    	echo $tww->creditosValidade(); 
    	exit;
    	
    }

}