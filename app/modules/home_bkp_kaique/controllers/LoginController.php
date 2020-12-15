<?php

use JWT\JWT;

include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';
include_once 'app/models/Usuarios.php';
include_once 'app/models/classes/UserClass.php';
include_once 'app/models/JWT/JWT.php';

class LoginController extends My_Controller 
{
	
	public function ini()
	{
	}
	
	public function statusTokenAction()
	{
		
		$get = $this->_request->getParams();		
		
	}
	
	private function validateToken()
	{
	     
	    try {
	        
	        $token = null;
	        
	        $headers = apache_request_headers();
	        
	        if(isset($headers['Authorization'])){
	            
	            $matches = array();
	            preg_match('/Token token="(.*)"/', $headers['Authorization'], $matches);
	            
	            if(isset($matches[1])){
	                
	                $token = $matches[1];
	                
	            }
	            
	        }
	        
	        $jwtClass = new JWT();
            $token = JWT::decode(str_replace('Bearer ', '', $headers['Authorization']), $jwtClass::$key, ['HS256']);
	         
            if ( !$token ){
                throw new \Exception('Autenticação inválida.');
            }
            
            return $token;
            
	    } catch ( \Exception $e ) {
	         
	        echo json_encode(['error'=>true, 'message'=>$e->getMessage()]); exit;
	         
	    }
	
	}
	
	public function getAuthAction()
	{
	    
	    try {
	        
	        header('Content-Type: application/json');
	        
	        $jwt = new JWT();
	        $response = array();
	        
	        $loginG = new login_gerenciador();
	        $fetchLogin = $loginG->fetchAll("login = '".$_POST['login']."' AND senha = '".md5($_POST['pass'])."'")->toArray();

	        $usuarioG = new usuarios_gerenciador();
	        $fetchUsuarios = $usuarioG->fetchAll("id_usuario = '".$fetchLogin[0]['id_usuario']."'");
	        
	        if ( count($fetchLogin) == 0 ){
	            throw new \Exception('Login or password incorrect.');
	        }
	        
	        $exp = time() + 3600 * 24 * 30;
	         
	        $loginResponse = [];
	        $loginResponse['id_usuario'] = $fetchLogin[0]['id_usuario'];
	        $loginResponse['json_sms'] = json_decode($fetchUsuarios[0]['json_sms']);
	        
	        //gera token
	        $token = array(
	            "iat"  => time(),
	            "iss"  => "http://10.0.0.222",
	            "exp"  => $exp,
	            "nbf"  => time() - 1,
	            "data" => $loginResponse
	        );
	         
	        $response['error'] = false;
	        $response['token'] = $jwt->encode($token, JWT::$key);
	        
	    } catch ( \Exception $e ){
	        
	        $response['error'] = true;
	        $response['message'] = $e->getMessage();
	        
	    }
	    
	    echo json_encode($response); exit;
	    
	}
	
	public function getUsersAction()
	{
	    
	    try {
	    
	        header('Content-Type: application/json');
	        
	        $token = $this->validateToken()->data;
	        $id_usuario = $token->id_usuario;
	        
	        $sql = new Zend_Db_Select($this->db);
	        $sql->from(array('login'=>$this->config->tb->login),array('id_usuario', 'id_login', 'login', 'nivel', 'criado'));
	        
	        $sql->joinLeft(array('usuarios'=>$this->config->tb->usuarios),
	            'usuarios.id_usuario = login.id_usuario',array('empresa', 'name_user', 'cnpj', 'email', 'telefone'));
	        
	        $sql->where('login.id_gerenciado = "'.$id_usuario.'"');
	        
	        $sql = $sql->query(Zend_Db::FETCH_OBJ);
	        $fetch = $sql->fetchAll();
	        
	        $response = [];
	        $response['error'] = false;
	        $response['data'] = $fetch;
	    
	    } catch ( \Exception $e ) {
	    
	        $response['error'] = true;
	        $response['message'] = $e->getMessage();
	    
	    }
	    
	    echo json_encode($response); exit;
	    
	}
	
