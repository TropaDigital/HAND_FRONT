<?php

include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class UsuariosZigzag {
	
	const nivelAdmin = 1;
	const nivelGerenciado = 2;
	const nivelUsuario = 3;
	
	const nivelVendedorAdmin = 5;
	const nivelVendedorGerenciador = 6;
	
	public function __construct()
	{

		/* configs */
		$this->config 	= Zend_Registry::get ( 'config' );
		$this->session 	= Zend_Registry::get ( 'session' );
		$this->db 		= Zend_Registry::get ( 'db' );
	
	}
	
	public function getDados($nivel, $id_usuario)
	{
		
		// DADOS ADMIN
		if ($nivel == UsuariosZigzag::nivelAdmin):
			
			$db = new Zend_Db_Select($this->db);
	    	$db->from(array('usuario'=>$this->config->tb->login_sistema));
				
				$db->join(array('login'=>$this->config->tb->usuarios_sistema), 
					'usuario.id_usuario = login.id_usuario');
					
				$db->where('usuario.id_usuario = ?', $id_usuario);
				
			$db = $db->query(Zend_Db::FETCH_OBJ);
			$result = $db->fetch();
		
		// DADOS GERENCIADOR
		elseif ($nivel == UsuariosZigzag::nivelGerenciado):
			
			$db = new Zend_Db_Select($this->db);
			$db->from(array('usuario'=>$this->config->tb->login_gerenciador));
				
				$db->join(array('login'=>$this->config->tb->usuarios_gerenciador),
					'usuario.id_usuario = login.id_usuario');
				
			$db->where('usuario.id_usuario = ?', $id_usuario);
			
			$db = $db->query(Zend_Db::FETCH_OBJ);
			$result = $db->fetch();
		
		// DADOS USUARIO COMUM
		else:
		
			$db = new Zend_Db_Select($this->db);
			$db->from(array('login'=>$this->config->tb->login));
			
				$db->join(array('usuario'=>$this->config->tb->usuarios),
					'usuario.id_usuario = login.id_usuario');
			
			$db->where('login.id_login= ?', $id_usuario);
				
			$db = $db->query(Zend_Db::FETCH_OBJ);
			$result = $db->fetch();
		
		endif;
		
		return $result;
		
	}
	
	
	public function getPermissoes($myController)
	{
		$return = array();

		if ($myController->view->baseController != 'login'):
		
			if ($myController->view->baseModule == 'sistema' && $myController->me->nivel != UsuariosZigzag::nivelAdmin):
			
				$return['return'] = 'redirect';
			
			elseif ($myController->view->baseModule == 'gerenciador' && $myController->me->nivel != UsuariosZigzag::nivelGerenciado && $myController->me->nivel != UsuariosZigzag::nivelAdmin):
			
				$return['return'] = 'redirect';
			
			elseif ($myController->view->baseModule == 'home' && ($myController->me->nivel != UsuariosZigzag::nivelUsuario && $myController->me->nivel != UsuariosZigzag::nivelGerenciado && $myController->me->nivel != UsuariosZigzag::nivelAdmin)):
			
				if ($myController->view->baseController != 'rc'){
					if (
						   ( $myController->view->baseController != 'login')
						&& ( $myController->view->baseController != 'rc')
						&& ( $myController->view->baseController != 'cron-agendamento')
						&& ( $myController->view->baseController != 'template'  					&&  $myController->view->baseAction != 'detalhe' )
						&& ( $myController->view->baseController != 'campanha'  					&&  $myController->view->baseAction != 'status' )
						&& ( $myController->view->baseController != 'campanha-gerenciamento'  		&&  $myController->view->baseAction != 'cron-lote' )
						&& ( $myController->view->baseController != 'template'  					&&  $myController->view->baseAction != 'submit-senha' )
						&& ( $myController->view->baseController != 'template'  					&&  $myController->view->baseAction != 'click' )
						&& ( $myController->view->baseController != 'campanha-gerenciamento'  		&&  $myController->view->baseAction != 'send-envio' )
						&& ( $myController->view->baseController != 'email'  						&&  $myController->view->baseAction != 'enviar' )
						&& ( $myController->view->baseController != 'base-dados'  					&&  $myController->view->baseAction != 'cron-importacao' )
						&& ( $myController->view->baseController != 'sms'  	 						&&  $myController->view->baseAction != 'recibo' ) )
					{
						
						$return['return'] = 'redirect';
						
					}
					
				}
			
			endif;
			
		endif;
			
		return $return;
		
	}
	
	public function ModuleHome($myController)
	{
		
		
	}
	
	public function ModuleGerenciador($myController)
	{
		
		
	}
	
	public function ModuleSistema($myController)
	{
		
		
	}
	
	
}