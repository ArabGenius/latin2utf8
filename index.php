<?php
ignore_user_abort(true);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
@ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');

$dbfile = 'rafia_articles_cat.sql';		// File of old Arabic 
if (!file_exists($dbfile)) {
    die("The file does not exist or is inaccessible.");
}

$newdbfile = str_replace('.sql','.utf.sql',$dbfile);
// Please don't forget to change encoding of the dbfile from utf8 to ansi (from menu = Encoding)
// Read the content from the file
$content = file_get_contents($dbfile);
// Convert UTF-8 to ANSI encoding using iconv
$contentAnsi = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $content);
// Save the content to the destination file
file_put_contents($newdbfile, $contentAnsi);



include("ConvertCharset.class.php");
$convert  = new ConvertCharset();

function win_to_utf8($str,$t='UTF-8',$f='CP-1256') {
	global $convert;
	$str = $convert->Convert($str, 'windows-1256','utf-8');
	return $str;
}

$newstr =  win_to_utf8(file_get_contents($newdbfile));
$newstr = str_replace(' latin1', ' utf8', $newstr);

file_put_contents($newdbfile, $newstr);
echo $newdbfile.' done';
?>