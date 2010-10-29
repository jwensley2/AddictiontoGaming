var map;
var markers = [];
var infoWindow;

$(document).ready(function() {
	var latlng = new google.maps.LatLng(0, 0);

	var myOptions = {
		zoom: 3,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		navigationControlOptions: {
			style: google.maps.NavigationControlStyle.ZOOM_PAN
		},
	};

	map = new google.maps.Map(document.getElementById("googlemap"), myOptions);
	
	infoWindow = new google.maps.InfoWindow();
	
	$('form').submit(function() {
		steam_id = $('form #steam_id').val();
		
		$.get('/map/xml/'+steam_id, function(xml){
			map.clearMarkers();
			
			var player_latlng = new google.maps.LatLng(
		        parseFloat($(xml).find('locations > player lat').text()),
		        parseFloat($(xml).find('locations > player lng').text())
			);

			map.setCenter(player_latlng);
			map.setZoom(8);
			
			$(xml).find('players').children('player').each(function() {
				var name = $(this).children('lastName').text();

				var latlng = new google.maps.LatLng(
			        parseFloat($(this).children('lat').text()),
			        parseFloat($(this).children('lng').text())
				);

				createMarker(latlng, name);
			});
		}, 'xml');
		
		return false;
	});
});

google.maps.Map.prototype.clearMarkers = function() {
    for(var i=0; i < markers.length; i++){
        markers[i].setMap(null);
    }
    markers = new Array();
};


function createMarker(latlng, name) {
	var html = name;
	
	var marker = new google.maps.Marker({
		map: map,
		position: latlng
	});
	
	google.maps.event.addListener(marker, 'click', function() {
		infoWindow.setContent(html);
		
		infoWindow.open(map, marker);
	});
	
	markers.push(marker);
}