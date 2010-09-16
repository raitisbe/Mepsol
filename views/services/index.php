<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>MEPSOL</title>
	<link rel="stylesheet" type="text/css" href="./views/services/index.css" media="all" />
	<script src="./libs/jquery/js/jquery-1.4.2.min.js"></script>
	<link type="text/css" href="./libs/jquery/css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="./libs/jquery/js/jquery-ui-1.8.4.custom.min.js"></script>
	<script src="./views/services/index.js"></script>
</head>
<body>
	<p id="title"><b>M</b>odelling <b>E</b>nvironment for <b>P</b>ublic <b>S</b>ervices on <b>O</b>pen<b>L</b>ayers</p> 
	<select id="language" title="Language"><option>en</option><option>gr</option><option>lv</option></select>
	<h1>List of services modelled</h1>
<?php
	$qr = mysql_query("SELECT id, name, description FROM services");
	echo mysql_error();
	while($r = mysql_fetch_array($qr)){
		$name = $r["name"];
		$description = $r["description"];
		$id = $r["id"];
		echo "<div class='service'>$name";
		echo "<br/><div class='description'>$description</div>";
		echo '<br/>';
		echo "<button class='view' href='./?view=dialog&id=$id'>View</button>";
		echo "<button class='edit' href='./?view=main&id=$id'>Edit</button>";
		echo "</div>";
	}
?>
<a href="./?view=edit_service&id=0&referer=<?php echo urlencode(curPageURL()); ?>">New service model</a>
</body>
</html>