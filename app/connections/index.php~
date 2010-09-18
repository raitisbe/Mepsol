<?php
class connections extends module {
	function execute(){
		$action = $_GET["action"];
		switch ($action){
			case "add":
				$id1 = (int) $_POST["id1"];
				$id2 = (int) $_POST["id2"];
				mysql_query("INSERT INTO connections(id1, id2) VALUES ($id1, $id2)");
				echo mysql_insert_id();
				break;
			case "del":
				$id = (int) $_POST["id"];
				mysql_query("DELETE FROM connections WHERE id = $id");
				echo mysql_error();
				break;
			case "del_for_block":
				$id = (int) $_POST["id"];
				mysql_query("DELETE FROM connections WHERE id1 = $id OR id2 = $id");
				echo mysql_error();
				break;
			case "list":
				$this->lists();
				break;
		}
	}

	function lists(){
		echo "{";
		print_jason_records(false, "SELECT id, id1, id2 FROM connections", "connections");
		echo "}";
	}

	function init(){

	}
}
?>

  
