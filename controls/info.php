<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $("#info").submit( function(){
          $.post('upinfo.php', $('#info').serialize(), function(data){
            $('#infostatus').append(data).hide().fadeIn(2000).fadeOut("slow", function(){
              $('#txtinfo').val('');
              $("#infoStatus").load('bindInfo.php');
            });
          });
          return false;
        });

});
</script>

<div itemscope itemtype="http://schema.org/PostalAddress" id="info_content">
<form id="info">
<table border="0">
  <tr><th scope="row" align="left">
    <select name="slinfo" id="slinfo" class="controls">
    <option value="infocontact">Info-Contact</option>
    <option value="education">Info-Education</option>
    </select></th></tr>
  <tr>
    <td><span itemprop="colleague"><textarea class="controls" id="txtinfo" name="txtinfo"></textarea></span></td>
  </tr>
  <tr>
    <td><input type="submit" class="btn primary start" name="updateinfo" id="updateinfo" value="Update Info" /></td>
  </tr>
</table>
</form>
<div id="infostatus"></div>
</div>
