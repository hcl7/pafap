$(document).ready(function(){
      var textarea_id;
      $('a.comment').click(function(event){
        var id = $(this).attr('rel');
        event.preventDefault();
        $(this).parent('#commentlink').siblings('#textcomment').slideToggle("fast", function(){
          textarea_id = id;
          $("textarea#" + id).focus();
        });
      });

      $('#msHideShow, #msHS').click(function(event){
        event.preventDefault();
        $(this).parent('#msHideShow').siblings('#textMessage').slideToggle("fast");
      });

      $('#msReplay, #msrpl').click(function(event){
        event.preventDefault();
        $(this).parent('#msReplay').siblings('#textReplay').slideToggle("fast");
      });

      $('.msPostReplay').click (function(){
        var msid = $(this).attr('rel');
        var msgreplay = $("#msrepl_" + msid).val();
        $.post('msReplay.php', {replayTo:msid, msReplay:msgreplay}, function(msg){
          $('#replaystatus_' + msid).html(msg).hide().fadeIn(2000).fadeOut("slow", function(){
            location.reload();
          });
        });
      });

      $("textarea#" + textarea_id).keydown (function(event){
        if(event.keyCode && event.keyCode == '13'){
          $("#cwid").val(textarea_id);
          $("#postcomment").val($("textarea#" + textarea_id).val());
          $.post('controls/PostComment.php', $('#frmcomment').serialize(), function(data){
            $("#status_" + textarea_id).html(data).hide().fadeIn(2000).fadeOut("slow", function(){
              $("#postcomment").val($("textarea#" + textarea_id).val(''));
              $("#messages").load('controls/BindWall.php', {moreresults:$("#getmore").val()});
            });
          });
          return false;
        }
      });

      $("a.post").click ( function() {
        var wid = $(this).attr('rel');
        $("#cwid").val(wid);
        $("#postcomment").val($("textarea#" + wid).val());
        $.post('controls/PostComment.php', $('#frmcomment').serialize(), function(data){
          $("#status_" + wid).html(data).hide().fadeIn(2000).fadeOut("slow", function(){
            $("#postcomment").val($("textarea#" + wid).val(''));
            $("#messages").load('controls/BindWall.php', {moreresults:$("#getmore").val()});
            //popup.callPopup('<div id="NotificationBox" class="UINotification"><div class="UINotification_Full"><div class="Notis"><div class="UINoti UINoti_Top UINoti_Bottom UINoti_Selected" style="opacity: 1; "><a class="UINoti_NonIntentional" href="#"><div class="UINoti_Icon"><i class="Notification_icon image2"></i></div><span class="Notification_x">&nbsp;</span><div class="UINoti_Title"><span class="NotiContent">Test Notification</span><span class="NotiContent"> For pafap</span></div></a></div></div></div></div>');
          });
        });
        return false;
      });

      $("a.postrecord").click ( function() {
        var wid = $(this).attr('rel');
        $("#crwid").val(wid);
        $("#postrecordcomment").val($("textarea#" + wid).val());
        $.post('../controls/postRecordComment.php', $('#frmrecordcomment').serialize(), function(data){
          $("#status_" + wid).html(data).hide().fadeIn(2000).fadeOut("slow", function(){
            $("#postrecordcomment").val($("textarea#" + wid).val(''));
            $("#record_messages").load('../controls/bindRecordWall.php', {morerecordresults:$("#getmorerecord").val()});
          });
        });
        return false;
      });

      $('a.agree').click ( function (){
        var awid = $(this).attr('rel');
        var dataagree = 'widagree=' + awid;
        $.ajax({
          type: "POST",
          url: "controls/agree.php",
          data: dataagree,
          cache: false,
          success: function(data){
            $("#status_" + awid).html(data).hide().fadeIn(2000).fadeOut("slow", function(){
              $("#messages").load('controls/BindWall.php', {moreresults:$("#getmore").val()});
              //popup.callPopup('<div id="NotificationBox" class="UINotification"><div class="UINotification_Full"><div class="Notis"><div class="UINoti UINoti_Top UINoti_Bottom UINoti_Selected" style="opacity: 1; "><a class="UINoti_NonIntentional" href="#"><div class="UINoti_Icon"><i class="Notification_icon image2"></i></div><span class="Notification_x">&nbsp;</span><div class="UINoti_Title"><span class="NotiContent">Test Notification</span><span class="NotiContent"> For pafap</span></div></a></div></div></div></div>');
            });
          }
        });
      });

      $('a.ragree').click ( function (){
        var awid = $(this).attr('rel');
        var dataragree = 'widragree=' + awid;
        $.ajax({
          type: "POST",
          url: "../controls/ragree.php",
          data: dataragree,
          cache: false,
          success: function(data){
            $("#status_" + awid).html(data).hide().fadeIn(2000).fadeOut("slow", function(){
              $("#record_messages").load('../controls/bindRecordWall.php', {morerecordresults:$("#getmorerecord").val()});
            });
          }
        });
      });

      $('a.simInfo').click (function(){
        var si = $(this).attr('rel');
        $('#userinfo').html('<img src="images/pafap-loader.gif" alt="Loading"/>');
        $('#userinfo').load('controls/infoprofile.php', {infouser:si});
        centerPopup('bgPopupProfileInfo', 'userinfo');
        loadPopup('bgPopupProfileInfo', 'userinfo');
      });

      $('a.delete').click ( function() {
        var iid = $(this).attr('rel');
        var dataiid = 'iid=' + iid;
        $('#vlight_' + iid).hide();
        $('#ddl_' + iid).hide();
        $.ajax({
          type: "POST",
          url: "../controls/del_img.php",
          data: dataiid,
          cache: false,
          success: function(html){
            $("#img_status").html(html).hide().fadeIn(2000).fadeOut("slow", function(){
              $(this).hide();
            });
          }
        });
      });

      $('a.img_prof').click ( function() {
        var fn = $(this).attr('rel');
        var datafn = 'fn=' + fn;
        $.ajax({
          type: "POST",
          url: "../controls/prf_img.php",
          data: datafn,
          cache: false,
          success: function(html){
            $("#img_status").html(html).hide().fadeIn(2000).fadeOut(3000);
          }
        });
        return false;
      });

      $('a.img_wall').click ( function() {
        var aw = $(this).attr('rel');
        var datawl = 'asWall=' + aw;
        $.ajax({
          type: "POST",
          url: "../controls/asWall.php",
          data: datawl,
          cache: false,
          success: function(html){
            $("#img_status").html(html);
          }
        });
        return false;
      });

      $('a.msdel').click ( function() {
        var mid = $(this).attr('rel');
        var datamid = 'msid=' + mid;
        $.ajax({
          type: "POST",
          data: datamid,
          url: "msDel.php",
          cache: false,
          success: function(del){
            $('#msdelID_' + mid).hide();
            $("#messages_status").html(del).hide().fadeIn(2000).fadeOut("slow", function(){
              $('#inbox').load('inbox.php');
            });
          }
        });
      });

      $('a.dwall').click ( function() {
        var dw = $(this).attr('rel');
        var datadw = 'wallID=' + dw;
        $.ajax({
          type: "POST",
          data: datadw,
          url: "../controls/del_wall.php",
          cache: false,
          success: function(data){
            $("#wall_" + dw).hide();
          }
        });
      });

      $('a.drwall').click ( function() {
        var dw = $(this).attr('rel');
        var datadw = 'wallID=' + dw;
        $.ajax({
          type: "POST",
          data: datadw,
          url: "../controls/del_wall.php",
          cache: false,
          success: function(data){
            $("#rwall_" + dw).hide();
          }
        });
      });

      $('a.dfrnds').click ( function() {
        var dfr = $(this).attr('rel');
        var datadfr = 'frID=' + dfr;
        $.ajax({
          type: "POST",
          data: datadfr,
          url: "../controls/del_friends.php",
          cache: false,
          success: function(dfrnd){
            $("#frnds_" + dfr).html(dfrnd).hide().fadeIn(2000).fadeOut("slow", function(){
                $("#friends_status").load('../controls/bindFriends.php');
            });
          }
        });
      });

      $('a.info_fr').click (function(){
        var fi = $(this).attr('rel');
        $('#userinfo_fr').html('<img src="../images/pafap-loader.gif" alt="Loading"/>');
        $('#userinfo_fr').load('../controls/infoprofile.php', {infouser:fi});
        centerPopup('bgPopupProfileInfo', 'userinfo_fr');
        loadPopup('bgPopupProfileInfo', 'userinfo_fr');
      });

      $('a.info_search').click (function(){
        var is = $(this).attr('rel');
        $('#userinfo_search').html('<img src="../images/pafap-loader.gif" alt="Loading"/>');
        $('#userinfo_search').load('../controls/infoprofile.php', {infouser:is});
        centerPopup('bgPopupProfileInfo', 'userinfo_search');
        loadPopup('bgPopupProfileInfo', 'userinfo_search');
      });

     $('.mailadmn').click (function(){
       var iid = $(this).attr('rel');
       var mail = $(this).attr('mail');
       $.post('../mailer/sender.php', {postemail:mail}, function(data){
         $("#madmn_" + iid).html(data).hide().fadeIn(2000).fadeOut("slow", function(){
           location.reload();
         });
       });
     });
});