$(document).ready(function() {
	$('#server_status .server').hover(function() {
		server_id = $(this).find('.server_id').text();
		$.get('/system/cache/popups/'+server_id+'.html', function(html){
			$('#server_popup_holder').show();
			$('#server_popup_holder').html(html);
		});
		
	}, function() {
		$('#server_popup_holder').hide();
	});
});
