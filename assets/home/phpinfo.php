<?phpphpinfo(); exit;
/**
 * Bootstap file for DEFAULT
 *
 * @author  Leandro Rizzo leandro.php@terra.com.br
 * @version $Id: index.php 4 2015-01-15 12:00:00Z $
 */
// Set the application root path
define('PATH_ROOT', realpath(dirname(__FILE__) . '/library'));
error_reporting(E_ALL & ~E_NOTICE);
//error_reporting(0);

//
ini_set('display_errors', '1');
ini_set('session.auto_start', '0');

//
ini_set('date.timezone', 'America/Sao_Paulo');

//echo date('Y-m-d H:i:s');

// Set include path
set_include_path(PATH_ROOT . PATH_SEPARATOR
. realpath(dirname(__FILE__) . '/app/modules/home/views/scripts'). PATH_SEPARATOR
. realpath(dirname(__FILE__) . '/app/modules/painel/views/scripts'). PATH_SEPARATOR
. realpath(dirname(__FILE__) . '/app/models'). PATH_SEPARATOR
. realpath(dirname(__FILE__) . ''). PATH_SEPARATOR
. get_include_path());

// Load required files
require_once 'library/Zend/Controller/Front.php';
require_once 'library/Zend/Config/Ini.php';
require_once 'library/Zend/Registry.php';
require_once 'library/Zend/Session/Namespace.php';
require_once 'library/Zend/Loader/Autoloader.php';
require_once 'library/Zend/Loader.php';

//
$production = 'test';
//$production = 'homolog';
//$production = 'production';
Zend_Registry::set('production', $production);

// Load Configuration
$config = new Zend_Config_Ini('config/configIniFile.ini', 'default', true);
$dbConfig = new Zend_Config_Ini('config/configIniFile.ini', $production, true);

$config->merge($dbConfig);
Zend_Registry::set('config', $config);

// Start Session
$session = new Zend_Session_Namespace('#$%HANDMKT#');
Zend_Registry::set('session', $session);

// Set up the DB controller
Zend_Loader_Autoloader::getInstance();
Zend_Loader::loadClass('Zend_Db');
Zend_Loader::loadClass('Zend_Db_Table');
Zend_Loader::loadClass('Zend_Filter_StripTags');
Zend_Loader::loadClass('Zend_Debug');

Zend_Session::start();

$db = Zend_Db::factory($config->db->adapter,
$config->db->config->toArray());
Zend_Db_Table::setDefaultAdapter($db);
Zend_Registry::set('db', $db);

//load controller front
Zend_Loader::loadClass('Zend_Controller_Front');

$front = Zend_Controller_Front::getInstance();

$router =   $front->getRouter();

// MODULO HOME, ROTA PADRÃO
$route = new Zend_Controller_Router_Route(
		':whitelabel/:controller/:action/*',
		array(
				'module' 		=> 'home',
				'controller' 	=> 'index',
				'action' 		=> 'index'
		)
);
$router->addRoute('default', $route);

$route = new Zend_Controller_Router_Route(
		'view/:id_usuario_preview/:whitelabel/:controller/:action/*',
		array(
				'module' 		=> 'home',
				'controller' 	=> 'index',
				'action' 		=> 'index'
		)
	);
$router->addRoute('previewAccount', $route);

$route = new Zend_Controller_Router_Route(
		'view-gerenciador/:id_usuario_preview/:gerenciador_view/:whitelabel/:controller/:action/*',
		array(
				'module' 		=> 'gerenciador',
				'controller' 	=> 'index',
				'action' 		=> 'index'
		)
	);
$router->addRoute('previewGerenciador', $route);

// MODULO SISTEMA - NAICHE
$route = new Zend_Controller_Router_Route(
		'sistema/:controller/:action/*',
		array(
				'module' 		=> 'sistema',
				'controller' 	=> 'index',
				'action' 		=> 'index'
		)
);
$router->addRoute('sistema', $route);

// MODULO GERENCIADOR - WHITELABEL
$route = new Zend_Controller_Router_Route(
		'gerenciador/:whitelabel/:controller/:action/*',
		array(
				'module' 		=> 'gerenciador',
				'controller' 	=> 'index',
				'action' 		=> 'index'
		)
);
$router->addRoute('gerenciador', $route);

// ROTA HOME
$route = new Zend_Controller_Router_Route(
		'home/:whitelabel/:controller/:action/*',
		array(
				'module' 		=> 'home',
				'controller' 	=> 'index',
				'action' 		=> 'index'
		)
);
$router->addRoute('home', $route);

// MODULO VENDEDOR - ADMIN
$route = new Zend_Controller_Router_Route(
    'vendedor/:gerenciador/:controller/:action/*',
    array(
        'module' 		=> 'vendedor',
        'controller' 	=> 'index',
        'action' 		=> 'index'
    )
    );
$router->addRoute('vendedor', $route);

// URL MINIFICADA DA CAMPANHA
$route = new Zend_Controller_Router_Route(
		'm/:shorturl',
		array(
				'module' 		=> 'home',
				'controller' 	=> 'templates',
				'action' 		=> 'detalhe'
		)
);
$router->addRoute('shorturl', $route);

// PREVIEW DA LANDING PAGE
$route = new Zend_Controller_Router_Route(
		'l/:id',
		array(
				'module' 		=> 'home',
				'controller' 	=> 'templates',
				'action' 		=> 'detalhe'
		)
);
$router->addRoute('landing', $route);

$subdomainRoute = new Zend_Controller_Router_Route_Hostname(
	'www.sandrayoshida.com.br',
	array('module' => 'home')
);
$router->addRoute(
	'subDomain',
	$subdomainRoute->chain(
		new Zend_Controller_Router_Route(
			'/:controller/:action/*', 
			array('controller'=>'index','action'=>'index')
		)
	)
);

//adding modules
$front->setControllerDirectory(array(
		'home'			=> './app/modules/home/controllers',
		'sistema'		=> './app/modules/sistema/controllers',
		'gerenciador'	=> './app/modules/gerenciador/controllers',
        'vendedor'		=> './app/modules/vendedor/controllers',
));
$front->setDefaultModule('home');

//adding a router
$front->throwExceptions(false);
$front->setBaseUrl($config->www->baseurl);
//run!
$front->dispatch();