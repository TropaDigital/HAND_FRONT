<?php
	
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';
include_once 'app/models/Usuarios.php';
include_once 'app/models/operadora/twwClass.php';

class Vendedor_RedisTesteController extends My_Controller 
{

	public function ini()
	{
	    
	    
	    
	}
	
	public function indexAction()
	{
	    
	    include 'app/models/RedisHand.php';
	    
	    //start, pause, cancel, resume ou edit
	    
	    $redis = new redisHand();
	    $data = [
	        'idCampaign'=>368,
	        'idLot'=>'None',
	        'action'=>'pause'
	    ];
	    $set = $redis->redis_campanha->lpush( 'load', $data );
	    
	    echo '<pre>'; print_r($set); exit;
	    
	}

}