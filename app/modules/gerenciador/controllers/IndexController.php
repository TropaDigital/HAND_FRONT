<?php
	
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';
include_once 'app/models/Usuarios.php';

class Gerenciador_IndexController extends My_Controller 
{

	public function ini()
	{
	}
	
    public function indexAction ()
    {
    	
    	$user = new UsuariosZigzag();
    	
    	$sql = new Zend_Db_Select($this->db);
		$sql->from(array('USER'=>$this->config->tb->usuarios),array('*'));
		
			$sql->joinLeft(array('LOGIN'=>$this->config->tb->login),
				'LOGIN.id_usuario = USER.id_usuario',array('*'));
				
			$sql->where('LOGIN.ativo = 1');
			$sql->where('LOGIN.id_gerenciado = ?',$this->me->id_usuario);
			$sql->group('USER.id_usuario');
				
		$sql = $sql->query(Zend_Db::FETCH_OBJ);
		$this->view->contas = $sql->fetchAll();
    	
    }
    
}