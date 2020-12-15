<?php
	
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class Gerenciador_TemplatesController extends My_Controller
{

	public function ini()
	{
		
		$post = $this->_request->getPost();
		$params = $this->_request->getParams();
		
		// GERA O ID
		$this->view->id = $this->id = $params['id'];
		
		$this->sql = new Model_Data(new templates());
		$this->sql->_required(array('id_template', 'id_landing_page', 'id_categoria', 'id_categoria_gerenciador', 'pago', 'valor', 'template', 'status', 'modificado', 'criado'));
		$this->sql->_notNull(array());
		
		$this->landing = new Model_Data(new landing_page());
		$this->landing->_required(array('status'));
		$this->landing->_notNull(array());
		
	}
	
	public function ajaxAction()
	{
		
		$post = $this->_request->getPost();
		
		$sql = new Zend_Db_Select($this->db);
		$sql->from(array('LANDING'=>$this->config->tb->landing_page),array('id_landing_page','nome'))

			->joinLeft(array('USER'=>$this->config->tb->usuarios),
				'LANDING.id_usuario = USER.id_usuario',array('empresa'))

            ->joinLeft(array('LOGIN'=>$this->config->tb->login),
                'USER.id_usuario = LOGIN.id_usuario',array('id_gerenciado'))

            ->where('LOGIN.id_gerenciado = '.$this->me->id_usuario)
			->where('USER.empresa LIKE "%'.$post['empresa'].'%" AND LANDING.status != "template"');
				
		$sql = $sql->query(Zend_Db::FETCH_OBJ);
		$this->view->result = $sql->fetchAll();
		
		echo json_encode($this->view->result); exit;
		
	}
	
    public function indexAction ()
    {
    	
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('templates'=>$this->config->tb->templates),array('*'))
    	
    		->joinLeft(array('CAT'=>$this->config->tb->categorias_gerenciador),
    			'templates.id_categoria_gerenciador = CAT.id_categoria',array('categoria'))

            ->where('CAT.id_gerenciador = '.$this->me->id_usuario)
    		->order('templates.template DESC');
    	
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$this->view->result = $sql->fetchAll();
    	
    }
    
    public function editarAction ()
    {
    	
    	// CASO EXISTE ID, FAZ A SELECT
    	if ($this->id){
    		 
    		$sql = new Zend_Db_Select($this->db);
	    	$sql->from(array('templates'=>$this->config->tb->templates),array('*'))
	    	
	    		->joinLeft(array('LANDING'=>$this->config->tb->landing_page),
	    			'LANDING.id_landing_page = templates.id_landing_page',array('nome'))
	    			
	    		->joinLeft(array('USER'=>$this->config->tb->usuarios),
	    			'LANDING.id_usuario = USER.id_usuario',array('empresa'))
	    	
	    		->where('id_template = '.$this->id.' ');
	    	
	    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
	    	$this->view->result = $sql->fetchAll();
    			  
    		$this->view->row = $this->row = $this->view->result[0];
    		
    	}
    	
    	// CATEGORIAS
    	$categorias = new categorias_gerenciador();
    	$this->view->categorias = $categorias->fetchAll('id_gerenciador = '.$this->me->id_usuario);
    	
    	$this->render('edit');
    	
    	$method = $_SERVER['REQUEST_METHOD'];
    	
    	// VERIFICA SE EXISTE POST, SE EXISTE FAZ UMA VALIDAÇÃO DE INSERT OU UPDATE
    	if ($method == 'POST'){
    		
    		// POST/GET
    		$post = $this->_request->getPost();
    		$params = $this->_request->getParams();
    		$landing = array();
			$post['id_categoria'] = 999999999;
    		
    		if ($this->id){
	    		
    			$landing['status'] = 'ativo';
    			$db = $this->landing->edit($this->view->row->id_landing_page,$landing,NULL,Model_Data::ATUALIZA);
    			
    			$landing['status'] = 'template';
    			$db = $this->landing->edit($post['id_landing_page'],$landing,NULL,Model_Data::ATUALIZA);
    			
    			$db = $this->sql->edit($this->id,$post,NULL,Model_Data::ATUALIZA);
    			
	    	} else { 
	    		
	    		$landing['status'] = 'template';
	    		$db = $this->landing->edit($post['id_landing_page'],$landing,NULL,Model_Data::ATUALIZA);
	    		
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
    	
    }
    
    public function alteraStatusAction()
    {
    	 
    	$post = $this->_request->getPost();
    	
    	$templates = new templates();
    	$this->view->template = $templates->fetchAll('id_template = "'.$post['id'].'"');
    	
    	if ($post['ativo'] == 1){
    		$landing['status'] = 'template';
    	} else {
    		$landing['status'] = 'ativo';
    	}
    	$db = $this->landing->edit($this->view->template[0]->id_landing_page,$landing,NULL,Model_Data::ATUALIZA);
    	
    	$post['status'] = $post['ativo'];
    	$db_login = $this->sql->edit($post['id'],$post,NULL,Model_Data::ATUALIZA);
    	 
    }
    
    public function removerAction ()
    {
    	
    	$post = $this->_request->getPost();
    	
    	foreach($post['id'] as $row){
    		
    		$templates = new templates();
    		$this->view->template = $templates->fetchAll('id_template = "'.$row.'"');
    		
    		$landing['status'] = 'ativo';
    		$db = $this->landing->edit($this->view->template[0]->id_landing_page,$landing,NULL,Model_Data::ATUALIZA);
    		
    	}
    	
    	$this->sql->_table()->getAdapter()->query('DELETE FROM zz_templates WHERE id_template IN ('.$post[id].')');
    	
    	$this->_messages->addMessage('Registro(s) excluido com sucesso.');
    	$this->_redirect('/'.$this->view->baseModule.'/'.$this->view->baseController);
    	
    }

}