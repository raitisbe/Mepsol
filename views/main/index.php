<?php
	if(isset($_GET["id"])) $_SESSION["serviceid"] = $_GET["id"];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>MEPSOL</title>
	<link rel="stylesheet" type="text/css" href="./views/main/index.css" media="all" />
	<script src="./gz.php?uri=.%2Flibs%2FOpenLayers-2.9%2FOpenLayers.js"></script>
	<script src="./libs/jquery/js/jquery-1.4.2.min.js"></script>
	<link type="text/css" href="./libs/jquery/css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="js/jquery-ui-1.8.4.custom.min.js"></script>
	<script src="./views/main/index.js"></script>
	<script src="./views/main/drawtext.js"></script>
	<script src="./libs/thickbox/thickbox.js"></script>
	<link type="text/css" href="./libs/thickbox/thickbox.css" rel="stylesheet" />	
	<script src="./libs/OpenLayers.DistBwPointAndLine.js"></script>
</head>
<body>
	<p id="title"><b>M</b>odelling <b>E</b>nvironment for <b>P</b>ublic <b>S</b>ervices on <b>O</b>pen<b>L</b>ayers</p> 
	<select id="language" title="Language"><option>en</option><option>gr</option><option>lv</option></select>
	<ul id="icons" class="ui-widget ui-helper-clearfix">
		<li title="Select" id="tool_select" class="ui-state-default ui-corner-all">
			<span class="ui-icon ui-icon-carat-1-nw"></span>
		</li>
		<li title="Bomb" id="tool_delete" class="ui-state-default ui-corner-all">
			<span class="ui-icon ui-icon-trash"></span>
		</li>
		<li class="ui-state-default ui-corner-all"></li>
		<li title="Add new State" id="tool_state" class="ui-state-default ui-corner-all">
			<span class="ui-icon ui-icon-document-b"></span>
		</li>
		<li title="Add new Decision" id="tool_decision" class="ui-state-default ui-corner-all">
			<span class="ui-icon ui-icon-help"></span>
		</li>
		<li class="ui-state-default ui-corner-all"></li>
		<li title="Link" id="tool_link" class="ui-state-default ui-corner-all">
			<span class="ui-icon ui-icon-link"></span>
		</li>
		<li title="Cut link" id="tool_unlink" class="ui-state-default ui-corner-all">
			<span class="ui-icon ui-icon-scissors"></span>
		</li>
		<li class="ui-state-default ui-corner-all"></li>
		<li title="Execute Dialog" id="tool_play" class="ui-state-default ui-corner-all" >
			<a href="./?view=dialog" target="_blank" class="ui-icon ui-icon-play"></a>
		</li>
		<li title="Edit service description" id="tool_edit" class="ui-state-default ui-corner-all" href="./?view=edit_service">
			<span class="ui-icon ui-icon-info"></span>
		</li>
	</ul>
	<div id="map"></div>
</body>
</html>