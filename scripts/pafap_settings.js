$(document).ready(function(){
  $('a.editpass').click(function(event){
    event.preventDefault();
    $(this).parent('#changepass').siblings('#editpassarea').slideToggle("fast", function(){});
  });
  $('#btnchangepass').click(function() {
    var oldpassvar = $('#txtchangepass').val();
    var newpassvar = $('#txtchangenewpass').val();
    var renewpassvar = $('#txtchangerenewpass').val();
    $.post('../controls/changepass.php', {oldpass:oldpassvar, newpass:newpassvar, renewpass:renewpassvar}, function(data){
      $('#lblstatus').html(data).hide().fadeIn(2000).fadeOut("slow", function(){
        location.reload();
      });
    });
  });

  $('#btnupdateaccount').click(function() {
    var fn = $('#txtfn').val();
    var ln = $('#txtln').val();
    var email = $('#txtmail').val();
    var birthday = $('#txtbirth').val();
    var status = $('#txtstatus').val();
    $.post('../controls/account.php', {accfn:fn, accln:ln, accmail:email, accbirth:birthday, accstatus:status}, function(data){
      $('#lblaccstatus').html(data).hide().fadeIn(2000).fadeOut("slow", function(){
        location.reload();
      });
    });
  });

  $('#btnupdatepage').click(function() {
    var rn = $('#txtrn').val();
    var lnk = $('#txtlink').val();
    $.post('../controls/page.php', {pgrn:rn, pglnk:lnk}, function(data){
      $('#lblrstatus').html(data).hide().fadeIn(2000).fadeOut("slow", function(){
        location.reload();
      });
    });
  });

  $('a.editacc').click(function(event){
    event.preventDefault();
    $(this).parent('#editaccount').siblings('#editaccarea').slideToggle("fast", function(){});
  });

  $('a.editpg').click(function(event){
    event.preventDefault();
    $(this).parent('#editpage').siblings('#editpgarea').slideToggle("fast", function(){});
  });

  $('a.editcatg').click(function(event){
    event.preventDefault();
    $(this).parent('#editcategories').siblings('#editcatgarea').slideToggle("fast", function(){});
  });

  $('a.editimg').click(function(event){
    event.preventDefault();
    $(this).parent('#editimage').siblings('#editimgarea').slideToggle("fast", function(){});
  });

  $('.catdelete').click ( function() {
    var rel = $(this).attr('rel');
    var id = $(this).attr('id');
    var ctname = $(this).attr('catg');
    $.post('../controls/del_catg.php', {catgpid:rel, catgcid:id, catgctname:ctname}, function(data){
      $('#cat_' + ctname).html(data).hide().fadeIn(2000).fadeOut("slow", function(){
        location.reload();
      });
    });
  });

});