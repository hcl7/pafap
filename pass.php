<?php
if(isset($_POST['submit']))
{
  $pass = $_POST['txtpass'];
  echo md5($pass);
}

?>
<form name="md5pass" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="password" id="txtpass" name="txtpass" />
<input type="submit" id="submit" name="submit" value="Run" />
</form>