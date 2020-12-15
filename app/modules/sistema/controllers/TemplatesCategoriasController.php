<?php
	
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class Sistema_TemplatesCategoriasController extends My_Controller 
{

	public function ini()
	{
	
		$params = $this->_request->getParams();
		
		$this->id = $this->view->id = $params['id'];
		
		$this->data = new Model_Data(new categorias());
		$this->data->_required(array('id_categoria', 'categoria', 'imagem', 'descricao', 'status'));
		$this->data->_notNull(array());
		
	}
	
    public function indexAction ()
    {
    	
    	
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('CAT'=>$this->config->tb->categorias),array('*'));
    	
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$this->view->result = $sql->fetchAll();
    	
    	
    }
    
    public function cadastrarAction()
    {
    	$this->render('edit');
    }
    
    public function editarAction()
    {
    	
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('CAT'=>$this->config->tb->categorias),array('*'));
    	
    		$sql->where('CAT.id_categoria = ?', $this->view->id);
    	
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$result = $sql->fetchAll();
    	$this->view->row = $result[0];
    	
    	$this->render('edit');
    	
    }
    
    public function actionAction ()
    {
    	
    	$post = $this->_request->getPost();
    	$params = $this->_request->getParams();
    	
    	$method = $_SERVER['REQUEST_METHOD'];
    	
    	// VERIFICA SE EXISTE POST, SE EXISTE FAZ UMA VALIDAÇÃO DE INSERT OU UPDATE
    	if ($method == 'POST'){
    		
    		$this->data->load_options('imagem',array('path' => '/assets/uploads/templates-categorias',
    				'where' 	=> NULL,
    				'sizeW' 	=> 3000,
    				'type' 		=> 'image',
    				'root' 		=> $_SERVER ['DOCUMENT_ROOT'].'/'));
    		
    		if ($this->id){
	    		
    			$db = $this->data->edit($this->id,$post,NULL,Model_Data::ATUALIZA);
    			
	    	} else { 
	    		
	    		$db = $this->data->edit(NULL,$post,NULL,Model_Data::NOVO);
	    		 
    		}
    		
    		if ($db){
    			
    			$this->_messages->addMessage('Registro salvo com sucesso.');
    			$this->_redirect('/'.$this->view->baseModule.'/'.$this->view->baseController);
    			
    		} else {
    			
    			$this->_messages->addMessage('Erro ao salvar.');
    			$this->_redirect($_SERVER['HTTP_REFERER']);
    	
    		}
    		
    	}
    		
    }
    
    public function excluirAction ()
    {
    	 
    	$post = $this->_request->getPost();
    	 
    	$this->data->_table()->getAdapter()->query('DELETE FROM zz_categorias WHERE id_categoria IN ('.implode(',',$post[id]).')');
    	 
    	$this->_messages->addMessage('Registro(s) excluido com sucesso.');
    	$this->_redirect('/'.$this->view->baseModule.'/'.$this->view->baseController);
    	 
    }
    
}