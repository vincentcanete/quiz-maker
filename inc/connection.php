<?php
include dirname(__FILE__) . '/config.php';

$connection = mysql_connect($DB_['HOST'],$DB_['USER'],$DB_['PASS']);
if(!$connection){
	die("Database connection failed! " . mysql_error());
}

$db_select = mysql_select_db($DB_['NAME'],$connection);
if(!$db_select){
	die("Database unable to select! " . mysql_error());
}
?>