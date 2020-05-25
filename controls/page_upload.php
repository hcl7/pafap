<script type="text/javascript" src="../scripts/jquery-1.6.4.js"></script>
<script type="text/javascript" src="../scripts/jquery.form.js"></script>
<script>
$(document).ready ( function() {
  $("#page_upload_results").hide();
  //$("#pageuploadimage").attr("disabled", "disabled");
  $('#pupload').live('change', function(){
    $("#page_upload_results").show();
    $("#page_upload_results").html('<img src="../images/pafap-loader.gif" alt="Uploading"/>');
    $("#pagefileupload").ajaxForm({
      target: '#page_upload_results'
    }).submit();
  });
});
</script>
<link rel="stylesheet" href="../css/pafap_upload.css" type="text/css" media="screen" />
<p>Max size upload to 6291456 bytes. </p>
<form id="pagefileupload" method="POST" action="single_upload.php" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="6291456">
    <div class="row">
    <div>
        <span class="btn success fileinput-button input">
            <span>Add files to upload</span>
            <input type="file" id="pupload" name="pupload[]" multiple>
        </span>
    <button type="submit" class="btn primary start" id="pageuploadimage" name="pageuploadimage">Start upload</button>
    <p><div id="page_upload_results" class="alert-message info"></div></p>
    </div>
    </div>
</form>