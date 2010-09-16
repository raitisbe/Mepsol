<?php

function quote_smart($value){
	global $database;
	if (get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	}
	if (!is_numeric($value)) {
		$value = "'" . mysql_real_escape_string($value) . "'";
	}
	return $value;
}

function add_module($moduleName){
	require_once("./app/$moduleName/index.php");
	$module = new $moduleName;
	$module->init();
	return $module;
}

function add_css($filename){
	global $globals;
	array_push($globals->cssFiles, $filename, "");
}

function print_css_list(){
	global $globals;
	foreach ($globals->cssFiles as $element) {
		if ($element!=""){
			?>
<link
	rel="stylesheet" href="<?php echo $element ?>" type="text/css" />
			<?php
		}
	}
}

function get_sql_array_0col($sql){
	$uids=array();
	$res = mysql_query($sql);
	while ($row = mysql_fetch_row($res)) {
		array_push ($uids, $row[0]);
	}
	return $uids;
}

function write_page_numbers($select, $module, $page, $page_size=5){
	$row=mysql_fetch_assoc(mysql_query($select));
	$count=$row["skaits"];
	?>
Lapas:
	<?php
	for ($i=1; $i<=ceil($count/$page_size);$i++){
		if ($page==$i) echo "<b>";
		?>
<a href="./index.php?id=<?php echo $module; ?>&page=<?php echo $i; ?>"><?php echo $i; ?>&amp;nbsp</a>
		<?php
		if ($page==$i) echo "</b>";
	}
}

function check_permissions($conferenceid, $userid, $permission){
	$row = mysql_fetch_assoc(mysql_query("SELECT $permission FROM participants WHERE conferenceid=$conferenceid AND userid=$userid LIMIT 1"));
	return ((int) $row[$permission]==1);
}

function build_combo($sql, $name, $with_empty, $id_field, $text_field, $selected, $additional=""){
	?>
<select name="<?php echo $name; ?>" <?php echo $additional; ?>>
<?php if ($with_empty){?>
	<option value="0"
	<?php if ($selected=="") echo "selected=\"selected\""; ?>></option>
	<?php }
	$qr=mysql_query($sql);
	if (!mysql_error() && mysql_numrows($qr)>0)
	while($r = mysql_fetch_array($qr)){
		?>
	<option value="<?php echo $r[$id_field]; ?>"
	<?php if($r[$id_field]==$selected) echo "selected=\"selected\""; ?>><?php echo $r[$text_field]; ?></option>
	<?php
	} ?>
</select>
	<?php
}

function compare_chk_list($extselect, $checked_var, $insert, $delete){
	$ext=get_sql_array_0col($extselect);
	$checkedcat=array();
	while (list ($key,$val) = @each ($checked_var)) {
		if(!in_array($val,$ext)){
			$sql=str_replace("{val}", $val, $insert);
			$qr=mysql_query($sql);
		} else {
			array_push ($checkedcat, $val);
		}
	}
	while (list ($key,$val) = @each ($ext)) {
		if(!in_array($val,$checked_var)){
			$sql=str_replace("{val}", $val, $delete);
			$qr=mysql_query($sql);
			echo mysql_error();
		}
	}
}

function print_records($sql, $name)
{
	$resu = mysql_query($sql);
	if(mysql_error()!="") echo mysql_error();
	if(mysql_num_rows($resu) != 0)
	while($r = mysql_fetch_array($resu))
	print_record($r, $name);
}

function print_jason_records($add_comma, $sql, $name)
{
	$resu = mysql_query($sql);
	if(mysql_error()!="") {return;}
	if(mysql_num_rows($resu) != 0){
		if($add_comma) echo ", ";
		echo '"'.$name.'":[';
		$first = true;
		while($r = mysql_fetch_array($resu)){
			if(!$first) echo ", ";
			print_json_record($resu, $r, $name);
			$first = false;
		}
		echo "]";
		return true;
	} else {
		if($add_comma) echo ", ";
		echo '"'.$name.'":[]';
		return true;
	}
	return false;
}

function print_json_record($qr, $r)
{
	$first = true;
	echo '{';
	$fieldc=mysql_num_fields($qr);
	for($i=0;$i<$fieldc;$i++)
	{
		if(mysql_field_name($qr, $i)=="subquery")
		{
			$subq = explode(";", $r[$i]);
			if($subq[1]!="")
				print_jason_records(true, $subq[1], $subq[0]);
		}else{
			if(!$first) echo ", ";
			$type = mysql_field_type($qr, $i);
			$var_cont=($type=="string" || $type=="blob" || $type=="timestamp"?'"':'');
			$val = $r[$i];
			//$val = str_replace("\"","\\\"",$val);
			if($val=="" && ($type=="int" || $type=="real")) $val = 0;
			if($var_cont == '"')
				echo '"'.mysql_field_name($qr, $i).'":'.json_encode($val, JSON_FORCE_OBJECT);
			else
				echo '"'.mysql_field_name($qr, $i).'":'.$val;
			$first = false;
		}
	}
	echo '}';
}

function print_record($r, $name)
{
	echo "<$name>";
	foreach ($r as $key => $value)
	{
		if((string)((int)$key) != $key)
		echo "<$key>".htmlentities($value, ENT_COMPAT, 'UTF-8')."</$key>";
	}
	echo "</$name>";
}


