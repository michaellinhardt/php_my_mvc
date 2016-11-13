<?php
header('content-type: text/html; charset=UTF-8');
/*
 * Constante de PATH, permetant de cibler un dossier
 * par son chemin exacte n'importe ou dans le code.
 */
define( 'START_UPTIME', microtime( true ) ) ; // Permet de loguer le temps d'acces à une page
define( 'ROOT_PATH', realpath( dirname( __FILE__ ) ) ) ;
define( 'PRIVATE_PATH', realpath( dirname( __FILE__ ) . '/private/' ) ) ;
define( 'CONFIG_PATH', realpath( dirname( __FILE__ ) . '/private/configs/' ) ) ;
define( 'VIEWS_PATH', realpath( dirname( __FILE__ ) . '/private/views/' ) ) ;
define( 'LIBS_PATH', realpath( dirname( __FILE__ ) . '/private/libs/' ) ) ;
define( 'LOGS_PATH', realpath( dirname( __FILE__ ) . '/private/libs/coreapp/logs/' ) ) ;
define( 'COREAPP_PATH', realpath( dirname( __FILE__ ) . '/private/libs/coreapp/' ) ) ;
define( 'PUBLIC_PATH', realpath( dirname( __FILE__ ) . '/public/' ) ) ;

$_SESSION['UID'] = 0 ;
$_SERVER['REMOTE_ADDR'] = '213.41.173.128' ;
$http_port = ':8080';

/*
 * Constante HTTP, permette de cibler une URL du site
 * n'importe ou dans l'application
 */
define( 'ROOT_HTTP', str_replace( "index.php", "", 'http://' . $_SERVER['SERVER_NAME'] . $http_port . $_SERVER["PHP_SELF"] ) ) ;
/*
 * La constante ci-dessous peut être remplacer par ce code en fonction du serveur web
 * if (preg_match('/localhost/si', $_SERVER['SERVER_NAME']))
 * 	define( 'ROOT_HTTP', str_replace( "index.php", "", 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["PHP_SELF"] ) ) ;
 * else
 * 	define( 'ROOT_HTTP', 'http://' . $_SERVER['SERVER_NAME'] . '/' );
 */
define( 'REQUEST_HTTP', 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ) ;
define( 'IMG_HTTP', ROOT_HTTP . 'public/img/' ) ;
define( 'CSS_HTTP', ROOT_HTTP . 'public/css/' ) ;
define( 'JS_HTTP', ROOT_HTTP . 'public/js/' ) ;
define( 'PUBLIC_HTTP', ROOT_HTTP . 'public/' ) ;
/*
 * Inclue les fonctions de l'application
 */
require_once LIBS_PATH . '/coreapp/functions/AutoloadFunction.php' ;
/*
 * Lancement de l'application
 */
$bootstrap = new Bootstrap( ) ;
$bootstrap->run() ;
/*
 * Fermeture du fichier de log et calcul du temps d'execution si DISPLAY_UPTIME = true
 */
DebugAppModel::logUptime() ;
DebugAppModel::logSeparateur() ;
