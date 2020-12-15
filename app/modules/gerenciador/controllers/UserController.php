<?php
	
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';
include_once 'app/models/Usuarios.php';
include_once 'app/models/Filter_Acentos.php';
include_once 'app/models/JasminApi.php';
include_once 'app/models/RedisHand.php';

class Gerenciador_UserController extends My_Controller 
{

	public function ini()
	{
	
		$params = $this->_request->getParams();
		$user = new UsuariosZigzag();
		
		$this->view->nivel = $user::nivelGerenciado;
		$this->id = $this->view->id = $params['id'];
		
		$this->usuarios = new Model_Data(new usuarios_gerenciador());
		$this->usuarios->_required(array('nome','email','slug','dominio','shorturl','logo','logotipo','logo_cor','cor_a','cor_a_hover','cor_a_font','cor_a_font_hover','cor_b','cor_b_hover','cor_b_font','cor_b_font_hover','cor_c','cor_c_hover','cor_c_font','cor_c_font_hover','background','favicon','modificado','json_sms','criado'));
		$this->usuarios->_notNull(array());
		
		$this->login = new Model_Data(new login_gerenciador());
		$this->login->_required(array('login','senha','ativo','id_usuario'));
		$this->login->_notNull(array());
		
		$cat = new categorias();
		$this->view->categorias = $cat->fetchAll();
		
	}
	
    public function indexAction ()
    {
    	
		$this->_redirect($this->view->baseModule);    	
    	
    }
    
    public function cadastrarAction()
    {
    	$this->render('edit');
    }
    
    public function editarAction()
    {
    	
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('USER'=>$this->config->tb->usuarios_gerenciador),array('*'));
    	
    		$sql->joinLeft(array('LOGIN'=>$this->config->tb->login_gerenciador),
    			'USER.id_usuario = LOGIN.id_usuario',array('*'));
    	
    		$sql->where('USER.id_usuario = ?', $this->view->id);
    		$sql->order('USER.id_usuario DESC');
    	
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$result = $sql->fetchAll();
    	
    	if ( $result[0]->json_sms ){
    	   $result[0]->json_sms = json_decode( $result[0]->json_sms );
    	}
    	
    	$this->view->row = $result[0];
    	
//     	echo '<pre>'; print_r( $this->view->row ); exit;
    	
