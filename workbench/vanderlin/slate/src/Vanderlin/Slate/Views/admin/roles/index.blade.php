<h1 class="page-header">Roles &amp; Permissions</h1>
<div class="col-md-6">
  
    <h3>Roles</h3>
    <div class="row">
    @foreach (Role::all() as $role)
      <div class="panel panel-default">
        <div class="panel-heading">{{ $role->name }}</div>
        <div class="panel-body">

          <form method="POST" class="form-horizontal" role="form" action="{{{ URL::to('admin/roles/'.$role->id) }}}" accept-charset="UTF-8">
            
            <input type="hidden" value="PUT" name="_method">

            @include('slate::admin.partials.permissions', ['role'=>$role])
            
            <div class="form-group row">
              <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default pull-right">Update</button>
              </div>
            </div>

          </form>
          
        </div>
      </div>
    @endforeach
  </div>

  <h3>Add New Role</h3>
  <div class="well row">
    @include('slate::admin.roles.form')
  </div>


  <h3>Add New Permission</h3>
  <div class="well row">
    @include('slate::admin.permissions.form')
  </div>


</div>
