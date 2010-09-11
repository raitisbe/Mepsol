<?php
//error_reporting (E_ALL );
if(file_exists("const.php"))
{
	require_once("const.php");
}
else
{
	echo "No const.php file. Please copy the const.php.template to const.php, edit the content and try again.\n";
	return;
}

date_default_timezone_set('Europe/Prague');
if (ISSET($_GET["pg"]))$pg = $_GET["pg"];
else $pg = null;

if (ISSET($_GET["view"]))$view = $_GET["view"];
else $view = null;

	
if (isset($_POST["PHPSESSID"])) {
	session_id($_POST["PHPSESSID"]);
}
session_start();
require_once ("db.php");
if(isset($nodb) && $nodb && $pg!="dbmigrate") return;
require_once ("functions.php");
require_once ("module.php");
if($pg == null){
	if ($view == null) {
		include "views/main/index.php";
		return;
	} else {
		include "views/$view/index.php";
		return;
	}
}
$module = add_module($pg);
$module->execute();
?>
