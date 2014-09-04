







// ------------------------------------------------------------------------
/*
$('#create-experience').on('submit', function(e) {
    e.preventDefault(); // prevent native submit
    
    $(this).ajaxSubmit({
    	dataType:'json',
   		beforeSubmit:function() {
      	},
      	success: function(responseText, statusText, xhr, form) {
      		
          console.log(responseText);

          if(responseText.errors != null) {
      			var errors = "";
      			for (var i = 0; i < responseText.errors.length; i++) {
      				 errors += responseText.errors[i] + "<br>";
      			};
      			console.log(errors);
      			$("#experience-errors").html(errors);
      		}

      		else {
      			
            var experience = responseText.experience;
    				$("#experience-title h4").html(experience.title);
    				$("#experience-title h4").addClass('text-center');
    				$("#experience-errors").html('');

    				$(".experience_id").attr('value', experience.id);

    				$("#experience-map").html('<img class="img-responsive" src="http://maps.googleapis.com/maps/api/staticmap?center='+experience.location+'&zoom=13&size=500x200">');
    				$("#experience-map").show();


    				var address = experience.location;
    				var geocoder = new google.maps.Geocoder();
    				geocoder.geocode( { 'address': address}, function(results, status) {
    					if (status == google.maps.GeocoderStatus.OK) {
    				      
    				      var formatted_address = results[0].formatted_address;

    				      $("#experience-location").attr('value', formatted_address);
    				      console.log(results);
    				     
    				    } 
    				    else {
    						alert('Geocode was not successful for the following reason: ' + status);
    				    }
    				});

    				$("#inspiration-panel").show();


      		}

      	}  
    })
});*/

// ------------------------------------------------------------------------

