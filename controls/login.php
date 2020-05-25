<html>
<head>
<title>pafap - Social Network - Search Engine Login</title>

<link rel="icon" href="images/favicon.ico">
<link rel="icon" href="images/favicon.ico">
<link rel="stylesheet" href="css/pafap_body.css" type="text/css" />
<link rel="stylesheet" href="css/pafap_global.css" type="text/css" />
<link rel="stylesheet" href="css/pafap_messages.css" type="text/css" />

<META NAME="ROBOTS" CONTENT="INDEX, NOFOLLOW">

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
    <?php require ('controls/signup_template.php'); ?>
  </div>
  <div id="pafap_center_panel">
  	<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <div id="login_container">
        <div id="login_panel">
        <h1>Sign In</h1>
        <table>
            <tr><td>Email:</td><td><input type="text" name="txtemail" class="pafap_login" /></td></tr>
            <tr><td>Password:</td><td><input type="password" name="txtpass" class="pafap_login"/></td></tr>
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

if(isset($_POST['login']))
{
  include('pafap_classes/init.php');
  include('pafap_classes/login_pafap_class.php');
  include('pafap_classes/templates_pafap_class.php');
  $tmpl = new pafap_templates;
  $login = new pafap_login();

  if($login->isLoggedIn())
    header('location: home.php?'. $_SESSION['token']);
  else
    $tmpl->show_message($login->showErrors(), 'pafap_error');
}
else
{
  include('pafap_classes/templates_pafap_class.php');
  $tmpl = new pafap_templates;
  $tmpl->show_message($_SESSION['loginerror'], 'pafap_error');
}

$token = $_SESSION['token'];

?>
        <input type="hidden" name="token" value="<?php echo $token; ?>" />
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