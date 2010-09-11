<?php
class states extends module {
	function execute(){
		$action = $_GET["action"];
		switch ($action){
			case "get":
				$id = (int) $_GET["id"];
				echo "Name: <input name='name' class='name' value=''/>";
				break;
			case "add":
				$x = (int) $_POST["x"];
				$y = (int) $_POST["y"];
				$w = (int) $_POST["w"];
				$h = (int) $_POST["h"];
				mysql_query("INSERT INTO states(x, y, w, h) VALUES ($x, $y, $w, $h)");
				echo mysql_insert_id();
				break;
		}
	}

	function init(){

	}
}
?>

  
