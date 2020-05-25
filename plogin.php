<html>
<head>
<META NAME="Description" CONTENT="pafap panel administrator login, for site administration.">
<META http-equiv="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<title>pafap panel administrator Login</title>
<META NAME="ROBOTS" CONTENT="INDEX, NOFOLLOW">

<link rel="icon" href="images/favicon.ico">
<link rel="icon" href="images/favicon.ico">
<link rel="stylesheet" href="css/pafap_global.css" type="text/css" />
<link rel="stylesheet" href="css/pafap_messages.css" type="text/css" />

</head>
<body vlink="#0000FF" alink="#0000FF">

<div id="pafap_header">
  <div id="pafap_header_container">
   <div id="pafap_left_header">
      <div id="pafap_header_logo"></div>
   </div>
   <div id="pafap_center_header">
   </div>
   <div id="pafap_right_header">
   </div>
  </div>
</div>

<div id="pafap_panel">
<div id="pafap_panel_container">
  <div id="pafap_left_panel">
    <br/><br/>
    <p><img src="../images/LOGO_2.png" alt="pafap big logo" width="200" height="200" /></p>
  </div>
  <div id="pafap_center_panel">
  	<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <div id="login_container">
        <div id="login_panel">
        <h1>Panel Login Administrator</h1>
        <table>
            <tr><td>Email:</td><td><input type="text" name="txtpemail" class="pafap_login" /></td></tr>
            <tr><td>Password:</td><td><input type="password" name="txtppass" class="pafap_login"/></td></tr>
        </table>
        <input type="submit" name="login" class="pafap_button" value="Log In" /><br/>
        </div>
      </div>
<?php
error_reporting(0);
if (!isset($_SESSION))
{
  @session_start();
}
include('pafap_classes/init.php');
include('pafap_classes/panel_pafap_class.php');
include('pafap_classes/templates_pafap_class.php');
$tmpl = new pafap_templates;
$login = new pafap_panel();

if(isset($_SESSION['puid'])) header('location: panel.php');
if(isset($_POST['login']))
{
  if($login->isLoggedIn())
    header('location: panel.php');
  else
    $tmpl->show_message($login->showErrors(), 'pafap_error');
}
else
{
  if ($login->showErrors() != null) $tmpl->show_message($login->showErrors(), 'pafap_error');
}

?>
	</form><!-- end form -->
  </div>
  <div id="pafap_right_panel">
     <!-- right panel -->
  </div>
</div>
</div>
<?php require('controls/footer.php'); ?>
</body>
</html>