<?php
function send_mail()
{
  loadsmtp::mailsend();
}
class loadsmtp
{
  public static $fetch_ini_var;
  public static $mail;
  public static function include_file($param1){ require_once($param1.'.php'); }
  public static function  recive_array($array1)
  {
    loadsmtp::include_file('toobj');
    loadsmtp::$fetch_ini_var=new toObj($array1);
  }
  public static function setsmtp()
  {
     loadsmtp::recive_array(parse_ini_file("smtpinfo.ini", true));
     loadsmtp::include_file('phpmailer-pafap-class');
     loadsmtp::$mail = new PHPGMailer();
     loadsmtp::$mail->IsSMTP();    
     loadsmtp::$mail->Host = loadsmtp::$fetch_ini_var->smtp_authantitation->smtp_server;
	 loadsmtp::$mail->Username =loadsmtp::$fetch_ini_var->smtp_authantitation->smtp_user_name;
     loadsmtp::$mail->Password =loadsmtp::$fetch_ini_var->smtp_authantitation->smtp_password;
	 loadsmtp::$mail->AddReplyTo($GLOBALS['reply_to'],$GLOBALS['reply_name']);
     loadsmtp::$mail->Port = loadsmtp::$fetch_ini_var->smtp_authantitation->port;
	 loadsmtp::$mail->From = loadsmtp::$fetch_ini_var->smtp_authantitation->smtp_user_name;
     loadsmtp::$mail->FromName = $GLOBALS['from_name'];
     loadsmtp::$mail->Subject = $GLOBALS['subject'];
	 loadsmtp::$mail->ClearAddresses();
	 loadsmtp::$mail->AddAddress($GLOBALS['resipent_address']);
	 loadsmtp::$mail->IsHTML($GLOBALS['ishtml']);
     loadsmtp::$mail->Body =$GLOBALS['htmlcontent'];
  }
  public static function mailsend()
  {
     loadsmtp::setsmtp();
	 if(!loadsmtp::$mail->Send())
	 {
	   echo "Mailer Error: " . loadsmtp::$mail->ErrorInfo."<br/>";
	 }
	 else
	 {
	   echo "Message has been sent"."<br/>";
	 }
  }
}



?> 
