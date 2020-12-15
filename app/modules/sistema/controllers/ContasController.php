<?php
	
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';
include_once 'app/models/Usuarios.php';
include_once 'app/models/operadora/twwClass.php';
include_once 'app/models/Filter_Acentos.php';

class Sistema_ContasController extends My_Controller 
{

	public function ini()
	{
	
		$params = $this->_request->getParams();
		$user = new UsuariosZigzag();
		
		$this->view->nivel = $user::nivelGerenciado;
		$this->id = $this->view->id = $params['id'];
		
		$this->usuarios = new Model_Data(new usuarios_gerenciador());
		$this->usuarios->_required(array('id_usuario', 'id_vendedor', 'slug', 'nome', 'email', 'empresa', 'telempresa', 'cnpj', 'dominio', 'shorturl', 'logotipo', 'logo', 'logo_cor', 'cor_a', 'cor_a_hover', 'cor_a_font', 'cor_a_font_hover', 'cor_b', 'cor_b_hover', 'cor_b_font', 'cor_b_font_hover', 'cor_c', 'cor_c_hover', 'cor_c_font', 'cor_c_font_hover', 'background', 'favicon', 'json_sms', 'modificado', 'criado'));
		$this->usuarios->_notNull(array());
		
		$this->login = new Model_Data(new login_gerenciador());
		$this->login->_required(array('login','senha','nivel','ativo','id_usuario'));
		$this->login->_notNull(array());
		
		$cat = new categorias();
		$this->view->categorias = $cat->fetchAll();
		
	}
	
    public function indexAction ()
    {
    	
        
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('USER'=>$this->config->tb->usuarios_gerenciador),array('*'));
    	 
    		$sql->joinLeft(array('LOGIN'=>$this->config->tb->login_gerenciador),
    			'USER.id_usuario = LOGIN.id_usuario',array('*'));
    		
    		$sql->joinLeft(array('vendedores'=>$this->config->tb->vendedores),
    		    'USER.id_vendedor = vendedores.id_vendedor',array('vendedor'));
    		
