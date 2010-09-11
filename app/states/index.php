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
			case "move":
				$id = (int) $_POST["id"];
				$x = (int) $_POST["x"];
				$y = (int) $_POST["y"];
				$w = (int) $_POST["w"];
				$h = (int) $_POST["h"];
				mysql_query("UPDATE states SET x=$x, y=$y, w=$w, h=$h WHERE id = $id");
				break;
			case "upd":
				$id = (int) $_POST["id"];
				$name = mysql_escape_string($_POST["name"]);
				mysql_query("UPDATE states SET name='$name' WHERE id = $id");
				break;
			case "del":
				$id = (int) $_POST["id"];
				mysql_query("DELETE FROM states WHERE id = $id");
				echo mysql_error();
				break;
			case "list":
				echo "{";
				print_jason_records(false, "SELECT id, name, x, y, w, h FROM states", "states");
				echo "}";
				break;
		}
	}

	function init(){

	}
}
?>

  