function write_records($fp, $sql, $name)
{
	$resu = mysql_query($sql);
	if(mysql_error()!="") echo mysql_error();
	if(mysql_num_rows($resu) != 0)
	while($r = mysql_fetch_array($resu))
	write_record($fp, $r, $name);
}


function write_record($fp, $r, $name)
{
	fwrite($fp, "<$name>");
	foreach ($r as $key => $value)
	{
		if((string)((int)$key) != $key)
		fwrite($fp, "<$key>".htmlentities($value, ENT_COMPAT,'UTF-8')."</$key>");
	}
	fwrite($fp, "</$name>");
}

function write_node($fp, $row, $name)
{
	fwrite($fp, "<$name>".htmlentities($row[$name], ENT_COMPAT,'UTF-8')."</$name>");
}

function dirList ($directory)
{

	// create an array to hold directory list
	$results = array();

	// create a handler for the directory
	$handler = opendir($directory);

	// keep going until all files in directory have been read
	while ($file = readdir($handler)) {

		// if $file isn't this directory or its parent,
		// add it to the results array
		if ($file != '.' && $file != '..')
		$results[] = $file;
	}

	// tidy up: close the handler
	closedir($handler);

	// done!
	return $results;

}

function log_text($what){
	$myFile = "log.log";
	$fh = fopen($myFile, 'a') or die("can't open file");
	fwrite($fh, $what);
	fclose($fh);
}

function recurse_copy($src,$dst) {
	$dir = opendir($src);
	@mkdir($dst);
	while(false !== ( $file = readdir($dir)) ) {
		if (( $file != '.' ) && ( $file != '..' )) {
			if ( is_dir($src . '/' . $file) ) {
				recurse_copy($src . '/' . $file,$dst . '/' . $file);
			}
			else {
				copy($src . '/' . $file,$dst . '/' . $file);
			}
		}
	}
	closedir($dir);
}

function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

function Sec2Time($time){
	if(is_numeric($time)){
		$value = array(
      "years" => 0, "days" => 0, "hours" => 0,
      "minutes" => 0, "seconds" => 0,
		);
		if($time >= 31556926){
			$value["years"] = floor($time/31556926);
			$time = ($time%31556926);
		}
		if($time >= 86400){
			$value["days"] = floor($time/86400);
			$time = ($time%86400);
		}
		if($time >= 3600){
			$value["hours"] = floor($time/3600);
			$time = ($time%3600);
		}
		if($time >= 60){
			$value["minutes"] = floor($time/60);
			$time = ($time%60);
		}
		$value["seconds"] = floor($time);
		return (array) $value;
	}else{
		return (bool) FALSE;
	}
}

function uuid() {
	// Get timestamp and convert it to UTC (based Oct 15, 1582).
	list($usec, $sec) = explode(' ', microtime());
	$t= ($sec * 10000000) + ($usec * 10) + 122192928000000000;
	$clock_seq= mt_rand();

	$time_low= ($t & 0xFFFFFFFF);
	$time_mid= (($t >> 32) & 0xFFFF);
	$time_hi_and_version= (($t >> 48) & 0x0FFF);
	$time_hi_and_version |= (1 << 12);
	$clock_seq_low= $clock_seq & 0xFF;
	$clock_seq_hi_and_reserved= ($clock_seq & 0x3F00) >> 8;
	$clock_seq_hi_and_reserved |= 0x80;

	$h= md5(php_uname());
	$node= array(
	hexdec(substr($h, 0x0, 2)),
	hexdec(substr($h, 0x2, 2)),
	hexdec(substr($h, 0x4, 2)),
	hexdec(substr($h, 0x6, 2)),
	hexdec(substr($h, 0x8, 2)),
	hexdec(substr($h, 0xB, 2))
	);

	return sprintf(
    '%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x',
	$time_low,
	$time_mid,
	$time_hi_and_version,
	$clock_seq_hi_and_reserved,
	$clock_seq_low,
	$node[0],
	$node[1],
	$node[2],
	$node[3],
	$node[4],
	$node[5]
	);
}

function print_gzipped_page() {
    global $HTTP_ACCEPT_ENCODING;
    $HTTP_ACCEPT_ENCODING = $_SERVER["HTTP_ACCEPT_ENCODING"];
    if( headers_sent() ){
        $encoding = false;
    }elseif( strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false ){
        $encoding = 'x-gzip';
    }elseif( strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false ){
        $encoding = 'gzip';
    }else{
        $encoding = false;
    }

    if( $encoding ){
        $contents = ob_get_contents();
        ob_end_clean();
        header('Content-Encoding: '.$encoding);
        print("\x1f\x8b\x08\x00\x00\x00\x00\x00");
        $size = strlen($contents);
        $contents = gzcompress($contents, 9);
        $contents = substr($contents, 0, $size);
        print($contents);
        exit();
    }else{
        ob_end_flush();
        exit();
    }
}

function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
 }

function build_field_list($fields, $language){
	for($i=0; $i<sizeof($fields); $i++){
		$fields[$i] .= "_".$language." AS ".$fields[$i];
	}
	return join(",", $fields);
}

function build_upd_field_list($fields, $language){
	for($i=0; $i<sizeof($fields); $i++){
		$fields[$i] .= "_".$language." = '".mysql_escape_string($_POST[$fields[$i]])."'";
	}
	return join(",", $fields);
}

?>
