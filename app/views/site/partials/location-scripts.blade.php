<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
       	
<script type="text/javascript">

console.log("Google Location Map JS");

$.fn.googleLocation = function() {

	var element = this;
	var id = this.attr('data-id');
	var map;
	
	element.width('100%');
	element.height('300px');
	

	// ------------------------------------------------------------------------
	function positionFromInput(input) {
		var latlng;
		if(typeof new String(input)) {
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
    function resizeMap(h) {
		$("#"+id).height(h);
		element.height(h);
		google.maps.event.trigger(map, 'resize');
    }


	// ------------------------------------------------------------------------
	function initialize() {

		var currentLocation = element.attr('data-location');
		var locationName	= element.attr('data-name');
		var title		    = element.attr('data-title');
		console.log(currentLocation);
		if(currentLocation == undefined || currentLocation == '') {
			$(element).html('<div class="text-center" style="padding-top:150px">No Location</div>');
			$("#"+id+"-location").delay(1000).fadeTo(200,1);
		}

		else {
			var pos 			= positionFromInput(currentLocation);

			map = new google.maps.Map(document.getElementById(id), {zoom:9});

			var marker = new google.maps.Marker({	position: pos,
											    	map: map,
											    	draggable: false,
											    	animation: google.maps.Animation.DROP,
											    	title:locationName});


			var info = new google.maps.InfoWindow();
			var contentString = '<div id="content" class="text-center">'+
								 	'<div id="siteNotice">'+
								    '</div>'+
								 
								    '<h5 id="firstHeading" class="firstHeading">'+title+'</h5>'+
								    '<div id="bodyContent">'+locationName+
									'</div>'+
								'</div>';

			// --------------------------------------
			// Fade the map in
			// --------------------------------------
			$("#"+id+"-location").delay(1000).fadeTo(200,1);

			
			// --------------------------------------
			// grabber
			// --------------------------------------
			var mapContainer = $("#"+id+"-location");
			var startingH = mapContainer.height();

		    $( "#"+id+"-location" ).resizable({
			    	minHeight:300,
		    		handle: {'s':"#"+id+"-grabber"},
			    	resize:function(event, ui) {
			    		resizeMap(ui.size.height);
			    	}
		    });


			info.setContent(contentString);
	    	info.open(map, marker);
			map.setCenter(pos);
			resizeMap(300);	
		}

	}

	initialize();
	
};
	

	

</script> 
