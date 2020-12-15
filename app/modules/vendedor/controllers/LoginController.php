<?php
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';
include_once 'app/models/Usuarios.php';

class Vendedor_LoginController extends My_Controller 
{
	
	public function ini()
	{
		
	}
	
	public function indexAction()
    {
		
        $db = new Zend_Db_Select($this->db);
        $db->from(array('usuarios_gerenciador'=>$this->config->tb->usuarios_gerenciador));
        
        $db->where('usuarios_gerenciador.slug = ?', $this->_request->getParam('gerenciador'));
        	
        $db = $db->query(Zend_Db::FETCH_OBJ);
        $this->view->result = $db->fetch();
        
    	$this->login();

    }
    
    public function sairAction()
    {
    	
        $get = $this->_request->getParams();
        
    	$this->auth->clear();
    	$this->_redirect('/'.$this->view->baseModule.'/'.$get['gerenciador'].'/login');
    	
    }
    
	protected function login()
    {
    	 
        $get = $this->_request->getParams();
        
    	$this->auth = Zend_Auth::getInstance();
    	
    	try {
    		
    		$authAd = new Zend_Auth_Adapter_DbTable($this->db,$this->config->tb->login_sistema,'login','senha');
    		
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
    			 
    			if( $result->isValid() && $authAd->getResultRowObject()->ativo == 1 && ( $authAd->getResultRowObject()->nivel == UsuariosZigzag::nivelVendedorAdmin || $authAd->getResultRowObject()->nivel == UsuariosZigzag::nivelVendedorGerenciador ) ){
    				
    				$this->auth->setStorage(new Zend_Auth_Storage_Session($this->config->www->sessionname));
    				$this->auth->getStorage()->write($authAd->getResultRowObject(null, 'senha'));
    				
    				if( $authAd->getResultRowObject()->id_usuario > 0 ):
    					$db = new Zend_Db_Select($this->db);
    					$db->from(array('login'=>$this->config->tb->login_sistema));
    						
    					$db->join(array('vendedor'=>$this->config->tb->vendedores),
    					    'vendedor.id_vendedor = login.id_usuario', array('*'));
    						
    					$db->where('login.login = ?', $login);
    					$db->where('login.senha = ?', md5($senha));
    					
    					$db = $db->query(Zend_Db::FETCH_OBJ);
    					$result = $db->fetch();
    					
    					$this->auth->getStorage()->write($result);
    					
    				endif;
    				
    				if ( $this->view->r ):
    				
    					$this->_redirect(urldecode($this->view->r));
    				
    				endif;

    				$this->_redirect('/'.$this->view->baseModule.'/'.$get['gerenciador'].'/index');
    					
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
    	
    						if ( $authAd->getResultRowObject()->ativo == 1 && ( $authAd->getResultRowObject()->nivel== 5 && $authAd->getResultRowObject()->nivel== 6 ) ):
    							
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