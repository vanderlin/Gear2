<form method="POST" class="form-horizontal" role="form" action="{{{ URL::to('admin/themes/'.$theme->id) }}}" accept-charset="UTF-8">
<input type="hidden" value="PUT" name="_method">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">{{{ ucfirst($theme->name) }}}</h4>
		<small class="text-muted modal-title" id="myModalLabel">{{{ ucfirst($theme->path) }}}</small>
	</div>

	<div class="modal-body">
		<textarea name='code' class="theme-code-textarea form-control" rows="5">{{{$theme->code}}}</textarea>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Save changes</button>
	</div>
	
</form>