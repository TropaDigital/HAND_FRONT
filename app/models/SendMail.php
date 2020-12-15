<?php

/**
 * SendMail
 * 
 * @author Leandro Rizzo leandro.php@terra.com.br (Heavy Metal Is The Law!!!)
 * @category SendMail
 * @version 1.0
 */

function ConfigMail( $cfgUsername='no-reply2@leadsmanager.com.br',$cfgPassword='Iwr5coTYGgfm')
{
    $config = array('auth' 		=> 'login',
    				'username' 	=> $cfgUsername,
                    'password' 	=> $cfgPassword,
    		  		'port'		=> 465,
// 			  		'ssl' 		=> 'tls'
    				'ssl' 		=> 'ssl'
    				);
	return $config;
}

function SendMail( $msg 			= NULL,
				   $emailPara 		= 'no-reply2@leadsmanager.com.br',
				   $emailAssunto 	= 'HANDMKT',
				   $emailresposta 	= NULL,
				   $emailBcc 		= NULL,
				   $emailFrom 		= 'no-reply2@leadsmanager.com.br',
				   $nomeFrom 		= 'HANDMKT',
				   $cfgSmtp 		= 'mail.leadsmanager.com.br',
				   $config 			= NULL
				 )
{
	
	Zend_Loader::loadClass('Zend_Mail');
	Zend_Loader::loadClass('Zend_Mail_Transport_Smtp');
	
	if ( $config == NULL )
		$config = ConfigMail();
	
	$tr = new Zend_Mail_Transport_Smtp($cfgSmtp,$config);
    
    $mail = new Zend_Mail();
    
    /*
     * Reply-To
     */
    if  ( $emailresposta )
    {
    	$mail->setFrom($emailresposta, utf8_decode($nomeFrom));
    	$mail->setDefaultReplyTo($emailresposta, $nomeFrom);
    } else
    	$mail->setFrom($emailFrom, utf8_decode($nomeFrom));

    /*
     * COPIA OCULTA
     */
    if ( $emailBcc )
		$mail->addBcc($emailBcc);

	$mail->addTo($emailPara);
	$mail->setSubject( (utf8_decode($emailAssunto)) );
	$mail->setBodyHtml($msg);
	$mail->setBodyText($msg);

	try
	{
		$mail->send($tr);
		//$mail->send();

		return true;
		
	} catch (Exception $e)
	{
		$e = $e;
		
		return false;
	}
	
}
