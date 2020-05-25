<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        $("#category").change(function()
        {
            var catid=$("#category option:selected").attr("rel");
            var dataString = 'catid='+ catid;
            //alert(cid);
            $.ajax({
                type: "POST",
                url: "category_type.php",
                data: dataString,
                cache: false,
                success: function(html){
                    $("#ctype").html(html);
                }
            });
        });
        $("#addcatg").submit( function(){
          $.post('add_category_type.php', $('#addcatg').serialize(), function(data){
            $('#cstatus').append(data).hide().fadeIn(2000).fadeOut("slow", function(){
              $("#infoStatus").load('bindInfo.php');
            });
          });
          return false;
        });
    });
</script>
<div id="about_content">
<form id='addcatg'>
<table border="0">
  <tr>
    <th scope="row" align="right"><label style="font-size:10px;">Categories:</label></th>
    <td align="left"><select name="category" id="category" class="controls">
        <option>Categories</option>
<?php
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : header('location: /index.php');
$prf = new pafap_profile();
$tmpl = new pafap_templates;
$sql = "SELECT cid, cname FROM pafap_category";
$catg = $prf->binder($sql, "cid", "cname");
$tmpl->showbinder($catg);
?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th scope="row" align="right"><label style="font-size:10px;">Category Type:</label></th>
    <td align="left"><select name="ctype" id="ctype" class="controls">
        <option selected="selected">Category type</option>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td><input type="submit" class="btn primary start" name="catgadd" id="catgadd" value="Add Categories" /></td>
    <td></td>
  </tr>
</table>
</form>
<div id="cstatus"></div>
</div>
