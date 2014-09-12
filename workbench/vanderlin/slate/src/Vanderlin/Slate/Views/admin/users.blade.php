
  <h1 class="page-header">Users</h1>
  <div class="table-responsive">
    <table class="table table-striped">
    
      <thead>
        <tr>
          <th>#</th>
          <th>Username</th>
          <th>Email</th>
          <th></th>
        </tr>
      </thead>

      <tbody>
        @foreach (User::all() as $user)
          
          <tr>
            <td><img src="{{ $user->profileImage->url('s30') }}" class="img-circle"></td>
            <td>{{ $user->id }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ link_to('mailto:'.$user->email, $user->email, ['target'=>'_blank'])}}</td>
            <td>{{ link_to('admin/user/'.$user->id, 'Edit')}}</td>
          </tr>

        @endforeach
      </tbody>
    </table>
  </div>