	public function getCreditsAction()
	{
	     
	    try {
	         
	        header('Content-Type: application/json');
	         
	        $token = $this->validateToken()->data;
	        $id_usuario = $token->id_usuario;
	         
	        $sql = new Zend_Db_Select($this->db);
	        $sql->from(array('login'=>$this->config->tb->login),array());
	         
	        $sql->joinLeft(array('usuarios'=>$this->config->tb->usuarios),
	            'usuarios.id_usuario = login.id_usuario',array());
	        
	        $sql->joinLeft(array('usuarios_creditos'=>$this->config->tb->usuarios_creditos),
	            'usuarios.id_usuario = usuarios_creditos.id_usuario',array('creditos'));
	         
	        $sql->where('login.id_gerenciado = "'.$id_usuario.'"');
	        $sql->where('usuarios.id_usuario = "'.$_GET['id'].'"');
	         
	        $sql = $sql->query(Zend_Db::FETCH_OBJ);
	        $fetch = $sql->fetchAll();
	         
	        if ( count($fetch) == 0 ){
	            throw new \Exception('Nenhum registro encontrado nesse whitelabel.');
	        }
	        
	        $response = [];
	        $response['credits'] = $this->getCredits( $_GET['id'] )['credits'];
	        $response['history'] = $fetch;
	        $response['error'] = false;
	         
	    } catch ( \Exception $e ) {
	         
	        $response['error'] = true;
	        $response['message'] = $e->getMessage();
	         
	    }
	     
	    echo json_encode($response); exit;
	     
	}
	
	public function setCreditsAction()
	{
	
	    try {
	
	        header('Content-Type: application/json');
	
	        $token = $this->validateToken()->data;
	        $id_usuario = $token->id_usuario;
	
	        $sql = new Zend_Db_Select($this->db);
	        $sql->from(array('login'=>$this->config->tb->login),array('id_login'));
	
	        $sql->joinLeft(array('usuarios'=>$this->config->tb->usuarios),
	            'usuarios.id_usuario = login.id_usuario',array());
	         
	        $sql->where('login.id_gerenciado = "'.$id_usuario.'"');
	        $sql->where('usuarios.id_usuario = "'.$_GET['id'].'"');
	
	        $sql = $sql->query(Zend_Db::FETCH_OBJ);
	        $fetch = $sql->fetchAll();
	
	        if ( count($fetch) == 0 ){
	            throw new \Exception('Nenhum usuario encontrado nesse whitelabel.');
	        }
	        
	        $usuarios_creditos = new usuarios_creditos();
	        
	        $data = array();
	        $data['id_usuario'] = $_GET['id'];
	        $data['creditos'] = $_POST['credits'];
	        $data['criado'] = date('Y-m-d H:i:s');
	        
	        $save = $usuarios_creditos->insert( $data );
	        
	        if ( !$save ){
	            throw new \Exception('Não foi possivel adicionar crédito a esse usuario no momento.');
	        }
	        
	        $response = [];
	        $response['error'] = false;
	
	    } catch ( \Exception $e ) {
	
	        $response['error'] = true;
	        $response['message'] = $e->getMessage();
	
	    }
	
	    echo json_encode($response); exit;
	
	}
	
