<!DOCTYPE html>
<html>
<head>
<META NAME="Description" CONTENT="Social Network based on discussions by categories that are activated in the menu Profile in which can also upload images.
Similarities based on the types of categories depends on the completion of the Profile menu.
You can talk about what you want and with the right persons for this.">
<META http-equiv="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<title>Welcome to pafap - Log In, Sign Up or Help</title>
<META NAME="ROBOTS" CONTENT="INDEX, NOFOLLOW">
<link rel="icon" href="images/favicon.ico">
<link rel="stylesheet" href="css/pafap_global.css" type="text/css" />
<link rel="stylesheet" href="css/pafap-buttons.css" type="text/css" />
<!--[if IE]>
	<link rel="stylesheet" href="css/pafap_global_IE.css" type="text/css" />
<![endif]-->
<script type="text/javascript" src="scripts/jquery-1.6.4.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  var emailval = 'E-mail';
  var passval = 'Password';
  $('#txtemail').blur(function(){
    if ($(this).val().length == 0)
      $(this).val(emailval).addClass('watermark');
  }).focus(function(){
    if ($(this).val() == emailval)
      $(this).val('').removeClass('watermark');
  }).val(emailval).addClass('watermark');

  $('#txtpass').blur(function(){
    if ($(this).val().length == 0)
      $(this).val(passval).addClass('watermark');
  }).focus(function(){
    if ($(this).val() == passval)
      $(this).val('').removeClass('watermark');
  }).val(passval).addClass('watermark')

});
</script>
</head>
<body vlink="#0000FF" alink="#0000FF">
<div id="pafap_header">
    <div id="pafap_header_container">
        <div id="pafap_left_header"><div id="pafap_header_logo"></div></div>
        <div id="pafap_center_header"></div>
        <div id="pafap_right_header">
<?php
//error_reporting(0);
if(!isset($_SESSION))
{
  @session_start();
}
if(isset($_SESSION['uid'])) header('location: home.php?cid='. $_SESSION['cid']);

if(isset($_POST['login']))
{
  include('pafap_classes/init.php');
  include('pafap_classes/login_pafap_class.php');
  $login = new pafap_login();
  if($login->isLoggedIn())
    header('location: home.php?cid='. $_SESSION['cid']);
  else
    header('location: index.php');
}

$token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));

?>
            <form style="float: right; margin-top: 8px;" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="text" name="txtemail" id="txtemail" class="pafap_login" />
                <input type="password" name="txtpass" id="txtpass" class="pafap_login" />
	            <input type="submit" name="login" id="login" class="pafap_button" value="Log In" />
                <input type="hidden" name="token" value="<?php echo $token; ?>" />
            </form>
        </div>
    </div>
</div>


<?php
error_reporting(0);
require('controls/signup.php');
//require('controls/footer.php');
?>
<div itemscope itemtype="http://schema.org/Organizaition" id="pafap_footer_container">
    <table cellpadding="0" cellspacing="0" border="0" style="float:right">
	 <tr>
        <td><a href="https://plus.google.com/u/0/114494927946522034836?rel=author" style="text-decoration:none;font-size:10px;">Author&nbsp;</a></td>
        <td><a rel="publisher" href="https://plus.google.com/s/pafap" style="text-decoration:none;font-size:10px;">Find us on Google+</a></td>
        <td><a href="https://www.youtube.com/watch?v=AHrccf_sji4" title="pafap help everything you need how to use pafap." style="color: #E21403;text-decoration:none;font-size:10px;">&nbsp;Help</a></td>
	    <td><div id="pafap_footer_logo"></div></td>
	    <td id="pafap_footer_copyright"><span itemprop="name">pafap &#169 </span><span itemprop="email">emuco7@gmail.com</span></td>
	 </tr>
    </table>
</div>
</body>
</html>

