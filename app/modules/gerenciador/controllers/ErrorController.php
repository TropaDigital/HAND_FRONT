<?php
require_once 'app/models/My_Controller.php';

class Painel_ErrorController extends My_Controller 
{
	public function errorAction ()
	{
	    
		if (!Zend_Registry::get('config')->debug)
		{
		    
		    
			Zend_Loader::loadClass('Zend_Debug');
			Zend_Loader::loadClass('Zend_View_Exception');
			Zend_Loader::loadClass('Zend_Mail');
			Zend_Loader::loadClass('Zend_Mail_Transport_Smtp');
			
		    //$config = array('auth' 		=> 'login',
		    //                'username' 	=> 'error@naiche.com.br',
		    //                'password' 	=> '*********');
			
			//$tr = new Zend_Mail_Transport_Smtp('200.46.181.165',$config);			
			
			$front = Zend_Controller_Front::getInstance();
			$e = $front->getResponse()->getException();
			$e = $e[0];
			$msg = "Local: ". $_SERVER['REQUEST_URI']."\n\r"
				 . "Ip: ". $_SERVER['REMOTE_ADDR']."\n\r"
				 . $e->__toString();
			
	        $mail = new Zend_Mail();
	        $mail->setFrom('error@naiche.com.br','PAINEL CASADEMADEIRA');		
			
			$mail->addTo('devilween@gmail.com');
			$mail->setSubject('Erro: DEFAULT');
			$mail->setBodyText($msg);

			/*
			 * 
			 */
			$pos1 = strpos($_SERVER['REQUEST_URI'], 'favicon');
			if ( $pos1 == false )
			{
				//$mail->send($tr);
				$mail->send();
			}
			
			$this->_redirect('/');
		}
		
	}
}