<?php
require_once("const.php");
$ret = mysql_connect (dbserver, dbuser, dbpass);
$ret = mysql_select_db (db);
if(mysql_error()){
	echo "Could not connect to main database. Reason: ".mysql_error()."\n. Try Running ?pg=dbmigrate";
	$nodb = true;
}
$ret = mysql_query("SET NAMES 'utf8';");
?>
