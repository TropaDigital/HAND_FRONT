<?php
	
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class Vendedor_RelatoriosController extends My_Controller 
{

	public function ini()
	{
		
		$post = $this->_request->getPost();
		$params = $this->_request->getParams();
		
		// GERA O ID
		$this->view->id = $this->id = $params['id'];
		
		$this->view->tituloPag = 'ZigZag • Usuários';
		$this->view->cssPag = '<link rel="stylesheet" type="text/css" href="assets/site/css/index_new.css">';
		
	}
	
    public function indexAction()
    {
        
        $get = $this->_request->getParams();
        
//         $get['status'] = $get['status'] == 'PEND' ? '' : $get['status'];
        
        if ( $get['id_usuario'] && count($this->me->familia[$get['id_usuario']]) ){
            $id_usuario = $get['id_usuario'];
        } else {
            $id_usuario = $this->me->familia_ids;
        }
        
        if ( empty($get['d_i']) ){
            $get['d_i'] = date('Y-m-d');
        }
        
        if ( empty($get['d_f']) ){
            $get['d_f'] = date('Y-m-d');
        }
        
        $url = $this->view->backend.'api/relatorios/get-envios?id_usuario='.$id_usuario;
        
        $filter_get = $get;
    
        // FILTRO DE LIMITE
        if ( $get['limit'] == NULL  ){
            $filter_get['limit'] = 10;
        } else {
            if ( $get['limit'] != 10 && $get['limit'] != 25 && $get['limit'] != 50 && $get['limit'] != 100 && $get['limit'] != 250 && $get['limit'] != 500 ){
                $filter_get['limit'] = 10;
            }
        }
        
        $filter_get['order'] = 'id_sms_enviado-desc';
        unset($filter_get['gerenciador']);
        unset($filter_get['id_usuario']);
        
        $filter = http_build_query ( $filter_get );
        
        $url = $url.'&'.$filter;
    
        if ( $_GET['admin'] ) {
            echo $url;
            echo '<br/>';
            echo 'acessando a url acima:';
            echo file_get_contents( $url );
            exit;
        }
    
        $file = json_decode( file_get_contents( $url ) );
    
        $this->view->result = $file;
        
    }
    
    public function sinteticoAction()
    {
    
        $get = $this->_request->getParams();
        
        if ( empty($get['d_i']) ){
            $get['d_i'] = date('Y-m-d');
        }
        
        if ( empty($get['d_f']) ){
            $get['d_f'] = date('Y-m-d');
        }
        
        if ( $get['id_usuario'] && count($this->me->familia[$get['id_usuario']]) ){
            $id_usuario = $get['id_usuario'];
        } else {
            $id_usuario = $this->me->familia_ids;
        }
        
        $campanhas = new campanhas();
        $this->view->campanhas = $campanhas->fetchAll('id_usuario IN ('.$this->me->familia_ids.')');
        
        $camp = array();
        foreach ( $this->view->campanhas as $row ) {
            $camp[$row->id_campanha] = $row->campanha;
        }
         
        $this->view->camp = $camp;
        
        $url = $this->view->backend.'api/relatorios/get-envios?id_usuario='.$id_usuario;
    
        $filter_get = $get;
    
        // FILTRO DE LIMITE
        if ( $get['limit'] == NULL  ){
             
            $filter_get['limit'] = 10;
             
        } else {
    
            if ( $get['limit'] != 10 && $get['limit'] != 25 && $get['limit'] != 50 && $get['limit'] != 100 && $get['limit'] != 250 && $get['limit'] != 500 ){
    
                $filter_get['limit'] = 10;
    
            }
    
        }
    
        $filter_get['order'] = 'id_sms_enviado-desc';
        unset($filter_get['gerenciador']);
        unset($filter_get['id_usuario']);
    
        $filter = http_build_query ( $filter_get );
    
        $url = $url.'&'.$filter;$url = $this->view->backend.'api/relatorios/get-sintetico-user?id_usuario='.$id_usuario;

        $filter_get = $get;

        // FILTRO DE LIMITE
        if ( $get['limit'] == NULL  ){
            	
            $filter_get['limit'] = 10;
            	
        } else {
            	
            if ( $get['limit'] != 10 && $get['limit'] != 25 && $get['limit'] != 50 && $get['limit'] != 100 && $get['limit'] != 250 && $get['limit'] != 500 ){

                $filter_get['limit'] = 10;

            }
            	
        }

        if ( $get['download'] ) {
            $filter_get['limit'] = 10000;
        }

        $filter_get['order'] = 'id_sms_enviado-desc';
        unset($filter_get['whitelabel']);
        unset($filter_get['id_usuario']);

        $filter = http_build_query ( $filter_get );

        $url = $url.'&'.$filter;

        if ( $_GET['admin'] ) {
            echo $url;
            echo '<br/>';
            echo 'acessando a url acima:';
            echo file_get_contents( $url );
            exit;
        }

        $file = json_decode( file_get_contents( $url ) );
        $this->view->result = $file;
        
        if ( count($this->view->result->registros) ) {
            
            // printar o nome do usuario que enviou
            $id_usuarios = array();
            foreach ( $file->registros as $row ) {
                $id_usuarios[$row->id_usuario] = $row->id_usuario;
            }
            $id_usuarios = implode(',', $id_usuarios);
            
            $sql = new Zend_Db_Select($this->db);
            $sql->from(array('LOGIN'=>$this->config->tb->login),array('id_usuario'));
            
            $sql->joinLeft(array('USER'=>$this->config->tb->usuarios),
                'LOGIN.id_usuario = USER.id_usuario',array('name_user AS usuario'));
            
            $sql->joinLeft(array('USER_GERENCIADO'=>$this->config->tb->usuarios_gerenciador),
                'USER_GERENCIADO.id_usuario = LOGIN.id_gerenciado',array('nome AS gerenciador'));
            
            $sql->where('LOGIN.id_usuario IN ('.$id_usuarios.')');
            
            $sql = $sql->query(Zend_Db::FETCH_OBJ);
            $get_user = $sql->fetchAll();
            
            $this->view->get_user = array();
            foreach ( $get_user as $row ) {
                
                $this->view->get_user[$row->id_usuario] = $row;
                
            }
        
        }
        
    }
    
}