	public function userAction()
	{
	     
	    try {
	         
// 	        header('Content-Type: application/json');
	         
	        $token = $this->validateToken()->data;
	        $id_gerenciado = $token->id_usuario;
	        
	        $requireds = ['nome','login','senha','email','empresa','cnpj','telefone'];
	        
	        foreach ( $requireds as $key ){
	            if ( empty($_POST[$key]) ){
	                throw new \Exception("Campo $key é obrigatório.");
	            }
	        }
	        
	        $loginClass = new login();
	        $usuariosClass = new usuarios();
	        
	        $data = array();
	        $data['name_user'] = $_POST['nome'];
	        $data['email'] = $_POST['email'];
	        $data['empresa'] = $_POST['empresa'];
	        $data['cnpj'] = $_POST['cnpj'];
	        $data['telefone'] = $_POST['telefone'];
	        $data['tww'] = 'default';
	        $data['id_plano'] = 0;
	        $data['id_vendedor'] = 0;
	        $data['creditos'] = 0;
	        $data['login_envio'] = $token->json_sms->sms->username_sms;
	        $data['senha_envio'] = $token->json_sms->sms->password_sms;
	        $data['status'] = 1;
	        $data['criado'] = date('Y-m-d H:i:s');

	        if ( $_GET['id'] ){
	            
	           $edt = $usuariosClass->update( $data, 'id_usuario = "'.$_GET['id'].'"' );
	           $id_usuario = $_GET['id'];
	           
	        } else {
	            
	            $edt = $usuariosClass->insert( $data );
	            $id_usuario = $edt;
	            
	        }
	        
	        if ( !$edt ){
	            throw new \Exception('Não foi possivel realizar essa ação.');
	        }
	        
	        $data = array();
            $data['id_usuario'] = $id_usuario;
	        $data['id_gerenciado'] = $id_gerenciado;
	        $data['email'] = $_POST['email'];
	        $data['ativo'] = 1;
	        $data['login'] = $_POST['login'];
	        $data['senha'] = md5($_POST['senha']);
	        $data['nivel'] = 3;
	        $data['criado'] = date('Y-m-d H:i:s');
	        
	        if ( $_GET['id'] ){
	            
	           $edt = $loginClass->update( $data, 'id_usuario = "'.$_GET['id'].'"' );
	           $id_usuario = $_GET['id'];
	           
	        } else {
	            
	            $edt = $loginClass->insert( $data );
	            $id_usuario = $edt;
	            
	        }
	        
	        if ( !$edt ){
	            throw new \Exception('Não foi possivel realizar essa ação.');
	        }
	        
	        $response = [];
	        $response['error'] = false;
	         
	    } catch ( \Exception $e ) {
	         
	        $response['error'] = true;
	        $response['message'] = $e->getMessage();
	         
	    }
	     
	    echo json_encode($response); exit;
	     
	}
	
