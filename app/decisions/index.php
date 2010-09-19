<?php
class decisions extends module {
	public $language = "";
	function execute(){
		$action = $_GET["action"];
		switch ($action){
			case "get":
				$id = (int) $_GET["id"];
				$r = mysql_fetch_assoc(mysql_query("SELECT name, ".build_field_list(array("description", "question", "info", "document", "video_link"), $this->language).", checked FROM states WHERE id = $id"));
				$name = $r["name"];
				$description = $r["description"];
				$question = $r["question"];
				$checked = $r["checked"];
				$info = $r["info"];
				$document = $r["document"];
				$video_link = $r["video_link"];
				echo "<table>";
				echo "<tr class='decision_name'><td>Name: </td><td><input name='name'  class='first_input' value='$name'/><input class='decision_start' type='checkbox' $checked/>Start</td></tr>";
				echo "<tr class='decision_description'><td>Description: </td><td><input name='description' value='$description'/></td></tr>";
				echo "<tr class='decision_type'><td>Decide by: </td><td><select class='decision_type'><option value='Variable'>Variable</option><option value='Input'>User input</option></select></td></tr>";
				echo "<tr class='decision_question'><td>Question: </td><td><input name='decision_question' value='$question'/></td></tr>";
				echo "<tr class='decision_variable'><td>Variable: </td><td><select></select></td></tr>";
				echo "<tr class='decision_input_type'><td>Input type: </td><td><select class='decision_input_type'><option value='DropDown'>DropDown</option><option value='Radio'>Radio</option><option value='Text'>Text</option></select></td></tr>";
				echo "<tr class='decision_store'><td>Store answer in: </td><td><select class='decision_store_in'><option>Dont store</option><option>New variable</option></select></td></tr>";
				echo "<tr class='decision_decisions'><td>Decisions: </td><td><table class='newspaper-table'><tr><th>Condition</th><th>Outcome</th></tr>";
				$qr = mysql_query("SELECT connections.expr, states.name AS name FROM connections LEFT OUTER JOIN states ON states.id=connections.id2 WHERE id1=$id");
				$qrblocks = mysql_query("SELECT states.name AS name FROM states");
				$blocks = array();
				while($block = mysql_fetch_array($qrblocks))
					$blocks[] = $block["name"];
				while($dec = mysql_fetch_array($qr)){
					$condition = $dec["expr"];
					$outcome = $dec["name"];
					echo "<tr class='decision_condition'><td><input type='text' name='condition[]' class='condition' value='$condition'/></td><td><select name='outcome[]' class='outcome'>";
					foreach($blocks as $block)
						echo "<option value='$block'".($outcome == $block?" selected" : "").">$block</output>";
					echo "</td></tr>";
				}
				echo "</table></td></tr>";
				echo "<tr class='state_info' ><td>Information item: </td><td><input name='info' value='$info'/></td></tr>";
				echo "<tr class='state_document'><td>Document: </td><td><input name='document' value='$document'/></td></tr>";
				echo "<tr class='state_video_link'><td>Video link: </td><td><input name='video_link' value='$video_link'/></td></tr>";
				echo "</table>";
				echo "<button class='save_decision'>Save</button>";
				break;
			case "add":
				$x = (int) $_POST["x"];
				$y = (int) $_POST["y"];
				$w = (int) $_POST["w"];
				$h = (int) $_POST["h"];
				$serviceid = $_SESSION["serviceid"];
				mysql_query("INSERT INTO states(x, y, w, h, type, serviceid) VALUES ($x, $y, $w, $h, 'd', $serviceid)");
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
				$checked = mysql_escape_string($_POST["checked"]);
				$name = mysql_escape_string($_POST["name"]);
				$decision_type = mysql_escape_string($_POST["decision_type"]);
				$input_type = mysql_escape_string($_POST["input_type"]);
				mysql_query("UPDATE states SET name = '$name', ".build_upd_field_list(array("description", "question", "info", "document", "video_link"), $this->language).", checked='$checked', decision_type='$decision_type', input_type='$input_type' WHERE id = $id");
				mysql_query("DELETE FROM connections WHERE id1=$id");
				$serviceid = $_SESSION["serviceid"];
				foreach($_POST["conditions"] as $condition){
					$expression = $condition["condition"];
					$outcome_name = $condition["outcome"];
					mysql_query("INSERT INTO connections(expr, id1, id2, serviceid) VALUES ('$expression', $id, (SELECT states.id FROM states WHERE name LIKE '$outcome_name'), $serviceid)");
				}
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
		$serviceid = $_SESSION["serviceid"];
		echo "{";
		print_jason_records(false, "SELECT id, name AS name, x, y, w, h, type FROM states WHERE serviceid=$serviceid AND type='d'", "decisions");
		echo "}";
	}

	function init(){
		$this->language = isset($_SESSION["language"]) ? $_SESSION["language"] : "en";
	}
}
?>

  
