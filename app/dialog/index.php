<?php
class dialog extends module {
	public $language = "";
	function execute(){
		$action = $_GET["action"];
		switch ($action){
			case "start":
				$qr = mysql_query("SELECT id FROM states WHERE checked = 'checked'");
				$_SESSION["states_open"] = array();
				$_SESSION["history_stack"] = array();
				$r = mysql_fetch_assoc($qr);
				$id = $r["id"];
				$this->openState($id);
				$this->advance();
				$this->getCurrentState();
				break;
			case "advance":
				$this->advance();
				$this->getCurrentState();
				break;
			case "step_back":
				$this->stepBack();
				break;
			case "get_current":
				$this->getCurrentState();
				break;
		}
	}

	function stepBack(){
		if(sizeof($_SESSION["history_stack"])>1){
			error_log(sizeof($_SESSION["history_stack"]));
			$last = $_SESSION["history_stack"][sizeof($_SESSION["history_stack"])-1];
			for($i=0; $i<sizeof($_SESSION["states_open"]); $i++){
				if($_SESSION["states_open"][$i]["id"]==$last){
					$_SESSION["states_open"][$i]["visited"] = false;
				}
			}
			unset($_SESSION["history_stack"][sizeof($_SESSION["history_stack"])-1]);
			$last = $_SESSION["history_stack"][sizeof($_SESSION["history_stack"])-1];
			error_log(print_r($_SESSION["history_stack"],true));
			$this->setCurrentState($last, false);
		}
		$this->getCurrentState();
	}

	function advance(){
		$was_open = false;
		for($i=0; $i<sizeof($_SESSION["states_open"]); $i++){
			if($_SESSION["states_open"][$i]["id"]==$_SESSION["current_state"]){
				$_SESSION["states_open"][$i]["visited"] = true;
			}
			if(!$_SESSION["states_open"][$i]["visited"]){
				$this->setCurrentState($_SESSION["states_open"][$i]["id"]);
				$was_open = true;
				break;
			}
		}
		if(!$was_open){
			$opened = false;
			for($i=0; $i<sizeof($_SESSION["states_open"]); $i++){
				if(!$_SESSION["states_open"][$i]["advanced"]){
					$_SESSION["states_open"][$i]["advanced"] = true;
					$qr = mysql_query("SELECT connections.expr, id2 FROM connections INNER JOIN states ON states.id=connections.id2 WHERE id1 = ".$_SESSION["states_open"][$i]["id"]);
					while($r = mysql_fetch_array($qr)){
						$this->openState($r["id2"]);
						$opened = true;
					}
				}
			}
			if($opened) $this->advance();
		}
	}

	function getCurrentState(){
		echo "{";
		$id = $_SESSION["current_state"];
		print_jason_records(false, "SELECT id, name, description_$this->language AS description, type, decision_type, input_type, question_$this->language AS question FROM states WHERE id = $id", "state");
		print_jason_records(true, "SELECT connections.expr FROM connections INNER JOIN states ON states.id=connections.id2 WHERE id1 = $id", "answers");
		$r = mysql_fetch_assoc(mysql_query("SELECT ".build_field_list(array("description", "info", "document", "video_link"), $this->language)." FROM states WHERE id = $id"));
		echo ", \"video_links\":".json_encode(explode(";", $r["video_link"]));
		echo ", \"documents\":".json_encode(explode(";", $r["document"]));
		echo ", \"info\":".json_encode(explode(";", $r["info"]));
		echo "}";
	}

	function setCurrentState($id, $store_in_history = true){
		$_SESSION["current_state"] = $id;
		if(!isset($_SESSION["history_stack"])) $_SESSION["history_stack"] = array();
		if($store_in_history) $_SESSION["history_stack"][] = $id;
	}

	function openState($id){
		$qr = mysql_query("SELECT id, name, type FROM states WHERE id = $id");
		$r = mysql_fetch_assoc($qr);
		$_SESSION["states_open"][] = array("id"=>$id, "name"=>$r["name"], "type"=>$r["type"], "visited"=>false, "advanced"=>false);
	}

	function init(){
		$this->language = isset($_SESSION["language"]) ? $_SESSION["language"] : "en";
	}
}
?>

  
