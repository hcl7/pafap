 $(document).ready(function(){
	$.ajax({
		type: "GET",
		url: "../ads.xml",
		dataType: "xml",
		success: function(xml) {
			$(xml).find('site').each(function(){
				var id = $(this).attr('id');
				var title = $(this).find('title').text();
				var url = $(this).find('url').text();
				$('<div class="items" id="link_'+id+'"></div>').html('<a href="'+url+'" target="parent"><img src="'+title+'" height="100%" width="100%" /></a>').appendTo('#page-wrap');
				$(this).find('desc').each(function(){
					var brief = $(this).find('brief').text();
					var long = $(this).find('long').text();
					$('<div class="brief"></div>').html(brief).appendTo('#link_'+id);
					$('<div class="long"></div>').html(long).appendTo('#link_'+id);
				});
			});
		}
	});
});
