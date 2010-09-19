<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>MEPSOL</title>
	<link rel="stylesheet" type="text/css" href="./views/edit_service/index.css" media="all" />
	<script src="./libs/jquery/js/jquery-1.4.2.min.js"></script>
	<link type="text/css" href="./libs/jquery/css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="./libs/jquery/js/jquery-ui-1.8.4.custom.min.js"></script>
</head>
<body>
<?php
	if (isset($_GET["with_heading"]) && $_GET["with_heading"])
		echo '<p id="title"><b>M</b>odelling <b>E</b>nvironment for <b>P</b>ublic <b>S</b>ervices on <b>O</b>pen<b>L</b>ayers</p>';
	$id = (int) (isset($_GET["id"]) ? $_GET["id"] : (isset($_SESSION["serviceid"]) ? $_SESSION["serviceid"] : 0));
	
	$name = "";
	$description="";
	if($id>0){
		$r = mysql_fetch_assoc(mysql_query("SELECT name, description FROM services WHERE id=$id"));
		$name = $r["name"];
		$description = $r["description"];
	}
?>
	<form action="./?pg=service&action=save" method="post">
		<input type="hidden" name="id" value="<?php echo $id;?>"/>
		<input type="hidden" name="referer" value="<?php echo $_GET["referer"]; ?>"/>
		Name<br/><input input="text" name="name" value="<?php echo $name; ?>" id="name"/>
		<br/>
		Description<br/><textarea input="text" name="description" id="description"><?php echo $description; ?></textarea>
		<br/>
		<input type="submit" id="save" value="Save"/>
	</form>
</body>
</html>