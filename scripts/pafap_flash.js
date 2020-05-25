function flashEmbed(ffile)
{
  var flashvars = {};
  var params = {
    allowFullScreen: "true",
    menu: "false",
    wmode: "window"
  };
  var attributes = {
    id: "resized",
    name: "resized",
    wmode: "window"
  };
  swfobject.embedSWF(ffile, "resized", "100%", "100%", "10.0.0", ffile, flashvars, params, attributes);
}
function ResizeFlash(newWidth,newHeight, swfile){
  flashEmbed(swfile);
  if(newWidth){
  	$("#resized").css("width",newWidth);
  }
  if(newHeight){
  	$("#resized").css("height",newHeight);
  }
}