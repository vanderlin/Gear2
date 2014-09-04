









<div id="{{{ $id }}}-location-finder" 
	 data-id="{{{ $id }}}" class="location-finder" 
	 data-location="{{ (isset($object) && $object->hasLocation()) ? $object->location->latlngString() : '' }}" 
	 data-name="{{ (isset($object) && $object->hasLocation()) ? $object->location->name : ''}}">
  
  <input id="{{ $id }}-pac-input" class="pac-input controls" type="text" placeholder="Search For Location">

  <div id="{{{ $id }}}"></div>
  </div>
  
  <div class="grabber" id="{{{ $id }}}-grabber">
</div>