	public function rotinaSaldoAction()
	{
	     
	    //bloqueados
	    $this->bloq = new Model_Data(new usuarios_creditos_bloqueados());
	    $this->bloq->_required(array('id_credito_bloqueado', 'id_campanha', 'id_usuario', 'creditos', 'status', 'modificado', 'criado'));
	    $this->bloq->_notNull(array());
	
	    $sql = new Zend_Db_Select($this->db);
	    $sql->from(array('SQL'=>$this->config->tb->usuarios_creditos_bloqueados),array('*'));
	
	    $sql->where('status = "1"');
	
	    $sql = $sql->query(Zend_Db::FETCH_OBJ);
	    $totalBloqueado = $sql->fetchAll();
	
	    $campanhasBloq = array();
	
	    foreach ( $totalBloqueado as $row ) {
	
	        $campanhasBloq[] = $row->id_campanha;
	
	        $validaBloq = json_decode( file_get_contents( $this->view->backend.'api/relatorios/get-envios?id_campanha='.$row->id_campanha.'&limit=1'));
	
	        if ( $validaBloq->total_registros >= $row->creditos  ) {
	
	            $edt_envi = $this->bloq->edit($row->id_credito_bloqueado,array('status'=>0),NULL,Model_Data::ATUALIZA);
	
	        } else  {
	
	            $credits = $credits - $row->creditos;
	
	        }
	
	    }
	     
	    echo '<pre>'; print_r( $campanhasBloq ); exit;
	     
	}
	
// 	Usuário bloqueado:
// 	http://<URL_ZIGZAG>/?ttipo=usuario&idcliente=1&idusuario=4369&status=bloq
// 	Usuário desbloqueado:
// 	http://<URL_ZIGZAG>/?tipo=usuario&idcliente=1&idusuario=4369&status=ok
// 	Usuário excluido:
// 	http://<URL_ZIGZAG>/?tipo=usuario&idcliente=1&idusuario=4369&status=excluido
	
	
	public function tokenAction()
	{
		
		// DESTROI A SESSION CASO EXISTA
		session_destroy();
		$this->auth->clear();
		
		$get = $this->_request->getParams();
		
		if ( $get['tipo'] == 'usuario' ) {
				
			$sql = new Zend_Db_Select($this->db);
			$sql->from(array('USER'=>$this->config->tb->usuarios),array('*'));
				
			$sql->joinLeft(array('LOGIN'=>$this->config->tb->login),
					'USER.id_usuario= LOGIN.id_usuario ',array('*'));
				
			$sql->where("USER.tww LIKE '%idusuario\":\"".$get['idusuario']."\"%'");
			$sql->where("USER.tww LIKE '%cliente\":\"".$get['idcliente']."\"%'");
				
			$sql = $sql->query(Zend_Db::FETCH_OBJ);
			$fetch = $sql->fetchAll();
				
			$id_usuario = $fetch[0]->id_usuario;
			$id_login = $fetch[0]->id_login;
				
			if ( $id_usuario && $id_login ) {
		
				$status = $get['status'];
				$status = str_replace('bloq', '0', $status);
				$status = str_replace('ok', '1', $status);
		
				$this->user = new Model_Data(new usuarios());
				$this->user->_required(array('id_usuario', 'status'));
				$this->user->_notNull(array('id_usuario'));
		
				$this->login = new Model_Data(new login());
				$this->login->_required(array('login', 'id_usuario', 'ativo'));
				$this->login->_notNull(array('id_usuario'));
		
				if ( $status == 'excluido' ) {
						
					$del = $this->user->_table()->getAdapter()->query('DELETE FROM zz_usuarios WHERE id_usuario = "'.$id_usuario.'"');
					$del = $this->login->_table()->getAdapter()->query('DELETE FROM zz_login WHERE id_usuario = "'.$id_usuario.'"');
						
					if ( $del ) {
						die('Usuario excluido com sucesso.');
					} else {
						die('Erro ao excuir usuario.');
					}
						
				} else {
						
					$post['status'] = $status;
					$post['ativo'] = $status;
						
					$edt = $this->user->edit($id_usuario,$post,NULL,Model_Data::ATUALIZA);
					$edt = $this->login->edit($id_login,$post,NULL,Model_Data::ATUALIZA);
						
					if ( $edt ) {
						die('Usuario editado com sucesso.');
					} else {
						die('Erro ao editar usuario.');
					}
						
				}
		
			} else {
		
				die('Nenhum usuario encontrado.');
		
			}
		
		} elseif ( $get['tipo'] == 'Numusu' ) {
			
			
			$sql = new Zend_Db_Select($this->db);
			$sql->from(array('USER'=>$this->config->tb->usuarios),array('*'));
			
			$sql->joinLeft(array('LOGIN'=>$this->config->tb->login),
					'USER.id_usuario= LOGIN.id_usuario ',array('*'));
			
			$sql->where("USER.tww LIKE '%idusuario\":\"".$get['idusuario']."\"%'");
			$sql->where("USER.tww LIKE '%cliente\":\"".$get['idcliente']."\"%'");
			
			$sql = $sql->query(Zend_Db::FETCH_OBJ);
			$fetch = $sql->fetchAll();
			
			if ( count( $fetch ) > 0 ) {
			
				$status = $get['status'];
				$status = str_replace('bloq', '0', $status);
				$status = str_replace('ok', '1', $status);
			
				$this->user = new Model_Data(new usuarios());
				$this->user->_required(array('id_usuario', 'status'));
				$this->user->_notNull(array('id_usuario'));
			
				$this->login = new Model_Data(new login());
				$this->login->_required(array('login', 'id_usuario', 'ativo'));
				$this->login->_notNull(array('id_usuario'));
			
				if ( $status == 'excluido' ) {
			
					foreach ( $fetch as $row ) {
						
						$id_usuario = $row->id_usuairo;
						$id_login = $row->id_login;
						
						$del = $this->user->_table()->getAdapter()->query('DELETE FROM zz_usuarios WHERE id_usuario = "'.$id_usuario.'"');
						$del = $this->login->_table()->getAdapter()->query('DELETE FROM zz_login WHERE id_usuario = "'.$id_usuario.'"');
			
						if ( $del ) {
							echo ('Usuario excluido com sucesso.');
						} else {
							echo ('Erro ao excuir usuario.');
						}
					
					}
			
				} else {
			
					$post['status'] = $status;
					$post['ativo'] = $status;
			
					foreach ( $fetch as $row ) {
					
						$id_usuario = $row->id_usuairo;
						$id_login = $row->id_login;
					
						$edt = $this->user->edit($id_usuario,$post,NULL,Model_Data::ATUALIZA);
						$edt = $this->login->edit($id_login,$post,NULL,Model_Data::ATUALIZA);
				
						if ( $edt ) {
							echo ('Usuario editado com sucesso.');
						} else {
							echo ('Erro ao editar usuario.');
						}
					
					}
			
				}
			
			} else {
			
				die('Nenhum numusu encontrado.');
			
			}
			
			exit;
// 			http://<URL_ZIGZAG>/?ttipo=Numusu&numusu=TWWCORP&status=bloq
			
		} else {
		
			// WEBCORP TWW
			$this->view->webcorp = file_get_contents('http://webcorp.tww.com.br/inc/misc/zigzag.do?numusu='.$get['numusu'].'&usuario='.$get['usuario'].'&token='.$get['token']);
			
			$postWebCorp = json_decode($this->view->webcorp);
			
			
			if ( !empty($postWebCorp->idusuario) ) {
			
				
				// REALIZA LOGIN
				$post = $this->_request->getPost();
				$this->login();
				
				// ESTATICOS
				$post['id_plano'] = 1;
				$post['id_gerenciado'] = 2;
				$post['nivel'] = 3;
				$post['ativo'] = 1;
				
				// PREENCHIMENTO VIA WEBCORP
				$post['name_user'] = $postWebCorp->nomeusuario;
				$post['empresa'] = $postWebCorp->nome;
				$post['cnpj'] = NULL;
				$post['email'] = $postWebCorp->emailusuario;
				$post['telefone'] = NULL;
				$post['creditos'] = NULL;
				$post['tww'] = $this->view->webcorp;
				$post['login'] = $postWebCorp->usuario.':'.$postWebCorp->idusuario;
				$post['senha'] = md5($postWebCorp->idusuario);
				$post['senha_original'] = $postWebCorp->idusuario;
				$post['login_envio'] = $postWebCorp->numusu;
				
				$permissoes = $postWebCorp->permissoes;
				
				// CLASS USER
				$userClass = new UserClass($this->db, $this->config);
				
				// VERIFICA SE JÁ EXISTE ESSE USUARIO
				$filter = array();
				$filter['where'] = 'LOGIN.login = "'.$post['login'].'"';
				$usuarioFetch = $userClass->get($filter);
				$valida = count($usuarioFetch);
				
				// VERIFICA SE JA EXISTE UMA CONTA COM ESSE LOGIN DE ENVIO
				$filter = array();
				$filter['where'] = 'USUARIO.login_envio = "'.$post['login_envio'].'" AND USUARIO.senha_envio != ""';
				$myUser = $userClass->get($filter);
				
				if (count($myUser) > 0){
					$post['login_envio'] = $myUser[0]->login_envio;
					$post['senha_envio'] = $myUser[0]->senha_envio;
				}
				
				// INSERE
				if ($valida == 0){
					
					$usuario = $userClass->newUsuario($post);
					
					// INSERE O LOGIN
					if ($usuario){
						$post['id_usuario'] = $usuario;
						$login = $userClass->newLogin($post);
						
						// PERMISSOES DO USUARIO
						$userClass->permissoesUser($login, $permissoes);
						
					}
					
				} else {
				// ATUALIZA
				
					$userClass->editUsuario($usuarioFetch[0]->id_usuario, $post);
					$userClass->editLogin($usuarioFetch[0]->login, $post);
					$userClass->permissoesUser($usuarioFetch[0]->id_login, $permissoes);
					
				}
				
				// ATUALIZA A SENHA
				$post['senha_envio'] = $myUser[0]->senha_envio;
				
				$this->view->result = $post;
				
				
			} else {
				
				echo 'Token inválido.'; exit;
				
			}
			
		}
		
	}
	
