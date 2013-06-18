jQuery(document).ready(function($) {
	initServerList();
});

function initServerList () {
	var serverList	= $("#server-list");
	var tab			= serverList.find(".tab");
	var hide		= serverList.find(".hide");
	var oLeft		= serverList.css("left");
	
	var servers	= serverList.find(".server");
	
	tab.click(function(e) {
		e.preventDefault();
		
		if (serverList.hasClass("open")) {
			closeList();
		} else {
			openList();
		}
	});
	hide.click(closeList);
	
	function openList () {
		serverList.animate({left: 0});
		serverList.addClass("open");
	}
	
	function closeList () {
		serverList.animate({left: oLeft});
		serverList.removeClass("open");
	}
	
	servers.children("header").click(function(e) {
		var server = $(this).parent();
		var dropdown = server.children(".dropdown");
		
		if ( ! server.hasClass("open")) {
			var siblings = server.siblings();
			
			server.addClass("open");
			dropdown.slideDown(500);
			
			siblings.removeClass("open");
			siblings.children(".dropdown").slideUp(500);
		} else {
			server.removeClass("open");
			dropdown.slideUp(500);
		};
	});
}