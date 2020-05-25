<link href="../css/ticker-style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="../scripts/jquery.ticker.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('#js-news').ticker();
    });
</script>
<?php
if (dirname($_SERVER["PHP_SELF"]) == "\\" || dirname($_SERVER["PHP_SELF"]) == "/")
{
  include ('pafap_classes/foot_pafap_class.php');
}
else
{
  include ('../pafap_classes/foot_pafap_class.php');
}

$ns = new pafap_foot();

?>
<div itemscope itemtype="http://schema.org/Organizaition" id="pafap_footer_container">
<!--<ul id="js-news" class="js-hidden">-->

<?php
//$ns->bindNews();
?>

</ul>
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