	public function setSenhaAction()
	{
		
		$post = $this->_request->getPost();
		$get = $this->_request->getParams();
		
		$userClass = new UserClass($this->db, $this->config);
		
		// VERIFICA SE JÁ EXISTE ESSE USUARIO
		$filter = array();
		$filter['where'] = 'LOGIN.login = "'.$post['login'].'"';
		$usuarioFetch = $userClass->get($filter);
		
		// ATUALIZA SENHA
		$userClass->editUsuario($usuarioFetch[0]->id_usuario, $post);
		
		$user = new usuarios_gerenciador();
		$this->view->GerenciadorCustom = $user->fetchAll('slug = "'.$this->_request->getParam('whitelabel').'"');
		$this->view->GerenciadorCustom = current($this->view->GerenciadorCustom);
		
		$this->_redirect($this->view->baseModule.'/login/token?'.http_build_query($get));
		
	}
	
	public function indexAction()
    {
		
    	$this->login();

    }
    
    public function sairAction()
    {
    	
    	session_destroy();
    	$this->auth->clear();
    	$this->_redirect('/'.$this->view->baseModule.'/');
    	
    }
    
    public function recuperarAction()
    {
        
    	$post = $this->_request->getPost();
    
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('USER'=>$this->config->tb->usuarios),array('*'));
    		
