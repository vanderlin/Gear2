<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
       	
<script type="text/javascript">

    console.log("Google Location Finder JS");



$.fn.googleLocationFinder = function() {


	var element = this;
	var id = this.attr('data-id');
	var map;
	var dropedMarker, dropedInfo;
	var currentname, geocoder;
	var inputName = id+"-pac-input";
	var mapElement = document.getElementById(this.attr('id'));

	element.width('100%');
	element.height('300px');

	// ------------------------------------------------------------------------
	function positionFromInput(input) {

		var latlng = null;
		
		if(typeof input == 'string' || input instanceof String) {
			var latlngStr = input.split(',', 2);
			var lat = parseFloat(latlngStr[0]);
		 	var lng = parseFloat(latlngStr[1]);
		  	var latlng = new google.maps.LatLng(lat, lng);
		}
		else {
			latlng = input;
		}

		return latlng;
	}


	// ------------------------------------------------------------------------
	function setMapPosition(options) {

		var input = options.input;
		var title = options.title!=undefined ? options.title : "";
		var isNewLocation = options.isNewLocation!=undefined ? options.isNewLocation : false;
		var centerMap = options.centerMap!=undefined ? options.centerMap : true;
		var showtitle = options.showtitle!=undefined ? options.showtitle : true;
		var pos = positionFromInput(input);	
				
		if(dropedMarker == null) {
			dropedMarker = new google.maps.Marker({	position: pos,
											    	map: map,
											    	draggable: true,
											    	animation: google.maps.Animation.DROP,
											    	title:title});

			// ---------------------------------
			google.maps.event.addListener(dropedMarker, 'click', function() {
				updateMarkerFromNewLocation(dropedMarker.getPosition().lat()+","+dropedMarker.getPosition().lng());
			});


			// ---------------------------------
			google.maps.event.addListener(dropedMarker, 'dragend', function() {
				
				geocoder.geocode({'latLng': dropedMarker.getPosition()}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						
						setMapPosition({input:dropedMarker.getPosition(), 
										title:results[0].formatted_address, 
										isNewLocation:true,
										centerMap:false});

						$("#"+inputName).val('');
					} 
					else {
						console.log('Geocoder failed due to: ' + status);
					}
				});

			});


		}
		else {
			dropedMarker.setTitle(title);
			dropedMarker.setPosition(pos);
		}


		if(title) {
			if(dropedInfo==null) dropedInfo = new google.maps.InfoWindow();
			 var contentString =  '<div id="content" class="text-center">'+
							      '<div id="siteNotice">'+
							      '</div>'+
							      '<h6 id="firstHeading" class="firstHeading">'+title+'</h6>'+
							      '<div id="bodyContent">'+(isNewLocation ? '<p><a href="#update-location" class="btn btn-success" id="update-location-button">Set New Location</a></p>' : '')+
							      '</div>'+
							      '</div>';

			dropedInfo.setContent(contentString);
        	if(showtitle) dropedInfo.open(map, dropedMarker);

		}

		resizeMap(element.height());
		if(centerMap) map.setCenter(pos);

		

	}

	// ------------------------------------------------------------------------
	function setInfoContent(options) {
		var contentString = '<div>'+
							(options.title!=undefined?options.title:'no name')+
							'</div>';

		dropedInfo.setContent(contentString);
    	dropedInfo.open(map, dropedMarker);
	}

	// ------------------------------------------------------------------------
	function updateMarkerFromNewLocation(input) {	
		
		var latlng;
		if(typeof input == 'string') {
			var latlngStr = input.split(',', 2);
			var lat = parseFloat(latlngStr[0]);
		 	var lng = parseFloat(latlngStr[1]);
		  	var latlng = new google.maps.LatLng(lat, lng);
		}
		else {
			latlng = input;
		}
		
		geocoder.geocode({'latLng': latlng}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				dropedInfo.setContent(results[0].formatted_address);
          		dropedInfo.open(map, dropedMarker);
			} 
			else {
				console.log('Geocoder failed due to: ' + status);
			}
		});
	}

	// ------------------------------------------------------------------------
	function initialize() {

		var currentLocation = element.attr('data-location');
		currentname	    	= element.attr('data-name');

		geocoder = new google.maps.Geocoder();
		map = new google.maps.Map(document.getElementById(id), {zoom:6});

		// --------------------------------------
		if(currentLocation && currentLocation!='') {
			console.log("Setting from Location");
			setMapPosition({input:currentLocation, 
							title:currentname, 
							isNewLocation:false, 
							showtitle:true,
							centerMap:true});

			setupMap();
		}

		// try and geo-locate
		else {
			console.log("Try to Geo Locate");
  			if(navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {
					var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
					console.log("Found Pos"+pos);
					setMapPosition({input:pos, 
									title:"Local", 
									isNewLocation:false, 
									centerMap:true,
									showtitle:false});
					setupMap();

			    }, function() {
					handleNoGeolocation(true);
			    });
			} 
			else {
			    handleNoGeolocation(false);
			}
		}
	}



	// ------------------------------------------------------------------------
    function resizeMap(h) {
		$("#"+id).height(h);
		element.height(h);
		google.maps.event.trigger(map, 'resize');
    }

	

	
	// ------------------------------------------------------------------------
	function handleNoGeolocation(errorFlag) {
	  	var options = {
	    	map: map,
	    	position: new google.maps.LatLng(60, 105),
		};
		map.setCenter(options.position);
	}


	// ------------------------------------------------------------------------
	function setupMap() {

		// --------------------------------------
		// Right Click on the map
		// --------------------------------------
		google.maps.event.addListener(map, "rightclick", function(event) {
		    var lat = event.latLng.lat();
		    var lng = event.latLng.lng();
		    var pos = new google.maps.LatLng(lat, lng);
			setMapPositionFromString(lat+","+lng);
			updateMarkerFromNewLocation(lat+","+lng);
		});


		
		// --------------------------------------
		// Create the search box and link it to the UI element.
		// --------------------------------------
		var input = document.getElementById(inputName);
	  	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
	  	var searchBox = new google.maps.places.SearchBox(input);

	  	// Listen for the event fired when the user selects an item from the
		// pick list. Retrieve the matching places for that item.
		google.maps.event.addListener(searchBox, 'places_changed', function() {
			
			var places = searchBox.getPlaces();
			if (places.length == 0) return;
		    
		    var place = places[0];
			console.log(place);
				setMapPosition({input:place.geometry.location, title:place.formatted_address, isNewLocation:true});

		    var bounds = new google.maps.LatLngBounds();
			bounds.extend(place.geometry.location);
			map.fitBounds(bounds);

		  });

		

		// --------------------------------------
		$("body").delegate("#update-location-button", "click", function() {
			$(this).hide();
			$("#location_lat").attr('value', dropedMarker.getPosition().lat());
			$("#location_lng").attr('value', dropedMarker.getPosition().lng());
			$("#location_name").attr('value', dropedMarker.getTitle());
			setInfoContent({title:dropedMarker.getTitle()});
			return false;
		});

		// grabber
		var mapContainer = $("#"+id+"-location-finder");
		var startingH = mapContainer.height();
		
	    $( "#"+id+"-location-finder" ).resizable({
		    	minHeight:300,
	    		handle: {'s':"#"+id+"-grabber"},
		    	resize:function(event, ui) {
		    		resizeMap(ui.size.height);
		    	}
	    });

		// --------------------------------------
		// Fade the map in
		// --------------------------------------
		$("#"+id+"-location-finder").delay(1000).fadeTo(200,1);

	}

	initialize();	

	
	
};
	

	

</script> 
