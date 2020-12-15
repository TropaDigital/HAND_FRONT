<?php
include_once 'library/Zend/Controller/Action.php';
include_once 'app/models/Usuarios.php';
include_once 'app/models/operadora/twwClass.php';

class My_Controller extends Zend_Controller_Action {

	protected $_messages = null;
	
	public function init() {
		
		/* messages */
		$this->_messages 	= $this->_helper->getHelper('FlashMessenger');
		$this->view->e 		= current($this->_messages->getMessages());
		
		/* parse to view */
		$this->view->production 	= Zend_Registry::get ( 'production' );
		$this->view->baseModule 	= $this->getRequest ()->getModuleName ();
		$this->view->baseController = $this->getRequest ()->getControllerName ();
		$this->view->baseAction 	= $this->getRequest ()->getActionName ();
		$this->view->baseUrl 		= Zend_Registry::get ( 'config' )->www->baseurl;
		$this->view->baseImg 		= Zend_Registry::get ( 'config' )->www->baseimg;
		$this->view->baseHost 		= Zend_Registry::get ( 'config' )->www->host;
		$this->view->backend 		= Zend_Registry::get ( 'config' )->www->backend;
		$this->view->setor	 		= Zend_Registry::get ( 'config' )->www->setor;
		$this->view->pathUpload 	= $this->pathUpload = $_SERVER ['DOCUMENT_ROOT'] . (Zend_Registry::get ( 'config' )->www->baseimgUp);
		$this->view->controller 	= $this->view->baseController;
		$this->view->action 		= $this->view->baseAction;
		
		/* configs */
		$this->_helper->getHelper ( 'viewRenderer' )->setViewSuffix ( 'php' );
		$this->config 	= Zend_Registry::get ( 'config' );
		$this->session 	= Zend_Registry::get ( 'session' );
		$this->db 		= Zend_Registry::get ( 'db' );
		
		/* auth */
		$auth 		= new Zend_Auth_Storage_Session ( $this->config->www->sessionname );
		$this->auth = $auth;
		$this->me 	= $this->view->me = $auth->read ();
		Zend_Registry::set ( 'me', $this->view->me );
		
// 		session_destroy();
// 		$this->auth->clear();

		if (!$get['shorturl'] || $this->view->baseController != 'templates'):
		
			$get = $this->_request->getParams();
			$userConfig = new UsuariosZigzag();
			$permissoes = $userConfig->getPermissoes($this);
			
			// HOME
			if ($this->view->baseModule == 'home'):

				$this->view->userConfig = $userConfig->ModuleHome($this);
			
				if ($get['id_usuario_preview']):
				
					if ($this->me->nivel == $userConfig::nivelAdmin || $this->me->nivel == $userConfig::nivelGerenciado){
						
						$sql = new Zend_Db_Select($this->db);
						$sql->from(array('USER'=>$this->config->tb->usuarios),array('*'));
						
							$sql->joinLeft(array('LOGIN'=>$this->config->tb->login),
								'USER.id_usuario = LOGIN.id_usuario',array('*'));
						
							$sql->where('USER.id_usuario = ?', $get['id_usuario_preview']);
							
						$sql = $sql->query(Zend_Db::FETCH_OBJ);
						$this->view->sql = $sql->fetchAll();
						
						if ($this->me->id_usuario == $this->view->sql[0]->id_gerenciado):
							
							$this->view->me = $this->me = $this->view->sql[0];
						
						elseif ($this->me->nivel == $userConfig::nivelAdmin):
						
							$this->view->me = $this->me = $this->view->sql[0];
						
						endif;
						
					}
					
				endif;
				
				$sql = new Zend_Db_Select($this->db);
				$sql->from(array('USER'=>$this->config->tb->usuarios_gerenciador),array('*'));
				
					$sql->joinLeft(array('LOGIN'=>$this->config->tb->login_gerenciador),
						'USER.id_usuario = LOGIN.id_usuario',array('*'));
				
					$sql->joinLeft(array('PLANO'=>$this->config->tb->planos_gerenciador),
						'USER.id_plano = PLANO.id_plano',array('*'));
				
					if ($this->me->id_gerenciado):
						$sql->where('USER.id_usuario = "'.$this->me->id_gerenciado.'"');
					else:
						$sql->where('USER.slug = "'.$get['whitelabel'].'"');
					endif;
					
					$sql->order('USER.id_usuario DESC');
				
				$sql = $sql->query(Zend_Db::FETCH_OBJ);
				$this->view->GerenciadorCustom = $sql->fetchAll();
				$this->view->GerenciadorCustom = $this->view->GerenciadorCustom[0];
				
				if (!empty($this->me->id_plano)){
					$meuPlano = new planos();
					$this->view->planos = $meuPlano->fetchAll('id_plano = '.$this->me->id_plano);
				}
				
				if ($this->me->id_usuario):
					if (!$get['id_usuario_preview'] && $this->me->nivel != 3):
						if ($this->view->baseController != 'login'):
							$this->_redirect($this->view->baseModule.'/'.$this->view->GerenciadorCustom->slug.'/login');
						endif;
					endif;
				endif;
				
				if ($this->view->GerenciadorCustom->slug != $get['whitelabel']):
					
					$this->_redirect('/home/'.$this->view->GerenciadorCustom->slug);
					
				endif;
		
				if( $this->me->nivel == 3 ){
					
					$gastos = file_get_contents($this->view->backend.'/api/sms/get-enviados?id_usuario='.$this->me->id_usuario);
					$gastos = json_decode($gastos);
					
					$erro = file_get_contents($this->view->backend.'/api/sms/get-enviados-retorno?id_usuario='.$this->me->id_usuario.'&status=E0');
					$erro = json_decode($erro);
					
					$this->view->total_gasto = $gastos->total_registros - $erro->total_registros;
					$this->view->total_gasto = $this->view->total_gasto == NULL ? 0 : $this->view->total_gasto;
					// PLANO DO USUÁRIO
					$me = new usuarios();
					$this->view->meUser = $me->fetchAll('id_usuario = '.$this->me->id_usuario);
					
					if ($this->me->login_envio && $this->me->senha_envio){
						
						$tww = new tww($this->me->login_envio, $this->me->senha_envio);
						$this->view->sms_disponivel = $tww->creditos();
						
						if ($this->view->sms_disponivel == '-1'){
							
							$this->view->sms_disponivel = 999999999999;
							
						}
						
					
					} else {
						
						$this->view->sms_disponivel = 1234;
						
					}
					// MENUS COM PERMISSÕES
					if (!$_SESSION['menus']):
					
						$menus = new Zend_Db_Select($this->db);
						$menus->from(array('PERMISSOES'=>$this->config->tb->permissoes),array('*'));
						
							$menus->joinLeft(array('PERMISSOES_USER'=>$this->config->tb->usuarios_permissoes),
								'PERMISSOES.id_permissao = PERMISSOES_USER.id_permissao',array('*'));
							
							$menus->order('PERMISSOES.id_permissao ASC');
							$menus->where('PERMISSOES_USER.id_usuario = ?', $this->me->id_login);
							$menus->group('PERMISSOES.id_permissao');
							
						$menus = $menus->query(Zend_Db::FETCH_OBJ);
						$_SESSION['menus'] = $menus->fetchAll();
						
					endif;
					
					$this->view->menus = $_SESSION['menus'];
					
					
					$permi = new permissoes();
					$permissoesFetch = $permi->fetchAll('controller = "'.$this->view->baseController.'"');
					
					if (count($permissoesFetch) > 0):
					
						$permi = new usuarios_permissoes();
						$permissoesFetch = $permi->fetchAll('id_permissao = "'.$permissoesFetch[0]->id_permissao.'"');
						if (count($permissoesFetch) == 0):
						
							$this->_messages->addMessage(array('success'=>'Erro, você não tem permissão para acessar essa página.'));
							$this->_redirect('/'.$this->view->baseModule.'');
						
						endif;
					
					endif;
								
				};
				
				// CASO O USUARIO TENHA LOGIN DE ENVIO ENTRA AQUI
				if ( $this->me->login_envio != NULL && $this->me->login_envio != '' ):
					
					$usersFamily = new usuarios();
					$fetchFamily = $usersFamily->fetchAll("login_envio = '". $this->me->login_envio ."'");
					
					$this->view->familia = $fetchFamily;
					
					$this->view->me->familia = array();
					
					$i=0;
					foreach ( $fetchFamily as $usuario ) {
						
						$this->view->me->familia[$i] = $usuario->id_usuario;
						$i++;
						
					}
					
				else:
					
					$this->view->me->familia[0] = $this->me->id_usuario;
				
				endif;
				
			// GERENCIADOR
			elseif ($this->view->baseModule == 'gerenciador'):
			
				$this->view->userConfig = $userConfig->ModuleGerenciador($this);
			
				$planos = new planos();
				$this->view->planos = $planos->fetchAll(NULL,'valor ASC');
			
				$sql = new Zend_Db_Select($this->db);
				$sql->from(array('USER'=>$this->config->tb->usuarios_gerenciador),array('*'));
				
					$sql->joinLeft(array('LOGIN'=>$this->config->tb->login_gerenciador),
						'USER.id_usuario = LOGIN.id_usuario',array('*'));
					
					$sql->joinLeft(array('PLANO'=>$this->config->tb->planos_gerenciador),
							'USER.id_plano = PLANO.id_plano',array('*'));
				
					$sql->where('USER.slug = ?', $get['whitelabel']);
					$sql->order('USER.id_usuario DESC');
				
				$sql = $sql->query(Zend_Db::FETCH_OBJ);
				$this->view->GerenciadorCustom = $sql->fetchAll();
				$this->view->GerenciadorCustom = $this->view->GerenciadorCustom[0];
				
				if ($get['id_usuario_preview']):
					
					if ($this->me->nivel == $userConfig::nivelAdmin){
							
						$sql = new Zend_Db_Select($this->db);
						$sql->from(array('USER'=>$this->config->tb->usuarios_gerenciador),array('*'));
							
							$sql->joinLeft(array('LOGIN'=>$this->config->tb->login_gerenciador),
								'USER.id_usuario = LOGIN.id_usuario',array('*'));
							
							$sql->where('USER.id_usuario = ?', $get['id_usuario_preview']);
					
						$sql = $sql->query(Zend_Db::FETCH_OBJ);
						$this->view->sql = $sql->fetchAll();
						$this->view->me = $this->me = $this->view->sql[0];
					}
					
				endif;
				
				if ($this->view->GerenciadorCustom->slug != $get['whitelabel']):
				
					$this->_redirect($this->view->baseModule.'/'.$this->view->GerenciadorCustom->slug);
				
				endif;
				
				if ($this->me->nivel == $userConfig::nivelGerenciado):
					// RELATORIOS
					$this->getRelatorios();
				endif;
				
			elseif ($this->view->baseModule == 'sistema'):
				
				$this->view->userConfig = $userConfig->ModuleSistema($this);
			
				$planos = new planos_gerenciador();
				$this->view->planos = $planos->fetchAll(NULL,'valor ASC');
				
			endif;
			
			if ($get['whitelabel']):
			
				if ($get['id_usuario_preview']):
					
					if ($get['gerenciador_view']):
						$this->view->baseModule = 'view-gerenciador/'.$get['id_usuario_preview'].'/true/'.$get['whitelabel'];
					else:
						$this->view->baseModule = 'view/'.$get['id_usuario_preview'].'/'.$get['whitelabel'];
					endif;
					
				else:
				
					$this->view->baseModule = $this->view->baseModule.'/'.$get['whitelabel'];
				
				endif;
				
			endif;
			
			if ($permissoes['return'] == 'redirect'):
			
				//$this->_redirect($this->view->baseModule.'/login');
			
			endif;
			
		endif;
		
		if( isset($_REQUEST['action']) && method_exists($this, $_REQUEST['action']) ){
			$method = $_REQUEST['action'];
			$this->$method();
		}
		
		
		$get = $this->_request->getParams();
		
		if ( empty ( $get['whitelabel'] ) )
		{
	
			if ( $this->view->baseController == 'error' ){
				
				$this->_redirect('http://smsclique.com.br');
				
			}
			
		}
		
// 		$campanha = '';
// 		$id_contato = '5277255';
		
// 		$teste = $this->alphaID($campanha.$id_contato);
// 		$teste2 = $this->alphaID($campanha.$id_contato, true);
		
// 		echo $campanha.$id_contato;
// 		echo '<br/>';
// 		echo $teste;
// 		echo '<br/>';
// 		echo $teste2;
// 		exit;
		
		$this->ini();
		
	}
	