    	$sql->joinLeft(array('LOGIN'=>$this->config->tb->login),
    	    'USER.id_usuario= LOGIN.id_usuario ',array('*'));
    		
    	$sql->where("LOGIN.login = '".$post['login']."' ");
    	$sql->where("USER.email = '".$post['email']."' ");
    	
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$this->view->usuario = $sql->fetchAll();
    	$total = count($this->view->usuario);
    	
    	if ($total > 0){
    
    		$url = base64_encode($post[login].'[-]'.$post[email].'[-]'.$this->view->usuario[0]->nivel.'[-]'.$this->view->usuario[0]->ativo.'[-]'.$this->view->usuario[0]->criado);
    
    		// REQUIRE DA FUNÇÃO
    		require_once 'app/models/SendMail.php';
    		// MENSAGEM
    		$opc_sendmail['mensagem'] = '<div align="center" style="font-family:\'Arial\';">';
    		$opc_sendmail['mensagem'] .= '<div style="padding:15px;background:#5ad2d1; width:450px; border-radius:5px; margin-top:30px;">';
    		$opc_sendmail['mensagem'] .= '<div style="padding:22.5pt;background:#FFF;margin-top:15px; border-radius:5px;" align="left">';
    		$opc_sendmail['mensagem'] .= '<span style="font-size:25px;">Olá <b>'.$post[login].'</b>.</span><br/><br/>';
    		$opc_sendmail['mensagem'] .= 'Uma nova senha foi solicitada, para resetar a atual <a href="http://'.$_SERVER['HTTP_HOST'].'/'.$this->view->GerenciadorCustom->slug.'/rc/index/get/'.$url.'">clique aqui</a>';
    		$opc_sendmail['mensagem'] .= '</div>';
    		$opc_sendmail['mensagem'] .= '<span style="padding-top:15px; display:inline-block;">Esse é um e-mail automatico, por gentileza não responder.</span>';
    		$opc_sendmail['mensagem'] .= '</div>';
    		
    		$opc_sendmail['assunto']  = 'Resetar senha';
    		$opc_sendmail['email'] = $post['email'];
    		
    		$envia = SendMail(utf8_decode(
    		    $opc_sendmail['mensagem']), 
    		    $opc_sendmail['email'], 
    		    $opc_sendmail['assunto'],
    		    NULL, 
    		    NULL, 
    		    'no-reply2@leadsmanager.com.br', 
    		    $this->view->GerenciadorCustom->nome
    		);
    
    		echo 'Um e-mail foi enviado para '.$post[email].', confira para resetar a senha.';
    
    	} else {
    
    		echo 'Usuário não encontrado.';
    
    	}
    
