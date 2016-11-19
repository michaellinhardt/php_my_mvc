<?php

function EXPORT_TABLES($host,$user,$pass,$name,       $tables=false, $backup_name=false){
    set_time_limit(3000); $mysqli = new mysqli($host,$user,$pass,$name); $mysqli->select_db($name); $mysqli->query("SET NAMES 'utf8'");
    $queryTables = $mysqli->query('SHOW TABLES'); while($row = $queryTables->fetch_row()) { $target_tables[] = $row[0]; }   if($tables !== false) { $target_tables = array_intersect( $target_tables, $tables); }
    $content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `".$name."`\r\n--\r\n\r\n\r\n";
    foreach($target_tables as $table){
        if (empty($table)){ continue; }
        $result = $mysqli->query('SELECT * FROM `'.$table.'`');     $fields_amount=$result->field_count;  $rows_num=$mysqli->affected_rows;     $res = $mysqli->query('SHOW CREATE TABLE '.$table); $TableMLine=$res->fetch_row();
        $content .= "\n\n".$TableMLine[1].";\n\n";
        for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) {
            while($row = $result->fetch_row())  { //when started (and every after 100 command cycle):
                if ($st_counter%100 == 0 || $st_counter == 0 )  {$content .= "\nINSERT INTO ".$table." VALUES";}
                    $content .= "\n(";    for($j=0; $j<$fields_amount; $j++){ $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); if (isset($row[$j])){$content .= '"'.$row[$j].'"' ;}  else{$content .= '""';}     if ($j<($fields_amount-1)){$content.= ',';}   }        $content .=")";
                //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) {$content .= ";";} else {$content .= ",";} $st_counter=$st_counter+1;
            }
        } $content .="\n\n\n";
    }
    $content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
    $backup_name = $backup_name ? $backup_name : $name."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";
    ob_get_clean();
	//header('Content-Type: application/octet-stream');
	//header("Content-Transfer-Encoding: Binary");
	//header("Content-disposition: attachment; filename=\"".$backup_name."\"");
	file_put_contents ( realpath( dirname( __FILE__ ) ) . '/save.sql', $content );
}

EXPORT_TABLES('localhost', 'root', 'root', 'resastock');

header('content-type: text/html; charset=UTF-8');
/*
 * Constante de PATH, permetant de cibler un dossier
 * par son chemin exacte n'importe ou dans le code.
 */
define( 'START_UPTIME', microtime( true ) ); // Permet de loguer le temps d'acces à une page
define( 'ROOT_PATH', realpath( dirname( __FILE__ ) ) );
define( 'PRIVATE_PATH', realpath( dirname( __FILE__ ) . '/private/' ) );
define( 'CONFIG_PATH', realpath( dirname( __FILE__ ) . '/private/configs/' ) );
define( 'VIEWS_PATH', realpath( dirname( __FILE__ ) . '/private/views/' ) );
define( 'LIBS_PATH', realpath( dirname( __FILE__ ) . '/private/libs/' ) );
define( 'LOGS_PATH', realpath( dirname( __FILE__ ) . '/private/libs/coreapp/logs/' ) );
define( 'COREAPP_PATH', realpath( dirname( __FILE__ ) . '/private/libs/coreapp/' ) );
define( 'PUBLIC_PATH', realpath( dirname( __FILE__ ) . '/public/' ) );

/*
 * Constante HTTP, permette de cibler une URL du site
 * n'importe ou dans l'application
 * ATTENTION ! Dans RoutageAppModel, on rebuild cette variable pour la recuperer sans le port,
 * 		Si pour une raison ou une autre on dois la rebuild, il faudra le faire aussi labas..
 */
define( 'ROOT_HTTP', str_replace( "index.php", "", 'http://' . $_SERVER['SERVER_NAME'] . ':8080' . $_SERVER["PHP_SELF"] ) );
/*
 * La constante ci-dessous peut être remplacer par ce code en fonction du serveur web
 * if (preg_match('/localhost/si', $_SERVER['SERVER_NAME']))
 * 	define( 'ROOT_HTTP', str_replace( "index.php", "", 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["PHP_SELF"] ) );
 * else
 * 	define( 'ROOT_HTTP', 'http://' . $_SERVER['SERVER_NAME'] . '/' );
 */
define( 'REQUEST_HTTP', 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] );
define( 'IMG_HTTP', ROOT_HTTP . 'public/img/' );
define( 'CSS_HTTP', ROOT_HTTP . 'public/css/' );
define( 'JS_HTTP', ROOT_HTTP . 'public/js/' );
define( 'PUBLIC_HTTP', ROOT_HTTP . 'public/' );
/*
 * Inclue les fonctions de l'application
 */
require_once LIBS_PATH . '/coreapp/functions/AutoloadFunction.php' ;
/*
 * Lancement de l'application
 */
$bootstrap = new Bootstrap( );
$bootstrap->run();
/*
 * Fermeture du fichier de log et calcul du temps d'execution si DISPLAY_UPTIME = true
 */
DebugAppModel::logUptime();
DebugAppModel::logSeparateur();