	/**
	 * Translates a number to a short alhanumeric version
	 *
	 * Translated any number up to 9007199254740992
	 * to a shorter version in letters e.g.:
	 * 9007199254740989 --> PpQXn7COf
	 *
	 * specifiying the second argument true, it will
	 * translate back e.g.:
	 * PpQXn7COf --> 9007199254740989
	 *
	 * this function is based on any2dec && dec2any by
	 * fragmer[at]mail[dot]ru
	 * see: http://nl3.php.net/manual/en/function.base-convert.php#52450
	 *
	 * If you want the alphaID to be at least 3 letter long, use the
	 * $pad_up = 3 argument
	 *
	 * In most cases this is better than totally random ID generators
	 * because this can easily avoid duplicate ID's.
	 * For example if you correlate the alpha ID to an auto incrementing ID
	 * in your database, you're done.
	 *
	 * The reverse is done because it makes it slightly more cryptic,
	 * but it also makes it easier to spread lots of IDs in different
	 * directories on your filesystem. Example:
	 * $part1 = substr($alpha_id,0,1);
	 * $part2 = substr($alpha_id,1,1);
	 * $part3 = substr($alpha_id,2,strlen($alpha_id));
	 * $destindir = "/".$part1."/".$part2."/".$part3;
	 * // by reversing, directories are more evenly spread out. The
	 * // first 26 directories already occupy 26 main levels
	 *
	 * more info on limitation:
	 * - http://blade.nagaokaut.ac.jp/cgi-bin/scat.rb/ruby/ruby-talk/165372
	 *
	 * if you really need this for bigger numbers you probably have to look
	 * at things like: http://theserverpages.com/php/manual/en/ref.bc.php
	 * or: http://theserverpages.com/php/manual/en/ref.gmp.php
	 * but I haven't really dugg into this. If you have more info on those
	 * matters feel free to leave a comment.
	 *
	 * The following code block can be utilized by PEAR's Testing_DocTest
	 * <code>
	 * // Input //
	 * $number_in = 2188847690240;
	 * $alpha_in  = "SpQXn7Cb";
	 *
	 * // Execute //
	 * $alpha_out  = alphaID($number_in, false, 8);
	 * $number_out = alphaID($alpha_in, true, 8);
	 *
	 * if ($number_in != $number_out) {
	 *   echo "Conversion failure, ".$alpha_in." returns ".$number_out." instead of the ";
	 *   echo "desired: ".$number_in."\n";
	 * }
	 * if ($alpha_in != $alpha_out) {
	 *   echo "Conversion failure, ".$number_in." returns ".$alpha_out." instead of the ";
	 *   echo "desired: ".$alpha_in."\n";
	 * }
	 *
	 * // Show //
	 * echo $number_out." => ".$alpha_out."\n";
	 * echo $alpha_in." => ".$number_out."\n";
	 * echo alphaID(238328, false)." => ".alphaID(alphaID(238328, false), true)."\n";
	 *
	 * // expects:
	 * // 2188847690240 => SpQXn7Cb
	 * // SpQXn7Cb => 2188847690240
	 * // aaab => 238328
	 *
	 * </code>
	 *
	 * @author  Kevin van Zonneveld &lt;kevin@vanzonneveld.net>
	 * @author  Simon Franz
	 * @author  Deadfish
	 * @author  SK83RJOSH
	 * @copyright 2008 Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD Licence
	 * @version   SVN: Release: $Id: alphaID.inc.php 344 2009-06-10 17:43:59Z kevin $
	 * @link    http://kevin.vanzonneveld.net/
	 *
	 * @param mixed   $in   String or long input to translate
	 * @param boolean $to_num  Reverses translation when true
	 * @param mixed   $pad_up  Number or boolean padds the result up to a specified length
	 * @param string  $pass_key Supplying a password makes it harder to calculate the original ID
	 *
	 * @return mixed string or long
	 */
	public function alphaID($in, $to_num = false, $pad_up = false, $pass_key = null)
	{
		$out   =   '';
		$index = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$base  = strlen($index);
	
		if ($pass_key !== null) {
			// Although this function's purpose is to just make the
			// ID short - and not so much secure,
			// with this patch by Simon Franz (http://blog.snaky.org/)
			// you can optionally supply a password to make it harder
			// to calculate the corresponding numeric ID
	
			for ($n = 0; $n < strlen($index); $n++) {
				$i[] = substr($index, $n, 1);
			}
	
			$pass_hash = hash('sha256',$pass_key);
			$pass_hash = (strlen($pass_hash) < strlen($index) ? hash('sha512', $pass_key) : $pass_hash);
	
			for ($n = 0; $n < strlen($index); $n++) {
				$p[] =  substr($pass_hash, $n, 1);
			}
	
			array_multisort($p, SORT_DESC, $i);
			$index = implode($i);
		}
	
		if ($to_num) {
			// Digital number  <<--  alphabet letter code
			$len = strlen($in) - 1;
	
			for ($t = $len; $t >= 0; $t--) {
				$bcp = bcpow($base, $len - $t);
				$out = $out + strpos($index, substr($in, $t, 1)) * $bcp;
			}
	
			if (is_numeric($pad_up)) {
				$pad_up--;
	
				if ($pad_up > 0) {
					$out -= pow($base, $pad_up);
				}
			}
		} else {
			// Digital number  -->>  alphabet letter code
			if (is_numeric($pad_up)) {
				$pad_up--;
	
				if ($pad_up > 0) {
					$in += pow($base, $pad_up);
				}
			}
	
			for ($t = ($in != 0 ? floor(log($in, $base)) : 0); $t >= 0; $t--) {
				$bcp = bcpow($base, $t);
				$a   = floor($in / $bcp) % $base;
				$out = $out . substr($index, $a, 1);
				$in  = $in - ($a * $bcp);
			}
		}
	
		return $out;
	}
	
