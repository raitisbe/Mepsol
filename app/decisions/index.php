<?php
class decisions extends module {
	function execute(){
		$action = $_GET["action"];
		switch ($action){
			case "get":
				$id = (int) $_GET["id"];
				$r = mysql_fetch_assoc(mysql_query("SELECT * FROM states WHERE id = $id"));
				$name = $r["name"];
				echo "<table>";
				echo "<tr><td>Name: </td><td><input name='name' class='name' value='$name'/></td></tr>";
				echo "<tr class='description'><td>Description: </td><td><input name='description' value=''/></td></tr>";
				echo "<tr class='info' ><td>Information item: </td><td><input name='info' value=''/></td></tr>";
				echo "<tr class='document'><td>Document: </td><td><input name='document' value=''/></td></tr>";
				echo "<tr class='video_link'><td>Video link: </td><td><input name='video_link' value=''/></td></tr>";
				echo "</table>";
				break;
			case "add":
				$x = (int) $_POST["x"];
				$y = (int) $_POST["y"];
				$w = (int) $_POST["w"];
				$h = (int) $_POST["h"];
				mysql_query("INSERT INTO states(x, y, w, h, type) VALUES ($x, $y, $w, $h, 'd')");
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
				$this->lists();
				break;
		}
	}

	function lists(){
		echo "{";
		print_jason_records(false, "SELECT id, name, x, y, w, h, type FROM states WHERE type='d'", "decisions");
		echo "}";
	}

	function init(){

	}
}
?>

  
