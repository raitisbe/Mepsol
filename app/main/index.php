<?php
class main extends module {
	function execute(){
		$action = $_GET["action"];
		switch ($action){
			case "set_language":
				$_SESSION["language"] = mysql_escape_string($_GET["language"]);
				break;
		}
	}

	function init(){

	}
}
?>

  
