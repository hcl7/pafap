<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>pafap debug</title>

<script src="scripts/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="scripts/swfobject.js"></script>
<script type="text/javascript" src="scripts/pafap_flash.js"></script>
</head>

<body onload="ResizeFlash('300','200', 'games/MustacheWarrior.swf'); return false">
<?php ?>
<div id="resized"></div>
</body>
</html>-->

<?php
include ('pafap_classes/init.php');
include ('pafap_classes/sign_up_class.php');
$test = new pafap_SignUp();
$test->addCategories(25);
?>