    	$this->render('edit');
    	
    }
    
    public function actionAction ()
    {
    	
    	$post = $this->_request->getPost();
    	
    	$post['nivel'] = $this->view->nivel;
    	$params = $this->_request->getParams();
    	
		$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('USER'=>$this->config->tb->usuarios_gerenciador),array('*'));
    	
    		$sql->joinLeft(array('LOGIN'=>$this->config->tb->login_gerenciador),
    			'USER.id_usuario = LOGIN.id_usuario',array('*'));
    	
    		$sql->where('USER.id_usuario = ?', $this->view->id);
    		$sql->order('USER.id_usuario DESC');
    	
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$result = $sql->fetchAll();
		$this->view->row = $this->row = $result[0];
    	
    	$method = $_SERVER['REQUEST_METHOD'];
    	
    	// VERIFICA SE EXISTE POST, SE EXISTE FAZ UMA VALIDAÇÃO DE INSERT OU UPDATE
    	if ($method == 'POST'){
    	    
    	    $jasminApi = new jasminApi();
    	    
    	    $post['gid'] = substr('g'.$result[0]->id_usuario.$result[0]->slug, 0, 8);
    	    $post['fid'] = substr('f'.$result[0]->id_usuario.$result[0]->slug, 0, 8);;
    	    $post['cid'] = substr('c'.$result[0]->id_usuario.$result[0]->slug, 0, 8);
    	    
    	    $redisWhitelabel = new redisHand();
    	    $setRedis = [];
//     	    $setRedis['week_start'] = 0;
//     	    $setRedis['week_end'] = 6;
//     	    $setRedis['time_start'] = '00:00';
//     	    $setRedis['time_end'] = '23:59';
    	    $setRedis['ativo'] = 1;
    	    $setRedis['saldo'] = 1;
    	    $setRedis['connectores'] = "['".$post['cid']."']";
//     	    $setRedis['cliente'] = 'hand';
//     	    $setRedis['revenda'] = $post['gid'];
    	    $setRedis = $redisWhitelabel->SetWhitelabel( $post['gid'], $setRedis );
    	    
    	    //echo '<pre>'; print_r( $post ); print_r( $redisWhitelabel->redis_whitelabel->hmget('g3ops_ne') ); print_r( $setRedis ); exit;
    	    
    	    $post['json_sms'] = json_encode( 
    	        [
    	           'gid'=>$post['gid'],
    	           'fid'=>$post['fid'],
    	           'cid'=>$post['cid'],
    	           'sms'=> 
    	            [
    	               'src_addr'=>$post['src_addr'],
        	           'username_sms'=>$post['username_sms'],
        	           'password_sms'=>$post['password_sms'],
    	               'ip_sms'=>$post['ip_sms'],
    	               'port_sms'=>$post['port_sms'],
        	           'submit_throughput_sms'=>$post['submit_throughput_sms'],
    	           ]
    	        ]
    	    );
    	    
    	    //cria o group
    	    $group = $jasminApi->request('groups/', $jasminApi::MT_PAYLOAD, ['gid'=>$post['gid'] ], ['Content-Type:application/json']);
    	    print_r($jasminApi->debug());

    	    if ( $jasminApi->info['http_code'] != 200 && !$this->view->id ) {
    	        $this->_messages->addMessage('Erro ao salvar. ( Code g01 ) ');
    	        $this->_redirect($_SERVER['HTTP_REFERER']);
    	    }
    	    
//     	    //cria o filter
    	    $filter = $jasminApi->request('filters/', $jasminApi::MT_PAYLOAD, ['type'=>'GroupFilter','fid'=>$post['fid'],'parameter'=>$post['gid'] ], ['Content-Type:application/json'] );
    	    print_r($jasminApi->debug());

    	    if ( $jasminApi->info['http_code'] != 200 && !$this->view->id  ) {
    	        $this->_messages->addMessage('Erro ao salvar. ( Code f02 ) ');
    	        $this->_redirect($_SERVER['HTTP_REFERER']);
    	    }
    	    
    	    //cria o smppconns
    	    $smppsconns = $jasminApi->request('smppsconns/', $jasminApi::MT_PAYLOAD, ['cid'=> $post['cid']], ['Content-Type:application/json']);
    	    print_r( $jasminApi->debug() );
    	    
//     	    //atualiza os dados do smppconns
    	    $smppsconns_update = $jasminApi->request(
    	        'smppsconns/'.$post['cid'].'/',
    	        $jasminApi::MT_PATCH,
    	        [
    	            'src_addr'=>$post['src_addr'],
    	            'username'=>$post['username_sms'],
    	            'password'=>$post['password_sms'],
    	            'submit_throughput'=>$post['submit_throughput_sms'],
    	            'host'=>$post['ip_sms'],
    	            'port'=>$post['port_sms']
    	    
    	        ],
    	        ['Content-Type:application/json']
            );
    	    
    	    if ( $jasminApi->info['http_code'] != 200 && !$this->view->id  ) {
    	        $this->_messages->addMessage('Erro ao salvar. ( Code s03 ) ');
    	        $this->_redirect($_SERVER['HTTP_REFERER']);
    	    }
    	    
    	    print_r($jasminApi->debug());
    	    
//     	    //start o smppconns
    	    $smppsconns_start = $jasminApi->request('smppsconns/'.$post['cid'].'/start/', $jasminApi::MT_PUT, [] );
    	    print_r($jasminApi->debug());

    	    if ( $jasminApi->info['http_code'] != 200 && !$this->view->id  ) {
    	        $this->_messages->addMessage('Erro ao salvar. ( Code s04 ) ');
    	        $this->_redirect($_SERVER['HTTP_REFERER']);
    	    }
    	    
//     	    //cria o mtrouters
    	    $smppsconns_update = $jasminApi->request(
    	        'mtrouters/',
    	        $jasminApi::MT_PAYLOAD,
    	        [
    	            'type'=>'StaticMTRoute',
    	            'order'=>$result[0]->id_usuario,
    	            'rate'=>0,
    	            'smppconnectors'=>$post['cid'],
    	            'filters'=>$post['fid']
    	            	
    	        ], ['Content-Type:application/json']
    	    );
    	    print_r( $jasminApi->debug() );

    	    if ( $jasminApi->info['http_code'] != 200 && !$this->view->id  ) {
    	        $this->_messages->addMessage('Erro ao salvar. ( Code m05 ) ');
    	        $this->_redirect($_SERVER['HTTP_REFERER']);
    	    }
    	    
    		$upload = $this->usuarios->load_options('logo',array('path' => '/assets/uploads/contas/logo/',
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