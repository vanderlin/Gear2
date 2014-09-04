


<div id="{{{ $id }}}-location"
 	 data-id="{{{ $id }}}"
	 data-location="{{ (isset($object)&&$object->location!=NULL) ? $object->location->latlngString() : '' }}" 
	 data-name="{{ (isset($object)&&$object->location!=NULL) ? $object->location->name : ''}}" 
	 data-title="{{ isset($object) ? $object->title : ''}}" class="location">

	<div id="{{{ $id }}}"></div>
</div>
<div class="grabber" id="{{{ $id }}}-grabber">
</div>
