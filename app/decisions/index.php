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
				echo "<tr class='decision_name'><td>Name: </td><td><input name='name'  class='first_input' value='$name'/></td></tr>";
				echo "<tr class='decision_description'><td>Description: </td><td><input name='description' value=''/></td></tr>";
				echo "<tr class='decision_type'><td>Decide by: </td><td><select class='decision_type'><option value='Variable'>Variable</option><option value='Input'>User input</option></select></td></tr>";
				echo "<tr class='decision_question'><td>Question: </td><td><input name='decision_question' value=''/></td></tr>";
				echo "<tr class='decision_variable'><td>Variable: </td><td><select></select></td></tr>";
				echo "<tr class='decision_input_type'><td>Input type: </td><td><select class='decision_input_type'><option value='DropDown'>DropDown</option><option value='Radio'>Radio</option><option value='Text'>Text</option></select></td></tr>";
				echo "<tr class='decision_store'><td>Store answer in: </td><td><select class='decision_store_in'><option>Dont store</option><option>New variable</option></select></td></tr>";
				echo "<tr class='decision_decisions'><td>Decisions: </td><td><table><tr><th>Condition<th><th>Consequence<th></tr></table></td></tr>";
				echo "</table>";
				echo "<button class='save_decision'>Save</button>";
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

  
