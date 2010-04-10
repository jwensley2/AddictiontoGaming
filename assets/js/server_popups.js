$(document).ready(function() {
	var toggled = false;
	var current_server;
	
	function popup_show(_this){
		server_id = _this.find('.server_id').text();
		$.get('/system/cache/popups/'+server_id+'.html', function(html){
			$('#server_popup_holder').show();
			$('#server_popup_holder').html(html);
		});
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