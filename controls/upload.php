<script type="text/javascript" src="../scripts/jquery-1.6.4.js"></script>
<script type="text/javascript" src="../scripts/jquery.form.js"></script>
<script>
$(document).ready ( function() {
  $("#upload_results").hide();
  //$("#uploadimage").attr("disabled", "disabled");
	//$("#uploadimage").hide();
  $('#upload').live('change', function(){
    $("#upload_results").show();	
    //$("#uploadimage").attr("disabled", "disabled");
    $("#upload_results").html('');
    $('#upload_results').html('<img src="../images/pafap-loader.gif" alt="Uploading"/>');
    $("#fileupload").ajaxForm({
      target: '#upload_results'
    }).submit();
  });
});
</script>
<link rel="stylesheet" href="../css/pafap_upload.css" type="text/css" media="screen" />
<p>Max size upload to 6291456 bytes. </p>
<form id="fileupload" method="POST" action="multi_upload.php" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="6291456">
    <div class="row">
    <div class="span11">
        <span class="btn success fileinput-button input">
            <span>Add files to upload</span>
            <input type="file" id="upload" name="upload[]" multiple>
        </span>
    <button type="submit" class="btn primary start" id="uploadimage" name="uploadimage">Start upload</button>
    </div>
    </div>
</form>