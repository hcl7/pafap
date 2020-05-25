function Show(divId)
{
    document.getElementById(divId).style.visible ='visible';
}

function Hide(divId)
{
    document.getElementById(divId).style.visible ='hidden';
}

function popup(url){
   popupWin = window.open(url, 'pafapFriends', 'height=300, width=300,left=10,top=10,resizable=no,scrollbars=yes,toolbars=no,menubar=no,directories=no,status=no');
}

// autoresize
var observe;
if (window.attachEvent) {
    observe = function (element, event, handler) {
        element.attachEvent('on'+event, handler);
    };
}
else {
    observe = function (element, event, handler) {
        element.addEventListener(event, handler, false);
    };
}
function autoresize (txtarea) {
    var text = document.getElementById(txtarea);
    function resize () {
        text.style.height = 'auto';
        text.style.height = text.scrollHeight+'px';
    }

    function delayedResize () {
        window.setTimeout(resize, 0);
    }
    observe(text, 'change',  resize);
    observe(text, 'cut',     delayedResize);
    observe(text, 'paste',   delayedResize);
    observe(text, 'drop',    delayedResize);
    observe(text, 'keydown', delayedResize);

    text.focus();
    text.select();
    resize();
}
// autoresize

//jquery scripts;

$(document).ready ( function() {
    function CheckForm() {
	  if (document.searchFrm.userSearch.value==''){
		document.searchFrm.userSearch.focus();
		return false;
	  }
	  return true
    };
    $('#messages').html('<center><img src="images/pafap-loader.gif" alt="Loading"/></center>');
    $('#record_messages').html('<center><img src="../images/pafap-loader.gif" alt="Loading"/></center>');
	$("#messages").load('controls/BindWall.php', {moreresults:2});
    $("#record_messages").load('../controls/bindRecordWall.php', {morerecordresults:2});

    $(".logout").click( function() {
      $.post('../controls/logout.php', function() {
        location.reload();
      });
      return false;
    });

	$('#home').submit ( function() {
		$.post('controls/PostWall.php', $('#home').serialize(), function(data) {
          $("#current_messages").html(data).hide().fadeIn(2000).fadeOut("slow", function(){
            $("#messages").load('controls/BindWall.php', {moreresults:$("#getmore").val()});
            $("#postwall").val('');
          });
		});
		return false;
	});

    $('#homerecord').submit ( function() {
      $.post('../controls/postRecordWall.php', $('#homerecord').serialize(), function(data) {
        $("#current_record_messages").html(data).hide().fadeIn(2000).fadeOut("slow", function(){
          $("#record_messages").load('../controls/bindRecordWall.php', {morerecordresults:$("#getmorerecord").val()});
          $("#postrecordwall").val('');
        });
	  });
	  return false;
	});

    $("ul.leftmenu li").click(function() {
      var categoryID = $(this).attr('value');
      $('#messages').html('<center><img src="images/pafap-loader.gif" alt="Loading"/></center>');
      $("#messages").load('controls/BindWall.php', {moreresults:2});
      $("ul.leftmenu li").removeClass('selected').addClass('selected');
    });

    $(".autolink").click(function() {
      var idx = $(this).attr('rel');
      var getmore = parseInt($("#getmore").val()) + parseInt(idx);
      $("#messages").load('controls/BindWall.php', {moreresults:getmore});
      $("#getmore").val(getmore);
    });

    $(".autolinkrecord").click(function() {
      var idr = $(this).attr('rel');
      var getmorerecord = parseInt($("#getmorerecord").val()) + parseInt(idr);
      $("#record_messages").load('../controls/bindRecordWall.php', {morerecordresults:getmorerecord});
      $("#getmorerecord").val(getmorerecord);
    });

    $('a.addFriend').click ( function() {
        var af = $(this).attr('rel');
        var dataaf = 'af=' + af;
        $.ajax({
          type: "POST",
          data: dataaf,
          url: "../controls/invitations.php",
          cache: false,
          success: function(d){
            $("#sim_status").html(d).hide().fadeIn(2000).fadeOut("slow", function(){
              $("#messages").load('controls/BindWall.php', {moreresults:$("#getmore").val()});
            });
          }
        });
    });

    $('a.addFollow').click ( function() {
      var af = $(this).attr('rel');
      var dataaf = 'afll=' + af;
      $.ajax({
        type: "POST",
        data: dataaf,
        url: "../controls/follow.php",
        cache: false,
        success: function(d){
          $("#sim_status").html(d).hide().fadeIn(2000).fadeOut("slow", function(){
            $("#messages").load('controls/BindWall.php', {moreresults:$("#getmore").val()});
          });
        }
      });
    });

    $('a.addViewFollow').click ( function() {
      var af = $(this).attr('rel');
      var dataaf = 'afll=' + af;
      $.ajax({
        type: "POST",
        data: dataaf,
        url: "../controls/follow.php",
        cache: false,
        success: function(d){
          $("#recstatus").html(d).hide().fadeIn(2000).fadeOut("slow", function(){
            $("#record_messages").load('../controls/bindRecordWall.php', {morerecordresults:$("#getmorerecord").val()});
          });
        }
      });
    });

    $('a.searchAddFriend').click ( function() {
        var af = $(this).attr('rel');
        var dataaf = 'af=' + af;
        $.ajax({
          type: "POST",
          data: dataaf,
          url: "../controls/invitations.php",
          cache: false,
          success: function(d){
            $("#search_status").html(d).hide().fadeIn(2000).fadeOut(3000);
          }
        });
    });

    $('a.searchFollow').click ( function() {
        var af = $(this).attr('rel');
        var dataaf = 'afll=' + af;
        $.ajax({
          type: "POST",
          data: dataaf,
          url: "../controls/follow.php",
          cache: false,
          success: function(d){
            $("#search_status").html(d).hide().fadeIn(2000).fadeOut(3000);
          }
        });
    });

    $('a.friendConfirm').click ( function() {
      var confirm = $(this).attr('rel');
      var dataconf = 'confirm=' + confirm;
      $.ajax({
        type: "POST",
        data: dataconf,
        url: "../controls/confirm.php",
        cache: false,
        success: function(conf){
          $("#conf_status").html(conf).hide().fadeIn(2000).fadeOut(3000);
          $("#inv_" + confirm).hide();
          $("#friends_status").load('../controls/bindFriends.php');
        }
      });
    });

    $('a.friendCancel').click ( function(){
      var cancel = $(this).attr('rel');
      var datacancel = 'cancel=' + cancel;
      $.ajax({
        type: "POST",
        data: datacancel,
        url: "../controls/cancel.php",
        cache: false,
        success: function(canc){
          $("#conf_status").html(canc).hide().fadeIn(2000).fadeOut(3000);
          $("#inv_" + cancel).hide();
        }
      });
    });

    var tmp;
    $('.vlightbox').click (function(){
      var imgid = $(this).attr("rel");
      tmp = imgid;
      $("#imageCommentResults").load('../controls/imgBindComment.php', {imgcommid:tmp});
    });

    $('#prevLinkImg').click( function(){
      var lnk = $("#imgselected").val();
      var str = lnk.substring(lnk.lastIndexOf("/") + 1, lnk.length);
      $.post('../controls/bindImgId.php', {imagename:str}, function(iid){
        tmp = iid;
        $("#imageCommentResults").load('../controls/imgBindComment.php', {imgcommid:tmp});
      });
    });

    $('#nextLinkImg').click( function(){
      var lnk = $("#imgselected").val();
      var str = lnk.substring(lnk.lastIndexOf("/") + 1, lnk.length);
      $.post('../controls/bindImgId.php', {imagename:str}, function(iid){
        tmp = iid;
        $("#imageCommentResults").load('../controls/imgBindComment.php', {imgcommid:tmp});
      });
    });

    $('#imagePostComment').click ( function(){
      var imgtext = $('#imageCommentTextarea').val();
      $.post('../controls/imgPostComment.php', {imageid:tmp, imgpostcomment:imgtext}, function(data){
        $("#imageCurrentCommentResults").html(data).hide().fadeIn(2000).fadeOut("slow", function(){
          $("#imageCommentResults").load('../controls/imgBindComment.php', {imgcommid:tmp});
        });
        $('#imageCommentTextarea').val('');
      });
    });

    $('.pafap_search').keydown (function(event){
      if(event.keyCode && event.keyCode == '13' && CheckForm()){
        $('#searchFrm').submit( function(){
          $.post('../controls/search.php', $('#searchFrm').$serialize());
        });
      }
    });

});

//jquery scripts end;

