<?php 

##exemplos de uso com metodos diferentes
##request('groups/', $jasminApi::MT_POST, ['gid'=>'post_insert']);
##request('groups/', $jasminApi::MT_GET, []);
##request('groups/post_insert/disable/', $jasminApi::MT_PUT);
##request('groups/post_insert/', $jasminApi::MT_DELETE);

class jasminApi 
{

    private $user       = 'hand';
    private $pass       = 'Hand!@#';

    private $host       = 'http://172.17.33.2:8000/api/';

    public $retorno     = null;
    public $info        = null;

    public $url         = null;
    public $header      = null;
    public $method      = null;
    public $params      = null;
    
    const MT_PAYLOAD    = 'PAYLOAD';
    const MT_POST       = 'POST';
    const MT_GET        = 'GET';
    const MT_JSON       = 'JSON';
    const MT_DELETE     = 'DELETE';
    const MT_PUT        = 'PUT';
    const MT_PATCH      = 'PATCH';
    
    public function __construct( $config = [] )
    {
        
        //sobrescreve as configs caso exista.
        if ( count($config) > 0 ):
            foreach ($config as $key => $conf ):
                $this->$key = $conf;
            endforeach;
        endif;
        
    }
    
    public function request( $service, $method, $params = null, $header = [] )
    {
        
        //concatena o metodo GET
        if ( $method == 'GET' )
        {
            
            $params = '?'.http_build_query($params);
            
            $this->method = $method;
            $service = $service.$params;
            $this->params = $params;
            
        }
        
        //curl init
        $process = curl_init();
        
        //seta url
        curl_setopt( $process, CURLOPT_URL, $this->host.$service);
        
        //monta url corretamente
        $this->url = $this->host.$service;
        
        //escreve todo header
        $headers = [];
        $headers[] = 'Authorization: Basic '.base64_encode( $this->user.':'.$this->pass );
//         $headers[] = 'Content-Type:application/json';
        
        foreach ( $header as $head ):
            $headers[] = $head;
        endforeach;
        
        $this->header = $headers;
        
        //header
        curl_setopt($process, CURLOPT_HTTPHEADER, 
            $headers
        );
        curl_setopt($process, CURLOPT_HEADER, 0);
        
        //tempo de execucao
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        
        //metodo delete
        if ( $method == 'DELETE' )
        {
            $this->method = $method;
            curl_setopt($process, CURLOPT_CUSTOMREQUEST, "DELETE");
        }
        
        //metodo put
        if ( $method == 'PUT' )
        {
            $this->method = $method;
            curl_setopt($process, CURLOPT_CUSTOMREQUEST, "PUT");
        }
        
        //metodo patch
        if ( $method == 'PATCH' )
        {
            
            $params = json_encode( $params );
            
            $this->method = $method;
            $this->params = $params;
            
            curl_setopt($process, CURLOPT_CUSTOMREQUEST, "PATCH");
            
            curl_setopt($process, CURLOPT_POSTFIELDS, $params);
            
        }
        
        //metodo post
        if ( $method == 'POST' )
        {
            $this->method = $method;
            $this->params = $params;
            curl_setopt($process, CURLOPT_POST, 1);
            curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query( $params ));
        }
        
        if ( $method == 'PAYLOAD' )
        {
            $this->method = $method;
            $this->params = json_encode( $params );
            
            curl_setopt($process, CURLOPT_POST, 1);
            curl_setopt($process, CURL_HTTP_VERSION_1_1, true);
            curl_setopt($process, CURLOPT_CUSTOMREQUEST, 'POST');
            
            curl_setopt($process, CURLOPT_POSTFIELDS, json_encode( $params ));
        }
        
        //metodo payload
        if ( $method == 'JSON' )
        {
            
            $params = json_encode( $params );
            
            $this->method = $method;
            $this->params = $params;
            
            curl_setopt($process, CURLOPT_POST, 1);
            curl_setopt($process, CURLOPT_POSTFIELDS, $params);
            
        }
        
        curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
        
        $this->retorno = curl_exec($process);
        $this->info = curl_getinfo($process);
        
        curl_close($process);

        if ( count(json_decode( $this->retorno )) ) {
            return json_decode( $this->retorno );
        } else {
            return $this->retorno;
        }
        
    }
    
    public function debug()
    {
    
        echo '<pre style="padding:1%; background:#EAEAEA;">';
        echo "<h2>URL: \n</h2>"; print_r( $this->url );
        echo "<h2>Header: \n</h2>"; print_r( $this->header );
        echo "<h2>Método: \n</h2>"; print_r( $this->method );
        echo "<h2>Parametros: \n</h2>"; print_r( $this->params );
        echo "<h2>Info Retorno: \n</h2>"; print_r( $this->info );
        echo "<h2>Retorno: \n</h2>"; print_r($this->retorno);
        echo '</pre>';
    
    }
    
}
    
?>