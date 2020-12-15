<?php

include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class UsuariosController extends My_Controller 
{
	
	public function ini()
	{
		
    	$this->view->tituloPag 	= 'Usuarios';
    	$this->view->cssPag = '<link rel="stylesheet" type="text/css" href="assets/'.$this->view->baseModule.'/css/contatos.css">';
    	$get = $this->_request->getParams();
    	$this->view->id = $this->id = $get['id'];
    	
	}
	
    public function indexAction ()
    {
    	
    	$this->view->jsPag = '';
    	// SELECT
    	
    	$login = new Zend_Db_Select($this->db);
    	$login->from(array('login'=>$this->config->tb->login),array('*'))
    	
    		->where('login.id_usuario = '.$this->me->id_usuario.'');
    		
    	$login = $login->query(Zend_Db::FETCH_OBJ);
    	$this->view->result = $login->fetchAll();
    	
    }
    
    public function editAction ()
    {
    	
    	if ($this->id == 'me'):
    	
    		$this->id = $this->me->id_login;
    	
    	endif;
    	
    	$permissao_users = new Zend_Db_Select($this->db);
    	$permissao_users->from(array('PERMI'=>$this->config->tb->permissoes),array('*'));
    	 
    		$permissao_users->group('PERMI.id_permissao');
    	 
    	$permissao_users = $permissao_users->query(Zend_Db::FETCH_OBJ);
    	$this->view->permissoes = $permissao_users->fetchAll();
    	
    	if ($this->id){
	    	$login = new Zend_Db_Select($this->db);
	    	$login->from(array('login'=>$this->config->tb->login),array('*'))
	    			 
	    		->where('login.id_login = \''.$this->id.'\'');
	    
	    	$login = $login->query(Zend_Db::FETCH_OBJ);
	    	$this->view->usuario = $login->fetchAll();
	    	
	    	$permissao_users = new usuarios_permissoes();
	    	$this->view->permissao_user = $permissao_users->fetchAll('id_usuario = '.$this->id);
	    	
	    	$permissao_user = array();
	    	foreach ($this->view->permissao_user as $row){
	    		$permissao_user[$row->id_permissao] = $row->id_permissao;
	    	}
	    	$this->view->permissao_user = $permissao_user;
	    	
    	}
    	
    	
    }
    
    public function updateAction()
    {
    	
    	if ($this->id == 'me'):
    	 
    		$this->id = $this->me->id_login;
    	 
    	endif;
    	
    	$post = $this->_request->getPost();
    	
    	$this->login = new Model_Data(new login());
    	$this->login->_required(array('id_login', 'id_gerenciado', 'login', 'id_usuario', 'senha', 'nivel', 'ativo', 'email', 'criado'));
    	$this->login->_notNull(array());
    	
    	if ($this->id){
    		
    		if ($post['senha'] != $post['senha_atual']){
    			$post['senha'] = md5($post['senha']);
    		}
    		
    		$edt = $this->login->edit($this->id,$post,NULL,Model_Data::ATUALIZA);
    		
    	} else {
    		
    		$login = new login();
    		$this->view->login = $login->fetchAll('login = \''.$post['login'].'\'');
    		
    		if (count($this->view->login) == 0){
    			
    			$post['id_gerenciado'] = $this->view->GerenciadorCustom->id_usuario;
    			$post['id_usuario'] = $this->me->id_usuario;
    			$post['ativo'] = 1;
    			$post['nivel'] = 3;
    			$post['senha'] = md5($post['senha']);
    			
    			$edt = $this->login->edit(NULL,$post,NULL,Model_Data::NOVO);
    			
    			if (!$edt) {
    				echo 'Não inseriu';
    				$this->_messages->addMessage('Ocorreu um erro!');
    			} else {
    				$this->id = $edt;
    			}
    			
    			
    		} else {
    			$this->_messages->addMessage('Esse login já existe, tente outro!');
    		}
    		
    		$this->_messages->addMessage(array('success'=>'Cadastro salvo com sucesso!'));
    		
    	}
    	
    	if ($edt) {
    		$this->_messages->addMessage(array('success'=>'Cadastro salvo com sucesso!'));
    	} else {
    		$this->_messages->addMessage('Ocorreu um erro!');
    	}
    	
    	$this->usuarios_permissoes = new Model_Data(new usuarios_permissoes());
    	$this->usuarios_permissoes->_required(array('id_permissao_usuario', 'id_permissao', 'id_usuario', 'modificado', 'criado'));
    	$this->usuarios_permissoes->_notNull(array());
    	 
    	$this->usuarios_permissoes->_table()->getAdapter()->query('DELETE FROM zz_usuarios_permissoes WHERE id_usuario = "'.$this->id.'"');
    	
    	foreach($post['permissoes'] as $row){
    		$post['id_usuario'] = $this->id;
    		$post['id_permissao'] = $row;
    		$usuarios_categorias = $this->usuarios_permissoes->edit(NULL,$post,NULL,Model_Data::NOVO);
    	}
    	
    	$this->_redirect($_SERVER['HTTP_REFER']);
    	
    }
    
}