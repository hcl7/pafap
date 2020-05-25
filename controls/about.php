  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script type="text/javascript">
    $(document).ready(function()
    {
        $("#country").change(function()
        {
            var id=$("#country option:selected").attr("rel");
            var dataString = 'id='+ id;
            //alert(id);
            $.ajax({
                type: "POST",
                url: "cities.php",
                data: dataString,
                cache: false,
                success: function(html){
                    $("#city").html(html);
                }
            });
        });
        $("#about").submit( function(){
          $.post('upabout.php', $('#about').serialize(), function(data){
            $('#status').append(data).hide().fadeIn(2000).fadeOut("slow", function(){
              $("#infoStatus").load('bindInfo.php');
            });
          });
          return false;
        });
    });
</script>
<style type="text/css" media="screen">
</style>
<div itemscope itemtype="http://schema.org/PostalAddress" id="about_content">
<form id="about">
<table border="0">
  <tr>
    <th scope="row" align="right"><label style="font-size:10px;">Relationship:</label></th>
    <td align="left"><select name="relship" id="relship" class="controls">
    <option>Married</option>
    <option>Sigle</option>
    <option>In Relationship</option>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th scope="row" align="right"><label style="font-size:10px;">Nationality:</label></th>
    <td align="left"><select name="country" id="country" class="controls">
    <option selected="selected"><span itemprop="nationality">States</span></option>
<?php
//error_reporting(0);
//session_start();
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : header('location: /index.php');
$prf = new pafap_profile();
$tmpl = new pafap_templates;
$sql = "SELECT stateID, state FROM pafap_states";
$states = $prf->binder($sql, "stateID", "state");
$tmpl->showbinder($states);
?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th scope="row" align="right"><label style="font-size:10px;">Residence:</label></th>
    <td align="left"><select name="city" id="city" class="controls">
        <option selected="selected"><span itemprop="addressLocality">Cities</span></option>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td><input type="submit" class="btn primary start" name="pfupdate" id="pfupdate" value="Update Profile" /></td>
    <td></td>
  </tr>
</table>
</form>
<div id="status"></div>
</div>
