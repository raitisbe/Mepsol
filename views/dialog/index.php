<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>MEPSOL</title>
	<link rel="stylesheet" type="text/css" href="./views/dialog/index.css" media="all" />
	<script src="./libs/OpenLayers-2.9/OpenLayers.js"></script>
	<script src="./libs/jquery/js/jquery-1.4.2.min.js"></script>
	<link type="text/css" href="./libs/jquery/css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="./libs/jquery/js/jquery-ui-1.8.4.custom.min.js"></script>
	<script src="./views/dialog/index.js"></script>
	<script src="./views/main/drawtext.js"></script>
</head>
<body>
	<p id="title"><b>M</b>odelling <b>E</b>nvironment for <b>P</b>ublic <b>S</b>ervices on <b>O</b>pen<b>L</b>ayers</p> 
	<select id="language" title="Language"><option>en</option><option>gr</option><option>lv</option></select>
	<div id="map"></div>
	<div id="dialog_column">
		<div id="question_container"></div>
		<br/><hr/>
		<button id="previous">Previous</button><button id="next">Next</button>
		<br/><hr/>
		<div id="accordion">
			<div>
				<h3><a href="#">Videos&nbsp;<span id="video_cnt"></span></a></h3>
				<div id='video_container'></div>
			</div>
			<div>
				<h3><a href="#">Documents&nbsp;<span id="document_cnt"></span></a></h3>
				<div id='document_container'></div>
			</div>
			<div>

				<h3><a href="#">Collectable information&nbsp;<span id="info_cnt"></span></a></h3>
				<div id='information_container'></div>
			</div>
		</div>
	</div>
</body>
</html>