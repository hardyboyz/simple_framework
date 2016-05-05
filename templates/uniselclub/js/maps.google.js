
    var poly;
    var map;
    var markers;
    var infowindow = null;
    var path = new google.maps.MVCArray;
    var geocoder = new google.maps.Geocoder();
	var directionsDisplay;
	var directionsService = new google.maps.DirectionsService();

    function geocodePosition(pos) {
      geocoder.geocode({
        latLng: pos
      }, function(responses) {
        if (responses && responses.length > 0) {
          updateMarkerAddress(responses[0].formatted_address);
        } else {
          updateMarkerAddress('Cannot determine address at this location.');
        }
      });
    }
	
	 function geocodePosition2(pos) {
      geocoder.geocode({
        latLng: pos
      }, function(responses) {
        if (responses && responses.length > 0) {
          updateMarkerAddress(responses[0].formatted_address);
        } else {
          updateMarkerAddress('Cannot determine address at this location.');
        }
      });
    }

    function updateMarkerStatus(str) {
      document.getElementById('markerStatus').innerHTML = str;
    }

    function updateMarkerPosition(latLng) {
      document.getElementById('coord_from').value = [
        latLng.lat(),
        latLng.lng()
      ].join(',');

    }
	
	function updateMarkerPosition2(latLng) {
      document.getElementById('coord_to').value = [
        latLng.lat(),
        latLng.lng()
      ].join(',');

    }
	
	function clearMarker() {
    if ( marker )
        marker.setMap(null);
	}

    function updateMarkerAddress(str) {
      document.getElementById('address').innerHTML = str;
    }

    function initialize() {
        var latLng = new google.maps.LatLng(3.1333, 101.7000);
        map = new google.maps.Map(document.getElementById("map-canvas"), {
            zoom: 10,
            center: latLng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
			travelMode: google.maps.TravelMode.DRIVING
        });

        google.maps.event.addListener(map, 'click', addPoint);
        infowindow = new google.maps.InfoWindow({   content: "holding..." });
		directionsDisplay.setMap(map);
    }

    var markers=[];
	for (var i=0;i<markers.length;i++){
		 function addPoint(event) {
			path.insertAt(path.length, event.latLng);
			var marker = new google.maps.Marker({
				position: event.latLng,
				map: map,
				draggable: false,
			}); 
				markers.push(marker);
				marker.setTitle("#" + path.length);

			// Add dragging event listeners.

			google.maps.event.addListener(marker, 'dragstart', function() {
				updateMarkerAddress('Dragging...');
			});

			google.maps.event.addListener(marker, 'drag', function() {
				updateMarkerStatus('Dragging...');
				updateMarkerPosition(marker.getPosition());
			});

			google.maps.event.addListener(marker, 'dragend', function() {
				updateMarkerStatus('Drag ended');
				geocodePosition(marker.getPosition());
			});

			google.maps.event.addListener(marker, 'click', function() {
				marker.setMap(null);
				for (var i = 0, I = markers.length; i < I && markers[i] != marker; ++i);
					markers.splice(i, 1);
				path.removeAt(i);
			});

			google.maps.event.addListener(marker, 'dragend', function() {
				for (var i = 0, I = markers.length; i < I && markers[i] != marker; ++i);
					path.setAt(i, marker.getPosition());
			});
			

				updateMarkerPosition(markers[0].getPosition());
				updateMarkerPosition2(markers[1].getPosition());


			//alert(markers.join("\n"));
			
			var directionsDisplay = new google.maps.DirectionsRenderer();
			var directionsService = new google.maps.DirectionsService();
			var distanceInput 	= document.getElementById('distance');
			var amount 			= document.getElementById('amount');
			directionsDisplay.setMap(map);
			var request = {
				origin: markers[0].getPosition(), 
				destination: markers[1].getPosition(), 
				waypoints: [{
					location: markers[1].getPosition(),
					stopover: false
				}], 
				optimizeWaypoints: true,         
				travelMode: google.maps.TravelMode["DRIVING"]
			};
			//console.log(request);
			
			directionsService.route(request, function(result, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					//clearMarker();
					directionsDisplay.setDirections(result);
					distanceInput.value = result.routes[0].legs[0].distance.value / 1000;

				} else {
					alert("Sorry, we couldn't route from your location!");
				}
			});
			
			

		 }
		 
	}
    google.maps.event.addDomListener(window, 'load', initialize);
