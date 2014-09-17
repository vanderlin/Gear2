
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="permissions">Permission: {{{ ucfirst($permission->display_name) }}}</h4>
	</div>


	<div class="modal-body">


		{{ Form::open([ 'route'=>['admin.permissions.update',$permission->id], 
						'class'=>'form-horizontal',
						'role'=> 'form',
						'id'=>'permission-edit-form',
						'method'=>'PUT']) }}

	 	<div class="form-group">
          <label for="permision-name" class="col-sm-3 control-label">Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="name" id="permision-name" placeholder="ie: edit_posts" value="{{$permission->name}}">
          </div>
        </div>

        <div class="form-group">
          <label for="permision-display-name" class="col-sm-3 control-label">Display Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="display_name" id="permision-display-name" placeholder="ie: Edit Posts" value="{{$permission->display_name}}">
          </div>
        </div>
       {{ Form::close() }}

     	
     	{{ Form::open([ 'route'=>['admin.permissions.destroy',$permission->id], 
								'class'=>'form-inline',
								'role'=> 'form',
								'id'=>'permission-delete-form',
									'method'=>'DELETE']) }}
		{{ Form::close() }}

	</div>
	<div class="modal-footer">
		<button type="submit" form="permission-edit-form" class="btn btn-primary">Save changes</button>
		<button type="submit" form="permission-delete-form" class="btn btn-danger">Delete</button>
	</div>
	
