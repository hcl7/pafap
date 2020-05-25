<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Search Engine Spider Test Tool</title>
<meta name="Description" content="Tool grabs the source code of a page and trys to show it similarly to how a search spider may see it.">
<meta name="Keywords" content="search enigne spider tool">
</head>

<?php

/*
============================================================================================================

        Version              : 1.0

        Description          : Search Engine Spider Test Tool

        Copyright            : (c) SeoBook.com, licensed under the GPL ( http://www.gnu.org/licenses/gpl.txt )

        Function             : Allows you to quickly view how a spider sees a web page.

============================================================================================================
*/

include "header.php";

error_reporting(0);
$url=$_REQUEST['url'];
$c=$_REQUEST['c'];
include "form.php";

switch ($c)
{
case 1:
{
	if(strlen($url)<5) 
	{
		echo "<center><font class=Arial color=red><br>Please enter url<br></font></center>";
		break;
	}
	//getting meta tags
	$url=str_replace('http://','',$url);
	$url=$url;
	include "Spider.php";$meta=New spider;
	include "ExtractUrls.php";
	$res=$meta->getValues($url);
	
	//extracting links
	$ext=NEW extractor($url);
	$links=$ext->ExtractLinks('');
	
	$res['links']=$ext->links;
	include "results.php";
}
}

include "footer.php";
?>

