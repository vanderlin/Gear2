
{{Form::open(array('url' => 'assets/upload', 'files' => true, 'method'=>'POST'))}}

@if (Input::has('id') && Input::has('type'))
	<input type="hidden" name="id" value="{{Input::get('id')}}">
	<input type="hidden" name="type" value="{{Input::get('type')}}">
@endif

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Upload Asset</h4>
	</div>

	<div class="modal-body">

				<fieldset>
				
					<div class="form-group">
						<label for="name">Name</label>
						<input class="form-control" tabindex="1" placeholder="Optional name" type="text" name="name" id="name" value="{{{ Input::old('name') }}}">
					</div>

					<div class="form-group">
						<label for="file">File</label>
						<br>
						<div class="btn btn-default btn-file"> Browse <input type="file" name="file"> </div>
					</div>

				</fieldset>


		

	</div>

	

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button tabindex="3" type="submit" class="btn btn-primary">Upload</button>
	</div>
	
{{Form::close()}}