<?php
class service extends module {
	function execute(){
		$action = $_GET["action"];
		switch ($action){
			case "list_contents":
				$this->list_contents();
				break;
		}
	}

	function list_contents(){
		echo "[";
		$states = add_module("states");
		$decisions = add_module("decisions");
		$connections = add_module("connections");
		$states->lists();
		echo ",";
		$decisions->lists();
		echo ",";
		$connections->lists();
		echo "]";
	}

	function init(){

	}
}
?>

  
