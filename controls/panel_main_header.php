<!-- panel_pafap_header-->
<div id="pafap_header">
<div id="pafap_header_container" style="margin-top:10px;">
    <div id="pafap_left_header">
        <div id="pafap_header_logo" style="margin-top:-10px;">
        </div>
    </div>
    <div id="pafap_center_header">
    &nbsp;
    </div>
    <div id="pafap_right_header">
    <ul style="float:right;">
        <li class="menuStyle"><?php  session_start(); (isset($_SESSION['pemail']))? $mail = $_SESSION['pemail'] : header("location: /plogin.php"); echo $mail; ?></li>
        <li class="link"><a href="javascript:void();" class="logout" style="color:#ffffff;">Logout</a></li>
    </ul>
    </div>
</div>
</div>
<!-- panel_pafap_header-->