    	exit();
    }
    
	protected function login()
    {
    	 
    	$nivel = UsuariosZigzag::nivelUsuario;
    	
    	$this->auth = Zend_Auth::getInstance();
    	
    	try {
    		
    		$authAd = new Zend_Auth_Adapter_DbTable($this->db,$this->config->tb->login,'login','senha');
    		
    	} catch (Exception $e) {
    		
    		$this->view->e = $e;
    		
    	}
    	
    	$request = $this->getRequest();
    	$this->view->r = $request->getQuery('r');
    	
    	if ( $request->getPost('login') && $request->getPost('senha') ){
    		
    		$filter = new Zend_Filter_StripTags();
    		
    		$login = $filter->filter($request->getPost('login'));
    		$senha = $filter->filter($request->getPost('senha'));
    	
    		if ( !empty($login) && !empty($senha) ){
    			
    			require_once 'library/Zend/Auth/Storage/Session.php';
    			
    			$authAd->setIdentity($login)->setCredential($senha)->setCredentialTreatment('md5(?)');
    			$result = $authAd->authenticate();
    			 
    			if( $result->isValid() && $authAd->getResultRowObject()->ativo == 1 && $authAd->getResultRowObject()->id_gerenciado == $this->view->GerenciadorCustom->id_usuario && $authAd->getResultRowObject()->nivel == $nivel  ){
    				
    				$this->auth->setStorage(new Zend_Auth_Storage_Session($this->config->www->sessionname));
    				$this->auth->getStorage()->write($authAd->getResultRowObject(null, 'senha'));
    				
    				if( $authAd->getResultRowObject()->id_usuario > 0 ):
    					
	    				$user = new UsuariosZigzag();
    					$result = $user->getDados($nivel, $authAd->getResultRowObject()->id_login);
    					$this->auth->getStorage()->write($result);
    					
    				endif;
    				
    				if ( $this->view->r ):
    				
    					$this->_redirect(urldecode($this->view->r));
    				
    				endif;

    				$this->_redirect('/'.$this->view->baseModule.'/');
    					
    			} else {
    				
    				switch ($result->getCode())
    				{
    					
    					case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
    						
    						$e = "Não foi possível achar o usuário '". $login ."'";
    						break;
    							
    					case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
    						
    						$e = "Usuário e/ou senha incorretos";
    						break;
    							
    					case Zend_Auth_Result::SUCCESS:
    	
    						if ( $authAd->getResultRowObject()->ativo==1 && $authAd->getResultRowObject()->nivel==99 ):
    							
    							$e = "Você está logado...";
    							
    						else:
    						
    							$e = "Você não tem permissão para efetuar login...";
    						
    						endif;
    							
    						break;
    	
    					default:
    						
    						$e = "Ocorreu um erro no processo de logon, tente novamente em alguns minutos (".$result->getCode().")";
    						break;
    				}
    				
    				$this->view->e = html_entity_decode($e);
    			}
    		} else
    		{
    			$this->view->e = 'Os campos devem ser preenchidos.';
    		}
    		
    	}
    	
    	
    	if ( $this->view->r ):
    	
    		$this->_redirect(urldecode($this->view->r));
    	
    	endif;
    	
    }
    
}