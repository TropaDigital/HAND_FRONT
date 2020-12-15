<?php
	
include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class IndexController extends My_Controller 
{
	
	public function ini()
	{
    	$this->view->tituloPag 	= 'Início';
    	
    	$this->view->source_addr = $this->source_addr = $this->me->source_addr_sms;
    	
    	//if ( $_GET['teste'] == 'true' )
    	//    print_r( $this->me );
    	
	}
	
	public function getInfoUserAction()
	{
		
		$get = $this->_request->getParams();
		
		$user = new Zend_Db_Select($this->db);
		$user->from(array('SQL'=>$this->config->tb->usuarios),array('*'))
		
			->where('id_usuario = ?', $get['id']);
		
		$user = $user->query(Zend_Db::FETCH_OBJ);
		$fetch = $user->fetchAll();
		
		echo json_encode( $fetch[0] ); exit;
		
	}
	
	public function previewLinkAction()
	{
		$params = $this->_request->getParams();
		$this->view->id = $this->id = $params['id'];
	
		$lista_landing = new landing_page();
		$this->view->lista_landing = $lista_landing->fetchAll('id_landing_page = '.$this->id.'');
		echo $this->view->lista_landing[0]->shorturl;
		exit();
	}
	
	public function previewAction()
	{
		$params = $this->_request->getParams();
		$this->view->id = $this->id = $params['id'];
		
		$lista_landing = new landing_page();
		$this->view->lista_landing = $lista_landing->fetchAll('id_landing_page = '.$this->id.'');
	}
	
    public function indexAction ()
    {
    	
    	//$this->view->cssPag = '<link rel="stylesheet" type="text/css" href="assets/site/css/index.css">';
    	$this->view->cssPag = '
    			<link rel="stylesheet" type="text/css" href="assets/home/css/index_new.css">
    			<link rel="stylesheet" type="text/css" href="assets/home/css/calendario.css">';
    	
    	$params = $this->_request->getParams();
    	$post = $this->_request->getPost();
    	
    	// relatorio sintetico
    	$get = $this->_request->getParams();
    	
    	if ( empty($get['d_i']) ){
    	    $get['d_i'] = date('Y-m-d');
    	} else {
    	    $get['d_i'] = date('Y-m-d', strtotime($get['d_i']));
    	}
    	 
    	if ( empty($get['d_f']) ){
    	    $get['d_f'] = date('Y-m-d');
    	} else {
    	    $get['d_f'] = date('Y-m-d', strtotime($get['d_f']));
    	}
    	 
    	$id_usuario = implode(',', $this->me->familia);
    	 
    	// relatorio sintetico
    	$url = $this->view->backend.'api/relatorios/get-sintetico-user?id_usuario='.$id_usuario.'&d_i='.$get['d_i'].'&d_f='.$get['d_f'];

    	//die($url);
    	
    	$file = json_decode( file_get_contents( $url ) );
    	$this->view->sintetico = $file;
    	$this->view->sintetico_current = $file->total_registros > 0 ? current($file->registros) : 0;
    	
    	if ( $file->total_registros == 0 ) {
    	    
    	    $this->view->sintetico_current = (object)array();
    	    
    	    $this->view->sintetico_current->fila = 0;
    	    $this->view->sintetico_current->erros = 0;
    	    $this->view->sintetico_current->envios = 0;
    	    $this->view->sintetico_current->entregues = 0;
    	    $this->view->sintetico_current->nao_entregues = 0;
    	    
    	}
    	
    	// caixa de entrada
    	$url = $this->view->backend.'api/relatorios/get-mo?id_usuario='.$id_usuario.'&d_i='.$get['d_i'].'&d_f='.$get['d_f'].'&limit=4';		
		$file = json_decode( file_get_contents( $url ) );
    	$this->view->caixa_entrada = $file;
    	
    	// aberturas
    	$url = $this->view->backend.'api/relatorios/get-aberturas?id_usuario='.$id_usuario.'&d_i='.$get['d_i'].'&d_f='.$get['d_f'];
    	
    	if ( $_GET['kaique_home'] == 'true' ){
    	    echo $url; exit;
    	}
    	
//     	die( $url );
    	
    	$file = json_decode( file_get_contents( $url ) );
    	$this->view->aberturas = $file->total_registros;
    	
        // campanhas enviadas
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('SQL'=>$this->config->tb->campanhas_envio),array('count(id_envio) AS total'));
    	 
    	$sql->joinLeft(array('CAMPANHAS'=>$this->config->tb->campanhas),
    			'SQL.id_campanha = CAMPANHAS.id_campanha',array('id_usuario'));
    	
    	$sql->where('CAMPANHAS.id_usuario IN ("'.$id_usuario.'")');
	    $sql->where('SQL.status = "Campanha enviada"');
	    
	    $sql->where('SQL.criado >= "'.$get['d_i'].' 00:00:00"');
	    $sql->where('SQL.criado <= "'.$get['d_f'].' 23:59:59"');
	    
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$this->view->campanhas = $sql->fetchAll()[0]->total;
    	
    	// campanhas ativas
    	$sql = new Zend_Db_Select($this->db);
    	$sql->from(array('CAMPANHAS'=>$this->config->tb->campanhas),array('count(id_campanha) AS total'));
    	$sql->where('CAMPANHAS.id_usuario IN ("'.$id_usuario.'")');
    	$sql->where('"'.date('Y-m-d').'" BETWEEN date(periodo_inicio) AND date(periodo_final)');
    	$sql = $sql->query(Zend_Db::FETCH_OBJ);
    	$this->view->campanhas_ativas = $sql->fetchAll()[0]->total;
    	
    	// creditos consumidos
    	$this->view->creditos_usados = $this->creditosUtilizados( $get );
    	
//     	echo $this->view->creditos_usados; exit;
    	
    }
    
    private function creditosUtilizados( $get )
    {
        
        $sql = new Zend_Db_Select($this->db);
        $sql->from(array('SQL'=>$this->config->tb->usuarios_creditos_bloqueados),array('*'));
        
        if ( $get['d_i'] ){
            $sql->where('criado >= "'.$get['d_i'].' 00:00:00"');
        }
        
        if ( $get['d_f'] ){
            $sql->where('criado <= "'.$get['d_f'].' 23:59:59"');
        }
        
        $sql->where('id_usuario = "'.$this->me->id_usuario.'"');
        $sql->where('status = "1"');
        
        $sql = $sql->query(Zend_Db::FETCH_OBJ);
        $totalBloqueado = $sql->fetchAll();
        
        $campanhasBloq = array();
        
        $credits = 0;
        
        foreach ( $totalBloqueado as $row ) {
    
            $campanhasBloq[] = $row->id_campanha;
            $credits = $credits + $row->creditos;
        
        }
        
        $campanhasBloq = implode(',', $campanhasBloq);
        
        //sms confirmados
        $url = $this->view->backend.'/api/sms/get-credits?id_usuario='.$this->me->id_usuario.'&in_not_campanha='.$campanhasBloq.'&d_i='.$get['d_i'].'&d_f='.$get['d_f'];
        $creditsUsado = json_decode( file_get_contents( $url ) );
        
        return $credits + $creditsUsado->total;
        
    }
    
    public function relatoriosTotalAction ()
    {
    	
    	$params = $this->_request->getParams();
		$post = $this->_request->getPost();
		
		if (!$params['data_inicio']){
			$params['data_inicio'] = date('01-m-Y');
		}
		
		if (!$params['data_final']){
			$params['data_final'] =  date('00-m-Y', strtotime("+1 month"));
		}
		
		$d_i = explode('-',$params['data_inicio']);
		$d_f = explode('-',$params['data_final']);
		
		$dataInicio = $d_i[2].'-'.$d_i[1].'-'.$d_i[0].'00:00';
		$dataFinal = $d_f[2].'-'.$d_f[1].'-'.$d_f[0].'00:00';
    	
		$total_enviado = file_get_contents($this->view->backend.'/api/sms/get-enviados?id_usuario='.$this->me->id_usuario.'&data_i='.$dataInicio.'&data_f='.$dataFinal);
		$total_enviado = json_decode($total_enviado);
		$total_enviado = $total_enviado->total_registros;
		
		$sucesso = file_get_contents($this->view->backend.'/api/sms/get-enviados-retorno?id_usuario='.$this->me->id_usuario.'&status=CL&data_i='.$dataInicio.'&data_f='.$dataFinal);
		$sucesso = json_decode($sucesso);
		$sucesso = $sucesso->total_registros;
		
		$erro = $total_enviado - $sucesso;
		
		$erro = file_get_contents($this->view->backend.'/api/sms/get-enviados-retorno?id_usuario='.$this->me->id_usuario.'&status=E0&data_i='.$dataInicio.'&data_f='.$dataFinal);
		$erro = json_decode($erro);
		$erro = $erro->total_registros;
		
		$pendentes = $total_enviado - $sucesso - $erro;
		
    	echo json_encode(array(
    			'total_enviado'=>$total_enviado,
    			'pendentes'=>$pendentes,
    			'sucesso'=>$sucesso,
    			'erros'=>$erro,
    			'url-enviado'=>$this->view->backend.'/api/sms/get-enviados-retorno?id_usuario='.$this->me->id_usuario.'&status=CL&data_i='.$dataInicio.'&data_f='.$dataFinal
    		)
    	);
    	
    	exit();
    	
    }
    
    public function relatoriosAction ()
    {
    	
    	$params = $this->_request->getParams();
    	$post = $this->_request->getPost();
    	
    	$post['id_usuario'] = $this->me->id_usuario;
    	
    	echo $this->insertPostgre('relatorios','relatorio-mensal',$post,$params);
    	exit;
    	
    }
    
    public function totalNotificacoesAction()
    {
    	
    	$notificacoes = new notificacoes();
    	$this->view->notificacoes = $notificacoes->fetchAll('id_usuario = 0 OR id_usuario = '.$this->me->id_usuario.'');
    	
    	$notificacoes_lido = new notificacoes_lido();
    	$this->view->notificacoes_lido = $notificacoes_lido->fetchAll('id_usuario = 0 OR id_usuario = '.$this->me->id_usuario.'');
    	
    	$total = count($this->view->notificacoes) - count($this->view->notificacoes_lido);
    	
    	echo $total; exit();
    	
    }
    
    public function notificacoesAction()
    {
    	
    	$this->data = new Model_Data(new notificacoes_lido());
    	$this->data->_required(array('id_notificacao_lido','id_notificacao','id_usuario','criado','modificado'));
    	$this->data->_notNull(array('id_usuario','id_notificacao'));
    	
    	$params = $this->_request->getParams();
    	
    	$notificacoes = new Zend_Db_Select($this->db);
    	$notificacoes->from(array('N'=>$this->config->tb->notificacoes),array('*'))
    	
    		->joinLeft(array('NL'=>$this->config->tb->notificacoes_lido),
    			'N.id_notificacao = NL.id_notificacao',array('id_notificacao_lido','id_usuario AS user'))
    			
    		->order('N.id_notificacao DESC')
    		->where('N.id_usuario IN (0,'.$this->me->id_usuario.') AND NL.id_usuario NOT IN (0,'.$this->me->id_usuario.') OR NL.id_notificacao_lido IS NULL')
    		->group('N.id_notificacao');
    		
    	$notificacoes = $notificacoes->query(Zend_Db::FETCH_OBJ);
    	$this->view->notificacoes = $notificacoes->fetchAll();
    	
    	$array = array();
    	
    	foreach($this->view->notificacoes as $row){
    		
    		if ($params['active'] == 'active'){
	    		$post = array();
	    		$post['id_usuario'] = $this->me->id_usuario;
	    		$post['id_notificacao'] = $row->id_notificacao;
	    		$this->data->edit(NULL,$post,NULL,Model_Data::NOVO);
    		}
    		
    		array_push($array, array(
    				'tipo'=>$row->tipo,
    				'nivel'=>$row->nivel,
    				'mensagem'=>$row->mensagem,
    				'modificado'=>$row->modificado,
    				'criado'=>$row->criado
    			)
    		);
    		
    	}
    	
    	echo json_encode($array); exit();
    	
    }
    
}