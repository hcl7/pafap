<link rel="stylesheet" href="../css/pafap_global.css" type="text/css" />
<link rel="stylesheet" href="../css/pafap_messages.css" type="text/css" />
<script type="text/javascript" src="../scripts/jquery-1.6.4.js"></script>
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
if(isset($_SESSION['cid'])) header('location: home.php?cid='. $_SESSION['cid']);

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
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="text" name="txtemail" id="txtemail" class="pafap_login" />
                <input type="password" name="txtpass" id="txtpass" class="pafap_login" />
	            <input type="submit" name="login" id="login" class="pafap_button" value="Log In" />
                <input type="hidden" name="token" value="<?php echo $token; ?>" />
            </form>
        </div>
    </div>
</div>

