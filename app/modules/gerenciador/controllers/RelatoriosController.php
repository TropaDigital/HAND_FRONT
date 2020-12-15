<?php
	
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class Gerenciador_RelatoriosController extends My_Controller 
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
        
//         echo '<pre>'; print_r( $this->me ); exit;
        
        //usuarios
        $sql = new Zend_Db_Select($this->db);
        $sql->from(array('USER'=>$this->config->tb->usuarios),array('*'));
        $sql->joinLeft(array('LOGIN'=>$this->config->tb->login),
            'LOGIN.id_usuario = USER.id_usuario',array('*'));
        $sql->where('id_gerenciado = ?', $this->view->GerenciadorCustom->id_usuario);
        $sql = $sql->query(Zend_Db::FETCH_OBJ);
        $this->view->usuarios = $sql->fetchAll();
        
        $get = $this->_request->getParams();
        
//         $get['status'] = $get['status'] == 'PEND' ? '' : $get['status'];
        
        if ( empty($get['d_i']) ){
            $get['d_i'] = date('Y-m-d 00:00:00');
        }
        
        if ( empty($get['d_f']) ){
            $get['d_f'] = date('Y-m-d 23:59:59');
        }
        
        if ( empty($get['id_usuario']) ){
        
            $ids = [];
            foreach ( $this->view->usuarios as $row ){
        
                $ids[] = $row->id_usuario;
        
            }
            $get['id_usuario'] = implode(',', $ids);
             
        }
        
        $url = $this->view->backend.'api/relatorios/get-envios?id_usuario='.$get['id_usuario'];
        
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
        unset($filter_get['whitelabel']);
        unset($filter_get['id_usuario']);
        
        if ( empty($filter_get['id_usuario']) ){
            
            $id_usuario = array();
            foreach ( $this->view->usuarios as $user ) {
                $id_usuario[] = $user->id_usuario;
            }
            
            $filter_get['id_usuario'] = implode(',', $id_usuario);
            
        } else {
            
            $filter_get['id_usuario'] = $get['id_usuario'];
            
        }
        
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
            $get['d_i'] = date('Y-m-d 00:00:00');
        }
        
        if ( empty($get['d_f']) ){
            $get['d_f'] = date('Y-m-d 23:59:59');
        }
        
        //usuarios
        $sql = new Zend_Db_Select($this->db);
        $sql->from(array('USER'=>$this->config->tb->usuarios),array('*'));
        
        $sql->joinLeft(array('LOGIN'=>$this->config->tb->login),
    			'LOGIN.id_usuario = USER.id_usuario',array('*'));
        
        $sql->where('id_gerenciado = '.$this->view->GerenciadorCustom->id_usuario);
        
        $sql = $sql->query(Zend_Db::FETCH_OBJ);
        $this->view->usuarios = $sql->fetchAll();
    
        $filter_get = $get;
    
        // FILTRO DE LIMITE
        if ( $get['limit'] == NULL  ){
             
            $filter_get['limit'] = 10;
             
        } else {
    
            if ( $get['limit'] != 10 && $get['limit'] != 25 && $get['limit'] != 50 && $get['limit'] != 100 && $get['limit'] != 250 && $get['limit'] != 500 ){
    
                $filter_get['limit'] = 10;
    
            }
    
        }
    
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
    
        if ( empty($get['id_usuario']) ){
            
            $ids = [];
            foreach ( $this->view->usuarios as $row ){
                
                $ids[] = $row->id_usuario;
                
            }
            $get['id_usuario'] = implode(',', $ids);
           
        }
        
        $filter = http_build_query ( $filter_get );
        $url = $this->view->backend.'api/relatorios/get-sintetico-user?id_usuario='.$get['id_usuario'];
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
    
        // printar o nome do usuario que enviou
        
        if ( count($this->view->result->registros) ) {
            
            $id_usuarios = array();
            foreach ( $file->registros as $row ) {
                $id_usuarios[$row->id_usuario] = $row->id_usuario;
            }
            $id_usuarios = implode(',', $id_usuarios);
        
            $sql = new Zend_Db_Select($this->db);
            $sql->from(array('LOGIN'=>$this->config->tb->login),array('id_usuario'));
        
            $sql->joinLeft(array('USER'=>$this->config->tb->usuarios),
                'LOGIN.id_usuario = USER.id_usuario',array('name_user AS usuario', 'empresa'));
        
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

    public function templatesCompradosAction()
    {

        $get = $this->_request->getParams();

        if ( empty($get['d_i']) ){
            $get['d_i'] = date('Y-m-d 00:00:00');
        }

        if ( empty($get['d_f']) ){
            $get['d_f'] = date('Y-m-d 23:59:59');
        }

        //usuarios
        $sql = new Zend_Db_Select($this->db);
        $sql->from(array('USER'=>$this->config->tb->usuarios),array('*'));

        $sql->joinLeft(array('LOGIN'=>$this->config->tb->login),
            'LOGIN.id_usuario = USER.id_usuario',array('*'));

        $sql->where('id_gerenciado = '.$this->view->GerenciadorCustom->id_usuario);

        $sql = $sql->query(Zend_Db::FETCH_OBJ);
        $this->view->usuarios = $sql->fetchAll();

        $sql = new Zend_Db_Select($this->db);
        $sql->from(array('templates_comprados'=>$this->config->tb->templates_comprados),array('id_template_comprado', 'valor', 'criado'));

        $sql->joinLeft(array('landing_page'=>$this->config->tb->landing_page),
            'landing_page.id_landing_page = templates_comprados.id_landing_page',array('nome'));

        $sql->joinLeft(array('usuarios'=>$this->config->tb->usuarios),
        'usuarios.id_usuario = templates_comprados.id_usuario',array('name_user', 'empresa'));

        $sql->joinLeft(array('usuario_gerenciador'=>$this->config->tb->usuarios_gerenciador),
            'usuario_gerenciador.id_usuario = templates_comprados.id_gerenciado',array('nome AS whitelabel'));

        $sql->where('templates_comprados.id_gerenciado = '.$this->me->id_usuario);

        if ( $get['id_usuario'] ){
            $sql->where('templates_comprados.id_usuario = '.$get['id_usuario']);
        }

        if ( $get['id_gerenciado'] ){
            $sql->where('templates_comprados.id_gerenciado = '.$get['id_gerenciado']);
        }

        //periodo
        if ( $get['d_i'] ){
            $sql->where('templates_comprados.criado >= "'.$get['d_i'].' 00:00:00"');
        }
        if ( $get['d_f'] ){
            $sql->where('templates_comprados.criado <= "'.$get['d_f'].' 23:59:59"');
        }

        $sql->group('templates_comprados.id_template_comprado');

        $sql = $sql->query(Zend_Db::FETCH_OBJ);
        $this->view->result = $sql->fetchAll();

    }

    public function templatesCompradosSinteticoAction()
    {

        $get = $this->_request->getParams();

        if ( empty($get['d_i']) ){
            $get['d_i'] = date('Y-m-d 00:00:00');
        }

        if ( empty($get['d_f']) ){
            $get['d_f'] = date('Y-m-d 23:59:59');
        }

        //usuarios
        $sql = new Zend_Db_Select($this->db);
        $sql->from(array('USER'=>$this->config->tb->usuarios),array('*'));

        $sql->joinLeft(array('LOGIN'=>$this->config->tb->login),
            'LOGIN.id_usuario = USER.id_usuario',array('*'));

        $sql->where('id_gerenciado = '.$this->view->GerenciadorCustom->id_usuario);

        $sql = $sql->query(Zend_Db::FETCH_OBJ);
        $this->view->usuarios = $sql->fetchAll();

        $sql = new Zend_Db_Select($this->db);
        $sql->from(array('templates_comprados'=>$this->config->tb->templates_comprados),array('id_template_comprado', 'sum(valor) AS valor', 'criado'));

        $sql->joinLeft(array('landing_page'=>$this->config->tb->landing_page),
            'landing_page.id_landing_page = templates_comprados.id_landing_page',array('nome'));

        $sql->joinLeft(array('usuarios'=>$this->config->tb->usuarios),
            'usuarios.id_usuario = templates_comprados.id_usuario',array('name_user', 'empresa'));

        $sql->joinLeft(array('usuario_gerenciador'=>$this->config->tb->usuarios_gerenciador),
            'usuario_gerenciador.id_usuario = templates_comprados.id_gerenciado',array('nome AS whitelabel'));

        $sql->where('templates_comprados.id_gerenciado = '.$this->me->id_usuario);

        if ( $get['id_usuario'] ){
            $sql->where('templates_comprados.id_usuario = '.$get['id_usuario']);
        }

        if ( $get['id_gerenciado'] ){
            $sql->where('templates_comprados.id_gerenciado = '.$get['id_gerenciado']);
        }

        //periodo
        if ( $get['d_i'] ){
            $sql->where('templates_comprados.criado >= "'.$get['d_i'].' 00:00:00"');
        }
        if ( $get['d_f'] ){
            $sql->where('templates_comprados.criado <= "'.$get['d_f'].' 23:59:59"');
        }

        $sql->group('templates_comprados.id_usuario');

        $sql = $sql->query(Zend_Db::FETCH_OBJ);
        $this->view->result = $sql->fetchAll();

    }

    public function formAction()
    {

//         echo '<pre>'; print_r( $this->me ); exit;

        //usuarios
        $sql = new Zend_Db_Select($this->db);
        $sql->from(array('USER'=>$this->config->tb->usuarios),array('*'));
        $sql->joinLeft(array('LOGIN'=>$this->config->tb->login),
            'LOGIN.id_usuario = USER.id_usuario',array('*'));
        $sql->where('id_gerenciado = ?', $this->view->GerenciadorCustom->id_usuario);
        $sql = $sql->query(Zend_Db::FETCH_OBJ);
        $this->view->usuarios = $sql->fetchAll();

        $get = $this->_request->getParams();

//         $get['status'] = $get['status'] == 'PEND' ? '' : $get['status'];

        if ( empty($get['d_i']) ){
            $get['d_i'] = date('Y-m-d 00:00:00');
        }

        if ( empty($get['d_f']) ){
            $get['d_f'] = date('Y-m-d 23:59:59');
        }

        if ( empty($get['id_usuario']) ){

            $ids = [];
            foreach ( $this->view->usuarios as $row ){

                $ids[] = $row->id_usuario;

            }
            $get['id_usuario'] = implode(',', $ids);

        }
        $url = $this->view->backend.'api/relatorios/get-form?id_usuario='.$get['id_usuario'];

        $filter_get = $get;

        // FILTRO DE LIMITE
        if ( $get['limit'] == NULL  ){

            $filter_get['limit'] = 10;

        } else {

            if ( $get['limit'] != 10 && $get['limit'] != 25 && $get['limit'] != 50 && $get['limit'] != 100 && $get['limit'] != 250 && $get['limit'] != 500 ){

                $filter_get['limit'] = 10;

            }

        }

        $filter_get['order'] = 'id_contato_campanha-desc';
        unset($filter_get['whitelabel']);
        unset($filter_get['id_usuario']);

        if ( empty($_GET['id_usuario']) ){

            $id_usuario = array();
            foreach ( $this->view->usuarios as $user ) {
                $id_usuario[] = $user->id_usuario;
            }

            $filter_get['id_usuario'] = implode(',', $id_usuario);

        } else {

            $filter_get['id_usuario'] = $get['id_usuario'];

        }

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
                'LOGIN.id_usuario = USER.id_usuario',array('name_user AS usuario', 'empresa'));

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