	public function paginacao($array, $quantidade, $page)
	{
		
		$array = (array)$array;
		$result = array_chunk($array, $quantidade);
		$this->view->totalResult = count($result);
		return $result[$page - 1];
		
	}
	
	public function paginacaoView($atual, $total)
	{
		
		$params = $this->_request->getParams();
		$url = '';
		
		$i = 0;
		foreach ($params AS $indice=>$row){
			if ($indice != 'p' && $indice != 'controller' && $indice != 'action'){
				
				if($i == 0){
					
					$url .= '?'.$indice.'='.$row;
					
				} else {
					
					$url .= '&'.$indice.'='.$row;
					
				}
				$i++;
			}
		}
		
		if (count($params) > 0){
			$pageTipo = '&';
		} else {
			$pageTipo = '?';
		}
		
		$paginate = '<div class="paginacao">';
		for ($i = 1; $i <= $total; $i++) {
			
			if ($i == $atual){
				$paginate .= '<a class="inativo">'.$i.'</i>';
			} else {
				$paginate .= '<a href="/'.$this->view->baseModule.'/'.$this->view->baseController.'/'.$this->view->baseAction.'/'.$url.$pageTipo.'p='.$i.'">'.$i.'</a>';
			}
		
		}
		$paginate .= '</div>';
		return $paginate;
		
	}
	
