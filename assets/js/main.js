$(document).ready(function() {
	
	//$('#twitter_module textarea').bind('keydown', updateCount);
	$('#twitter_module textarea').bind('keyup', updateCount);
	
	function updateCount(){	
		var count = $(this).val().length;
		$('#twitter_module .used').html(count+'/150');
	}
});
