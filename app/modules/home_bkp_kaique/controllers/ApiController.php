<?php
// set_time_limit(90);
// ini_set('memory_limit', '256M');

include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class ApiController extends My_Controller 
{
	
    private $user = [];
    private $id_usuario = NULL;
    private $url = NULL;
    
    public $get = [];
    
    protected $filter = [];
    
	public function ini()
	{
	        
	    header('Content-Type: application/json');
	    
	    $this->get = $this->_request->getParams();
	    
	    $sql = new Zend_Db_Select($this->db);
	    $sql->from(array('LOGIN'=>$this->config->tb->login),array('*'));
	     
	    $sql->joinLeft(array('USER'=>$this->config->tb->usuarios),
	        'USER.id_usuario= LOGIN.id_usuario ',array('*'));
	     
	    $sql->where('LOGIN.login = "'.$this->get['login'].'"');
	    $sql->where('LOGIN.senha = "'.md5($this->get['pass']).'"');
	     
	    $sql = $sql->query(Zend_Db::FETCH_OBJ);
	    $fetch = $sql->fetchAll();
    	
	    if ( count($fetch) ){
	        
	        $this->user = current($fetch);
	        $this->id_usuario = $this->user->id_usuario;
	        $this->url = $this->view->backend.'api/relatorios/';
	        
	        $filter = [];
	        $filter['d_i'] = $this->get['startDate'];
	        $filter['d_f'] = $this->get['endDate'];
	        $filter['limit'] = $this->get['amount'];
	        $filter['p'] = $this->get['page'];
	        $filter['id_campanha'] = $this->get['idCampaign'];
	        
	        $this->filter = $filter;
	        
	    } else {
	        
	        header("HTTP/1.1 401 Unauthorized");
	        
	        echo json_encode(['error'=>true, 'message'=>'Login or password incorrect.']); exit;
	        
	    }
	    
	}
	
	protected function request( $api, $get = [] )
	{
	    
	    $get['id_usuario'] = $this->id_usuario;
	    $httpUrl = $api.'?'.http_build_query ( $get );
	    $api = file_get_contents($httpUrl);
	    
	    $response = [];
	    $response['url'] = $httpUrl;
	    $response['api'] = json_decode($api);
	    
	    return $response;
	    
	}
	
	public function aberturasAction()
	{
	     
	    $api = $this->request( $this->url.'get-aberturas', $this->filter );
	
	    echo json_encode( $api['api'] ); exit;
	     
	}
	
	public function interacoesAction()
	{
	    
        $api = $this->request( $this->url.'get-cliques', $this->filter );
        
        echo json_encode( $api['api'] ); exit;
	    
	}
	
	public function formulariosAction()
	{
	     
	    $api = $this->request( $this->url.'get-form', $this->filter );
	
	    echo json_encode( $api['api'] ); exit;
	     
	}

}