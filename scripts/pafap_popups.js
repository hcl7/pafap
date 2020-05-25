/*pafap_popup.js*/
var popupStatus = 0;
function loadPopup(bgpopup, bodypopup){
	if(popupStatus==0){
		$("#" + bgpopup).css({
			"opacity": "0.7"
		});
		$("#" + bgpopup).fadeIn("slow");
		$("#" + bodypopup).fadeIn("slow");
		popupStatus = 1;
	}
}

function disablePopup(bgpopup, bodypopup){
	if(popupStatus==1){
		$("#" + bgpopup).fadeOut("slow");
		$("#" + bodypopup).fadeOut("slow");
		popupStatus = 0;
	}
}

function centerPopup(bgpopup, bodypopup){
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#" + bodypopup).height();
	var popupWidth = $("#" + bodypopup).width();

	$("#" + bodypopup).css({
		"position": "absolute",
		"top": windowHeight/popupHeight/2,
		"left": windowWidth/2-popupWidth
	});
    //IE6
	$("#" + bgpopup).css({
		"height": windowHeight
	});
}
