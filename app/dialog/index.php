<?php
class dialog extends module {
	public $language = "";
	function execute(){
		$action = $_GET["action"];
		switch ($action){
			case "start":
				$serviceid = $_SESSION["serviceid"];
				$qr = mysql_query("SELECT id FROM states WHERE checked = 'checked' AND serviceid=$serviceid LIMIT 1");
				$_SESSION["states_open"] = array();
				$_SESSION["history_stack"] = array();
				$_SESSION["open_stack"] = array();
				$r = mysql_fetch_assoc($qr);
				$id = $r["id"];
				$this->openState($id);
				$this->setCurrentState($id);
				$this->getCurrentState();
				break;
			case "advance":
				$this->answer();
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

	function answer(){
		for($i=0; $i<sizeof($_SESSION["states_open"]); $i++){
			if($_SESSION["states_open"][$i]["id"] == $_SESSION["current_state"]){
				$_SESSION["states_open"][$i]["answer"] = $_GET["answer"];
				$_SESSION["states_open"][$i]["advanced"] = false;
				break;
			}
		}
	}

	function stepBack(){
		if(sizeof($_SESSION["history_stack"])>1){
			unset($_SESSION["history_stack"][sizeof($_SESSION["history_stack"])-1]);
			$last = $_SESSION["history_stack"][sizeof($_SESSION["history_stack"])-1];
			unset($_SESSION["open_stack"][sizeof($_SESSION["open_stack"])-1]);	
			$_SESSION["states_open"] = $_SESSION["open_stack"][sizeof($_SESSION["open_stack"])-1];
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
				if($_SESSION["states_open"][$i]["visited"] && !$_SESSION["states_open"][$i]["advanced"]){
					$_SESSION["states_open"][$i]["advanced"] = true;
					$qr = mysql_query("SELECT connections.expr, id2 FROM connections INNER JOIN states ON states.id=connections.id2 WHERE id1 = ".$_SESSION["states_open"][$i]["id"]);
					while($r = mysql_fetch_array($qr)){
						if($_SESSION["states_open"][$i]["type"]=="d"){
							if($_SESSION["states_open"][$i]["decision_type"]=="Input"){
								if($_SESSION["states_open"][$i]["answer"] != $r["expr"]) continue;
								
							}
						}
						if($this->openState($r["id2"]))
							$opened = true;
					}
				}
			}
			if($opened) {
				$this->advance();
			}
		}
	}

	function getCurrentState(){
		echo "{";
		$id = $_SESSION["current_state"];
		if(!$id){
			echo '"state":[]}';
			return;
		}
		print_jason_records(false, "SELECT id, name, description_$this->language AS description, type, decision_type, input_type, question_$this->language AS question FROM states WHERE id = $id", "state");
		print_jason_records(true, "SELECT connections.expr FROM connections INNER JOIN states ON states.id=connections.id2 WHERE id1 = $id", "answers");
		$r = mysql_fetch_assoc(mysql_query("SELECT ".build_field_list(array("description", "info", "document", "video_link"), $this->language)." FROM states WHERE id = $id"));
		echo ", \"video_links\":".json_encode(explode("|", $r["video_link"]));
		echo ", \"documents\":".json_encode(explode("|", $r["document"]));
		echo ", \"info\":".json_encode(explode("|", $r["info"]));
		echo "}";
	}

	function setCurrentState($id, $store_in_history = true){
		$_SESSION["current_state"] = $id;
		if(!isset($_SESSION["history_stack"])) $_SESSION["history_stack"] = array();
		if(!isset($_SESSION["open_stack"])) $_SESSION["open_stack"] = array();
		if($store_in_history) $_SESSION["history_stack"][] = $id;
		if($store_in_history) $_SESSION["open_stack"][] = $_SESSION["states_open"];
	}

	function openState($id){
		$qr = mysql_query("SELECT id, name, type, decision_type, decision_variable FROM states WHERE id = $id");
		$r = mysql_fetch_assoc($qr);
		$found = false;
		for($i=0; $i<sizeof($_SESSION["states_open"]); $i++){
			if($_SESSION["states_open"][$i]["id"] == $id){
				$found = true;
				break;
			}
		}
		if(!$found){
			$_SESSION["states_open"][] = array("id"=>$id, "name"=>$r["name"], "type"=>$r["type"], "decision_type"=>$r["decision_type"], "decision_variable"=>$r["decision_variable"], "visited"=>false, "advanced"=>false, "answer" =>null);
			return true;
		} else {
			return false;
		}
	}

	function init(){
		$this->language = isset($_SESSION["language"]) ? $_SESSION["language"] : "en";
	}
}
?>

  
