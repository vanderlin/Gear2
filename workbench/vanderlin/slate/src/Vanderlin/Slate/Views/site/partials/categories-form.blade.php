<?php
	$categories = Category::all(); 
	$count = 0;
?>
@for ($i = 0; $i < sizeof($categories); $i++)
	<?php $category = $categories[$i]; ?>
	<?php 
		if($count == 0) {
			echo '<div class="col-md-4">';
		}
	?> 
		<div class="checkbox">
			<label><input type="checkbox" id="category-{{$category->id}}" value="{{$category->id}}" name="category[]" {{(isset($object)&&$object->hasCategory($category))?'checked':''}} > {{$category->name}}</label>   
    	</div>
	<?php
		$count ++;
		if($count == 4) {
			echo '</div>';
			$count = 0;
		} 
	?>
@endfor