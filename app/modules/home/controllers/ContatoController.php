<?php

include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class ContatoController extends My_Controller 
{
	
	public function ini()
	{
    	$this->view->tituloPag 	= 'Contato';
    	$this->view->jsPag = '<link rel="stylesheet" type="text/css" href="assets/site/css/contatos.css">';
    	
    	$this->data = new Model_Data(new contato());
    	$this->data->_required(array('id_contato', 'nome', 'email', 'telefone', 'assunto', 'mensagem', 'criado'));
    	$this->data->_notNull(array('nome', 'mensagem'));
    	
    	$post = $this->_request->getPost();
 
	}
	
    public function indexAction ()
    {
    	
    	
    	
    }
    
    public function enviarAction ()
    {
        
    	$post = $this->_request->getPost();
    	
    	$edt = $this->data->edit(NULL,$post,NULL,Model_Data::NOVO);
    		
    	// REQUIRE DA FUNÇÃO
    	require_once 'app/models/SendMail.php';
    	// MENSAGEM
    	$opc_sendmail['mensagem'] = '<div align="center" style="font-family:\'Arial\';">';
    	$opc_sendmail['mensagem'] .= '<div style="border:#dddddd 1pt solid;padding:15px;width:690px">';
    	$opc_sendmail['mensagem'] .= '<div style="border:#dddddd 1pt dashed;padding:22.5pt;background:#f6f6f6;margin-top:15px" align="left">';
    	$opc_sendmail['mensagem'] .= 'Email: <b>'.$post['email'].'</b><br />';
    	$opc_sendmail['mensagem'] .= 'Mensagem: <b>'.$post['mensagem'].'</b><br /><br />';
    	
    	$opc_sendmail['mensagem'] .= 'Empresa: <b>'.$this->me->empresa.'</b><br />';
    	$opc_sendmail['mensagem'] .= 'Login: <b>'.$this->me->login.'</b><br />';
    	
    	$opc_sendmail['mensagem'] .= '</div>';
    	$opc_sendmail['mensagem'] .= '</div>';
    	
    	// ASSUNTO
    	$opc_sendmail['assunto']  = '[ HANDMKT ]';
    	// EMAIL
    	$opc_sendmail['email'] = array($this->view->GerenciadorCustom->email);
    	// FUNÇÃO PARA ENVIAR
    	$envia = SendMail($opc_sendmail['mensagem'], $opc_sendmail['email'], $opc_sendmail['assunto'], NULL, NULL);	
    		
		if ( $envia ) {
			
			die('true');
			
		} else {
			
			die('false');
			
		}
    	
    }
}