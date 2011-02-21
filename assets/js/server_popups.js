$(document).ready(function() {
	var toggled = false;
	var current_server;
	var popup_cache = Array(); // Storage array for cached popups
	var cache_time = 30; // Time to cache popups in seconds
	
	function popup_show(_this){
		var server_id = _this.find('.server_id').text();
		
		var timestamp = Math.round(new Date().getTime() / 1000);
		
		// Check if there is a cached version of the popup and if it is still valid
		if(popup_cache[server_id] == null || popup_cache[server_id]['time'] < timestamp - cache_time){
			// Get a fresh version of the popup
			$.get('/assets/server_popups/'+server_id+'.html', function(html){
				popup_cache[server_id] = Array();
				popup_cache[server_id]['html'] = html;
				popup_cache[server_id]['time'] = timestamp;
				
				$('#server_popup_holder').show();
				$('#server_popup_holder').html(html);
			});
		}else{
			// Show the cached popup
			$('#server_popup_holder').show();
			$('#server_popup_holder').html(popup_cache[server_id]['html']);
		}
	}

	function popup_hide(_this){
		$('#server_popup_holder').hide();
	}
	
	$('#server_status .server').bind('mouseenter.popup', function(){ popup_show($(this)); });
	$('#server_status .server').bind('mouseleave.popup', function(){ popup_hide($(this)); });
	
	$('#server_status .server').click(function() {
		if(!toggled){
			toggled = true;
			current_server = $(this);
			
			popup_show($(this));
			$(this).addClass('selected');
			
			//Unbind the mouse events to keep info box open when hovering off status indicator
			$('#server_status .server').unbind('mouseenter.popup');
			$('#server_status .server').unbind('mouseleave.popup');
		}else{
			toggled = false;
			current_server.removeClass('selected');
			
			if(!$(this).hasClass('selected')){
				popup_show($(this));
			}
			
			//Rebind mouse events so hover works again
			$('#server_status .server').bind('mouseenter.popup', function(){ popup_show($(this)); });
			$('#server_status .server').bind('mouseleave.popup', function(){ popup_hide($(this)); });
		}
	});
	
	$('#server_popup_holder .close').live('click', function() {
		toggled = false;
		current_server.removeClass('selected');
		popup_hide();
		
		//Rebind mouse events so hover works again
		$('#server_status .server').bind('mouseenter.popup', function(){ popup_show($(this)); });
		$('#server_status .server').bind('mouseleave.popup', function(){ popup_hide($(this)); });
	});
	
});