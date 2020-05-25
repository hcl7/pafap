<!-- pafap_header-->
<script type="text/javascript" src="../pafap/scripts/pafap_popups.js"></script>
<script>
$(document).ready(function() {
  $(".dropdown .button, .dropdown button").click(function () {
  if (!$(this).find('span.toggle').hasClass('active')) {
    $('.dropdown-slider').slideUp();
	$('span.toggle').removeClass('active');
  }
  $(this).parent().find('.dropdown-slider').slideToggle('fast');
  $(this).find('span.toggle').toggleClass('active');
  return false;
  });
});
</script>

<div id="pafap_header">
<div id="pafap_header_container">
    <div id="pafap_left_header">
        <div id="pafap_header_logo">
        </div>
    </div>
    <div id="pafap_center_header">
    <ul>
		<li>
			<a href="/pafap/home.php?cid=<?php session_start(); echo (isset($_SESSION['cid']))? $_SESSION['cid'] : 100; ?>" title="Home" id="homes"></a>
		</li>
		<li>
			<a href="/pafap/controls/userprofile.php" title="Profile" id="profile"></a>
		</li>
		<li>
			<a href="/pafap/controls/userimage.php?images=personal" title="Photo" id="photo"></a>
		</li>
		<li>
			<a href="/pafap/games/pafap_games.php?nr=<?php echo (isset($gms))? $gms : 0; ?>" title="game" id="game"></a>
		</li>
        <li>
			<a href="/pafap/controls/records.php" title="Records" id="record"></a>
		</li>
        <li>
            <form id="searchFrm" method="GET" action="../controls/search.php" style="display:inline;">
				<input style="margin-top:4px;" id="userSearch" name="userSearch" class="pafap_search" type="text"/>
			</form>
        </li>
	</ul>
    </div>
    <div id="pafap_right_header">
        <div class="buttons" style="float:right;">
            <a href="../controls/downloads.php" title="Downloads" class="button left"><span class="icon icon70"></span><span class="label blue">Downloads</span></a>
            <div class="dropdown left">
                <a href="#" class="button left"><span class="icon icon96"></span><span class="label">Options</span><span class="toggle"></span></a>
                <div class="dropdown-slider">
                    <a href="../controls/messages.php" title="Messages" class="ddm"><span class="icon icon125"></span><span class="label">Inbox<?php (isset($_SESSION['email']))? $mail = $_SESSION['email'] : header("location: /index.php"); ?></span></a>
                    <a href="../controls/settings.php?profile=edit" title="Settings" class="ddm"><span class="icon icon196"></span><span class="label">Settings</span></a>
                    <a href="#" class="logout ddm negative"><span class="icon icon151"></span><span class="label">Logout</span></a>
                </div>
            </div>
            <a href="../controls/friends.php" title="Friends" class="button left"><span class="icon icon127"></span><span class="label blue">Friends</span></a>
        </div>
    </div>
</div>
</div>
<!-- pafap_header-->
