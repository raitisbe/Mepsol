<?php
class connections extends module {
	function execute(){
		$action = $_GET["action"];
		switch ($action){
			case "add":
				$id1 = (int) $_POST["id1"];
				$id2 = (int) $_POST["id2"];
				$serviceid = $_SESSION["serviceid"];
				if ($id1==$id2){
					echo 0;
					return;
				}
				mysql_query("INSERT INTO connections(id1, id2, serviceid) VALUES ($id1, $id2, $serviceid)");
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
		$serviceid = $_SESSION["serviceid"];
		echo "{";
		print_jason_records(false, "SELECT id, id1, id2 FROM connections WHERE serviceid=$serviceid", "connections");
		echo "}";
	}

	function init(){

	}
}
?>

  
