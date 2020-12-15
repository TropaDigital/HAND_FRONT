<?php
require_once 'app/models/predis/autoload.php';

class redisHand {
    
    //configs redis campanhas
    const redis_ip_campanha = '172.17.33.3';
    const redis_porta_campanha = 6379;
    const redis_senha_campanha = 'babba672b8ddbb0f65dbb881c503dfda6548615c9f580d17e99883d18fe1aa45';
    
    //configs redis campanhas
    const redis_ip_sms = '172.17.33.3';
    const redis_porta_sms = 6379;
    const redis_senha_sms = 'babba672b8ddbb0f65dbb881c503dfda6548615c9f580d17e99883d18fe1aa45';
    
    const redis_ip_whitelabel = '172.17.33.3';
    const redis_porta_whitelabel = 6379;
    const redis_senha_whitelabel = 'babba672b8ddbb0f65dbb881c503dfda6548615c9f580d17e99883d18fe1aa45';
    
    public $redis_campanha = NULL;
    public $redis_sms = NULL;
    public $redis_whitelabel = NULL;
    
    public function __construct()
    {
        
        //die('alo');
        
        $redis = new Predis\Client([
            'scheme' => 'tcp',
            'host'   => $this::redis_ip_campanha,
            'port'   => $this::redis_porta_campanha,
            'database'=>'0',
            //'password'=>$this::redis_senha_campanha
        ]);
//         $redis->auth($this::redis_senha_campanha);
        
        //declara o redis da campanha
        $this->redis_campanha = $redis;
        
        $redis = new Predis\Client([
            'scheme' => 'tcp',
            'host'   => $this::redis_ip_sms,
            'port'   => $this::redis_porta_sms,
            'database'=>'1',
            //'password'=>$this::redis_senha_sms
        ]);
//         $redis->auth($this::redis_senha_sms);
        
        //declara o redis de sms
        $this->redis_sms = $redis;
        
        $redis = new Predis\Client([
            'scheme' => 'tcp',
            'host'   => $this::redis_ip_whitelabel,
            'port'   => $this::redis_porta_whitelabel,
            'database'=>'2',
            //'password'=>$this::redis_senha_sms
        ]);
//         $redis->auth($this::redis_senha_whitelabel);
        
        //declara o redis do whitelabel
        $this->redis_whitelabel = $redis;
        
    }
    
    public function SetWhitelabel( $name, $dados )
    {
        
        $set = $this->redis_whitelabel->hmset($name, $dados);
        return count($set);
        
    }
    
}