    		$sql->order('USER.id_usuario DESC');
    			 
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$this->view->result = $sql->fetchAll();
    	
//     	echo '<pre>'; print_r( $this->view->result ); exit;
    	
    }
    
    public function cadastrarAction()
    {
        
        $sql = new Zend_Db_Select($this->db);
        $sql->from(array('vendedores'=>$this->config->tb->vendedores),array('*'));
         
        $sql->joinLeft(array('login'=>$this->config->tb->login_sistema),
            'login.id_usuario = vendedores.id_vendedor',array('*'));
         
        $sql->where('login.nivel = 5');
         
        $sql = $sql->query(Zend_Db::FETCH_OBJ);
        $this->view->vendedores = $sql->fetchAll();
        
    	$this->render('edit');
    	
    }
    
    public function editarAction()
    {
    	
    	
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('USER'=>$this->config->tb->usuarios_gerenciador),array('*'));
    	
    		$sql->joinLeft(array('LOGIN'=>$this->config->tb->login_gerenciador),
    			'USER.id_usuario = LOGIN.id_usuario',array('*'));
    		
    		$sql->joinLeft(array('vendedores'=>$this->config->tb->vendedores),
    		    'USER.id_vendedor = vendedores.id_vendedor',array('vendedor'));
    	
    		$sql->where('USER.id_usuario = ?', $this->view->id);
    		$sql->order('USER.id_usuario DESC');
    	
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$result = $sql->fetchAll();
    	$this->view->row = $result[0];
    	$usuarios_categorias = new usuarios_categorias();
    	$this->view->usuarios_categorias = $usuarios_categorias->fetchAll('id_usuario = "'.$this->id.'"');
    	
    	$cats = array();
    	foreach ($this->view->usuarios_categorias as $row){
    		
    		$cats[$row->id_categoria] = $row->id_categoria;
    		
    	}
    	$this->view->usuarios_categorias = $cats;
    	
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('vendedores'=>$this->config->tb->vendedores),array('*'));
    	 
    	$sql->joinLeft(array('login'=>$this->config->tb->login_sistema),
    	    'login.id_usuario = vendedores.id_vendedor',array('*'));
    	 
    	$sql->where('login.nivel = 5');
    	 
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$this->view->vendedores = $sql->fetchAll();
    	
    	$this->render('edit');
    	
    }
    
    public function actionAction ()
    {
    	
    	$post = $this->_request->getPost();
    	$params = $this->_request->getParams();
    	
    	// CASO EXISTE ID, FAZ A SELECT
    	if ($this->id){
    		 
    		$sql = new Zend_Db_Select($this->db);
	    	$sql->from(array('USER'=>$this->config->tb->usuarios_gerenciador),array('*'));
	    	
	    		$sql->joinLeft(array('LOGIN'=>$this->config->tb->login_gerenciador),
	    			'USER.id_usuario = LOGIN.id_usuario',array('*'));
	    	
	    		$sql->where('USER.id_usuario = ?', $this->view->id);
	    		$sql->order('USER.id_usuario DESC');
	    	
	    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
	    	$result = $sql->fetchAll();
    			  
    		$this->view->row = $this->row = $result[0];
    		
    		
    	}
    	
    	$method = $_SERVER['REQUEST_METHOD'];
    	
    	// VERIFICA SE EXISTE POST, SE EXISTE FAZ UMA VALIDAÇÃO DE INSERT OU UPDATE
    	if ($method == 'POST'){
    		
    		$upload = $this->usuarios->load_options('logo',array('path' => '/assets/uploads/contas/logo/',
    				'where' 	=> NULL,
    				'sizeW' 	=> 3000,
    				'type' 		=> 'image',
    				'root' 		=> $_SERVER ['DOCUMENT_ROOT'].'/'));
    		
    		$upload = $this->usuarios->load_options('logotipo',array('path' => '/assets/uploads/contas/logotipo/',
    				'where' 	=> NULL,
    				'sizeW' 	=> 3000,
    				'type' 		=> 'image',
    				'root' 		=> $_SERVER ['DOCUMENT_ROOT'].'/'));
    		
    		$upload = $this->usuarios->load_options('background',array('path' => '/assets/uploads/contas/background/',
    				'where' 	=> NULL,
    				'sizeW' 	=> 3000,
    				'type' 		=> 'image',
    				'root' 		=> $_SERVER ['DOCUMENT_ROOT'].'/'));
    		
    		$upload = $this->usuarios->load_options('favicon',array('path' => '/assets/uploads/contas/favicon/',
    				'where' 	=> NULL,
    				'sizeW' 	=> 3000,
    				'type' 		=> 'image',
    				'root' 		=> $_SERVER ['DOCUMENT_ROOT'].'/'));
    		
    		$filter = new Filter_Acentos();
    		$post['slug'] = $filter->filter($post['nome']);
    		
    		//zink
    		$post['gid'] = $post['slug'];
    		$post['fid'] = $post['gid'].'_fid';
    		$post['cid'] = $post['gid'].'_cid';
    		
    		$post['nivel'] = 2;
    		
    		if ($this->id){
	    		
    			// UPDATE
    			if ($post['senha'] != $this->view->row->senha){
    				$post['senha'] = md5($post['senha']);
    			} else {
    				$post['senha'] = $this->view->row->senha;
    			}
    			
    			$db_user = $this->usuarios->edit($this->id,$post,NULL,Model_Data::ATUALIZA);
    			$db_login = $this->login->edit($this->view->row->login,$post,NULL,Model_Data::ATUALIZA);
    			
	    	} else { 
	    		
	    		$db_user = $this->usuarios->edit(NULL,$post,NULL,Model_Data::NOVO);
	    		$post['id_usuario'] = $db_user;
	    		$post['senha'] = md5($post['senha']);
	    		$db_login = $this->login->edit(NULL,$post,NULL,Model_Data::NOVO);
	    		$this->id = $db_user;
	    		 
    		}
    		
    		
    		if ($db_user){
    			
    			$this->usuarios_categorias = new Model_Data(new usuarios_categorias());
    			$this->usuarios_categorias->_required(array('id_usuario_categoria', 'id_usuario', 'id_categoria', 'modificado', 'criado'));
    			$this->usuarios_categorias->_notNull(array());
    			$this->usuarios_categorias->_table()->getAdapter()->query('DELETE FROM zz_usuarios_categorias WHERE id_usuario = "'.$this->id.'"');
    			
    			foreach($post['id_template'] as $row){
    				$post['id_usuario'] = $this->id;
    				$post['id_categoria'] = $row;
    				$usuarios_categorias = $this->usuarios_categorias->edit(NULL,$post,NULL,Model_Data::NOVO);
    			}
    			
    			$this->_messages->addMessage('Registro salvo com sucesso.');
    			$this->_redirect('/'.$this->view->baseModule.'/'.$this->view->baseController);
    			
    		} else {
    			
    			$this->_messages->addMessage('Erro ao salvar.');
    			$this->_redirect($_SERVER['HTTP_REFERER']);
    	
    		}
    		
    	}
    		
    }
    
    public function novoUsuarioAction ()
    {
    	
    	$this->editarUsuarioAction();
    	
    	$this->render('editar-usuario');
    	
    }
    
    public function excluirAction ()
    {
    
    	$post = $this->_request->getPost();
    
    	$this->usuarios->_table()->getAdapter()->query('DELETE FROM zz_usuarios_gerenciador WHERE id_usuario IN ('.implode(',',$post[id]).')');
    	$this->login->_table()->getAdapter()->query('DELETE FROM zz_login_gerenciador WHERE id_usuario IN ('.implode(',',$post[id]).')');
    
    	$this->_messages->addMessage('Registro(s) excluido com sucesso.');
    	$this->_redirect('/'.$this->view->baseModule.'/'.$this->view->baseController);
    
    }

}