<?php

/**
 * CssController
 * 
 * @author
 * @version 
 */
	
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
//include_once 'app/models/db.php';

class CssController extends My_Controller 
{
	
	public function ini()
	{
    	//$this->view->tituloPag 	= 'NAICHE | Home';
    	
    	//
    	$params = $this->_request->getParams();
  		$this->file = $params['file'];
    	
	}
	
	/**
	 * The default action - show the home page
	 */
    public function indexAction ()
    {

    }
    
    public function geraAction ()
    {

    	if ( $this->view->production == 'test' )
    		$this->_redirect( '/assets/site/css/'. $this->file .'.css' );
    	 
    	// /assets/site/css/blog.css
    	$path = $this->view->pathUpload. '/assets/site/css/'. $this->file .'.css';
    	
    	$handle = file_get_contents ($path);
		
    	/*  */
    	$handle = preg_replace("#\r|\n#", "", $handle);

    	$handle = ltrim($handle);
    	$handle = rtrim($handle);
    	$handle = trim($handle);
    	
    	$handle = str_replace("  ", "", $handle);
    	$handle = str_replace("&nbsp;&nbsp;", "", $handle);
    	$handle = str_replace("	", "", $handle);
    	
    	$handle = str_replace("../images/", "/assets/site/images/", $handle);
    	$handle = str_replace("../fonts/", "/assets/site/fonts/", $handle);
    	
		
    	header("Content-Type: text/css");
    	
    	echo $handle;
    	die();
    }
    
    
}