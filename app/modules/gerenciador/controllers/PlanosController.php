<?php
	
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class Gerenciador_PlanosController extends My_Controller 
{

	public function ini()
	{
		
		$post = $this->_request->getPost();
		$params = $this->_request->getParams();
		
		// GERA O ID
		$this->view->id = $this->id = $params['id'];
		
		$this->view->tituloPag = 'ZigZag • Planos';
		$this->view->cssPag = '<link rel="stylesheet" type="text/css" href="assets/site/css/index_new.css">';

		$this->sql = new Model_Data(new planos());
		$this->sql->_required(array('plano','valor','campanhas_ativa','caixa_entrada','num_sms','id_gerenciador'));
		$this->sql->_notNull(array());
		
	}
	
    public function indexAction ()
    {
    	
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('PLANO'=>$this->config->tb->planos),array('*'));
    	
    		$sql->where('id_gerenciador = ?',$this->view->GerenciadorCustom->id_usuario);
    		$sql->order('PLANO.num_sms ASC');
    	
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$this->view->result = $sql->fetchAll();
    	
    }
    
    public function editarAction ()
    {
    	
    	// POST/GET
    	$post = $this->_request->getPost();
    	$params = $this->_request->getParams();
    	
    	// CASO EXISTE ID, FAZ A SELECT
    	if ($this->id){
    		 
    		$sql = new Zend_Db_Select($this->db);
	    	$sql->from(array('PLANO'=>$this->config->tb->planos),array('*'))
	    	
	    		->where('id_plano = '.$this->id.' ');
	    	
	    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
	    	$this->view->result = $sql->fetchAll();
    			  
    		$this->view->row = $this->row = $this->view->result[0];
    			  
    	}
    	
    	$method = $_SERVER['REQUEST_METHOD'];
    	
    	// VERIFICA SE EXISTE POST, SE EXISTE FAZ UMA VALIDAÇÃO DE INSERT OU UPDATE
    	if ($method == 'POST'){
    		
    		$post['id_gerenciador'] = $this->view->GerenciadorCustom->id_usuario;
    		
    		if ((int)$post['num_sms'] > $this->view->GerenciadorCustom->sms){
    		
    			$this->_messages->addMessage('Erro, não é possivel adicionar uma quantidade maior de SMS do que seu plano permite.');
    			$this->_redirect('/'.$this->view->baseModule.'/'.$this->view->baseController.'/'.$this->view->baseAction.'/id/'.$this->id);
    		
    		} elseif ((int)$post['campanhas_ativa'] > $this->view->GerenciadorCustom->campanhas){
    			
    			$this->_messages->addMessage('Erro, não é possivel adicionar uma quantidade maior de campanhas do que seu plano permite.');
    			$this->_redirect('/'.$this->view->baseModule.'/'.$this->view->baseController.'/'.$this->view->baseAction.'/id/'.$this->id);
    		
    		} else {
    		
	    		if ($this->id){
		    		
	    			$db = $this->sql->edit($this->id,$post,NULL,Model_Data::ATUALIZA);
	    			
		    	} else { 
		    		
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
    		
    }
    
    public function novoAction ()
    {
    	
    	$this->editarAction();
    	$this->render('editar');
    	
    }
    
    public function removerAction ()
    {
    	
    	$post = $this->_request->getPost();
    	
    	$this->sql->_table()->getAdapter()->query('DELETE FROM zz_planos WHERE id_plano IN ('.implode(',',$post[id]).')');
    	
    	$this->_messages->addMessage('Registro(s) excluido com sucesso.');
    	$this->_redirect('/'.$this->view->baseModule.'/'.$this->view->baseController);
    	
    }

}