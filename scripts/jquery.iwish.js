﻿ (function ($) {
	$.fn.iWish = function (options) {
		var audioSource = options.audioSource, myAudio = document.createElement("audio"), fileExt, i = true;
		if (myAudio.canPlayType) {
			fileExt = (!!myAudio.canPlayType && "" != myAudio.canPlayType('audio/mpeg') ? "mp3" : (!!myAudio.canPlayType && "" != myAudio.canPlayType('audio/wav') ? "wav" : (!!myAudio.canPlayType && "" != myAudio.canPlayType('audio/ogg; codecs="vorbis"') ? "ogg" : false)));
			$(this).each(function () {
				if (typeof $(this).attr("src") === "undefined" && $(this).children("source").size() < 1) {
					$(this).append('<source src="' + audioSource + '.' + fileExt + '">');
					if (options.autoPlay && i) {
						$(this).attr("autoplay", true);
						i = false;
					}
				}
                else $(this).html('Your browser does not play mp3 format!');
			});
		} else {
			$(this).each(function () {
				$(this).after('<p class="no-support">Your browser does not support the audio-tag.</p>');
				$(this).hide();
			});
		}
	}
})(jQuery);