	// POSTGREE
	public function postgre($controller = null, $action = null, $post = null, $get = null)
	{
		
		$file = $this->view->backend.''.$controller.'/'.$action.'?'.@http_build_query($get);

		if ($post){
			$postdata = http_build_query($post);
		} else {
			$postdata = $post;
		}
		
		$opts = array('http' =>
			array(
					'method'  => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
					'content' => $postdata
			)
		);
		
		$context  = stream_context_create($opts);
		$result = file_get_contents($file, false, $context);
		return (object)json_decode($result);
		
	}
	
	public function api($url, $post = null, $get = null)
	{
	
		$file = $this->view->backend.$url.'?'.@http_build_query($get);
	
		if ($post){
			$postdata = http_build_query($post);
		} else {
			$postdata = $post;
		}
	
		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);
	
		$context  = stream_context_create($opts);
		$result = file_get_contents($file, false, $context);
		return $result;
	
	}
	
	public function updatePostgre($controller = null, $action = null, $post = null, $get = null)
	{
		
		$go = $this->insertPostgre($controller, $action, $post, $get);
		return $go;
		
	}
	
	public function insertPostgre($controller = null, $action = null, $post = null, $get = null)
	{
	
		$file = $this->view->backend.''.$controller.'/'.$action.'?'.@http_build_query($get);
		
		if ($post){
			$postdata = http_build_query($post);
		} else {
			$postdata = $post;
		}
	
		$opts = array('http' =>
				array(
						'method'  => 'POST',
						'header'  => 'Content-type: application/x-www-form-urlencoded',
						'content' => $postdata
				)
		);
	
		$context  = stream_context_create($opts);
		$result = file_get_contents($file, false, $context);
		return $result;
		
	}
	
	// CREDITA USUARIO
	public function creditoUser($id_zoug, $type, $credit, $description, $sms)
	{
		 
		$post = array();
		$post['user'] = 'zigzag';
		$post['pass'] = 'zigzag';
		$post['id_zoug'] = $id_zoug;
		$post['type'] = $type;
		$post['credit'] = $credit;
		$post['description'] = $description;
		 
		$get = 'http://portal.zoug.net.br/api/credit';
		$postdata = http_build_query($post);
		
		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);
	
		$context  = stream_context_create($opts);
		$result = file_get_contents($get, false, $context);
		 
		//print_r($result);
	   
	}
	
	// EDITA CENTRO DE CUSTO
	public function apiZoug($credit, $sms, $id_zoug)
	{
		
		$this->usuarios = new Model_Data(new usuarios());
		$this->usuarios->_required(array('plano_zoug','modificado'));
		$this->usuarios->_notNull(array());
		
		$plano_zoug = $credit / $sms;
			
		if ($plano_zoug == '0.2'){
			$plano_zoug = '0.20';
		}
			
		if ($plano_zoug == '0.1'){
			$plano_zoug = '0.10';
		}
	
		$postUser = array();
		$postUser['plano_zoug'] = $plano_zoug;
		
		$db_user = $this->usuarios->edit($this->me->id_usuario,$postUser,NULL,Model_Data::ATUALIZA);
		
		if ($db_user){
			
			$post = array();
			$post['user'] = 'zigzag';
			$post['pass'] = 'zigzag';
			$post['id_zoug'] = $id_zoug;
			$post['plano'] = $plano_zoug;
			
			$get = 'http://portal.zoug.net.br/api/editCentro';
			$postdata = http_build_query($post);
				
			$opts = array('http' =>
				array(
					'method'  => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
					'content' => $postdata
				)
			);
				
			$context  = stream_context_create($opts);
			$result = file_get_contents($get, false, $context);
			
			//print_r($result);
			
		}
		
	}
	
	public function shorturl($input, $id_contato = null) {
		
		$base32 = array (
				'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
				'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p',
				'q', 'r', 's', 't', 'u', 'v', 'w', 'x',
				'y', 'z', '0', '1', '2', '3', '4', '5'
		);
	
		$hex = md5($input);
		$hexLen = strlen($hex);
		$subHexLen = $hexLen / 8;
		$output = array();
	
		for ($i = 0; $i < $subHexLen; $i++) {
			$subHex = substr ($hex, $i * 8, 8);
			$int = 0x3FFFFFFF & (1 * ('0x'.$subHex));
			$out = '';
	
			for ($j = 0; $j < 3; $j++) {
				$val = 0x0000001F & $int;
				$out .= $base32[$val];
				$int = $int >> 5;
			}
	
			$output[] = $out;
		}
	
		return $output;
	}
	
	public function enviarSms($dados, $user, $pass)
	{
		
		$get = $this->_request->getParams();
		$login = base64_encode($user.':'.$pass);
		
		$headr = array();
		$headr[] = 'Authorization: Basic '.$login;
		
		$url = 'http://sms1.zoug.net.br:8080/secure/send';
		
		$optArray = array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true
		);
		
		$fields = array(
			'to' => ($dados['to']),
			'content' => ($dados['content']),
			'dlr' => ($dados['dlr']),
			'dlr-url' => ($dados['dlr-url']),
			'dlr-level' => ($dados['dlr-level'])
		);
		
		$post = json_encode($fields);
		
		//open connection
		$ch = curl_init();
		
		
		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt_array($ch, $optArray);
		
		//execute post
		$retorno = curl_exec($ch);
		$retornoJson = json_decode($retorno);
		
		//close connection
		curl_close($ch);
		
		$return = array();
		
		if (count($retornoJson) > 0):
			$return['retorno'] = $retornoJson;
			$return['data'] = $retornoJson->data;
			$return['message_id'] = str_replace('Success "', '', $retornoJson->data);
		else:
			$return['retorno'] = 'false';
			$return['data'] = $retornoJson;
		endif;
		
		return $return;
		
	}
	
	private function getRelatorios()
	{
		
		$relatorioCampanhas = new Zend_Db_Select($this->db);
		$relatorioCampanhas->from(array('LOGIN'=>$this->config->tb->login),array('id_gerenciado'));
			
			$relatorioCampanhas->joinLeft(array('CAMPANHAS'=>$this->config->tb->campanhas),
				'LOGIN.id_usuario = CAMPANHAS.id_usuario',array('count(id_campanha) AS total_campanha'));
		
			$relatorioCampanhas->where('LOGIN.id_gerenciado = ?', $this->me->id_usuario);
			$relatorioCampanhas->group('CAMPANHAS.id_campanha');
		
		$relatorioCampanhas = $relatorioCampanhas->query(Zend_Db::FETCH_OBJ);
		$minhasCampanahs = $relatorioCampanhas->fetchAll();
		$this->view->minhasCampanhas = $minhasCampanahs[0];
		
		$sql = new Zend_Db_Select($this->db);
		$sql->from(array('USER'=>$this->config->tb->usuarios),array('*'));
		
			$sql->joinLeft(array('LOGIN'=>$this->config->tb->login),
				'LOGIN.id_usuario = USER.id_usuario',array('*'));
		
			$sql->where('LOGIN.id_gerenciado = ?',$this->me->id_usuario);
			$sql->where('LOGIN.ativo = 1');
			$sql->group('USER.id_usuario');
		
		$sql = $sql->query(Zend_Db::FETCH_OBJ);
		$fetchUsersMeu = $sql->fetchAll();
		
		$this->view->relatorioMeusUsuarios = $fetchUsersMeu;
		
		$meusUsuarios = NULL;
		foreach($fetchUsersMeu as $row):
		
			if ($meusUsuarios != NULL):
				$meusUsuarios .= ','.$row->id_usuario;
			else:
				$meusUsuarios .= $row->id_usuario;
			endif;
		
		endforeach;
		
		return $this->view->meusUsuarios = $meusUsuarios;
		
	}
	
	public function __call($methodName, $arg) {
		$action = substr ( $methodName, 0, strlen ( $methodName ) - 6 );
		$this->render ( $action );
	}
	
}