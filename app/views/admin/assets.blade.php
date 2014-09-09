
  <h1 class="page-header">Assets</h1>
  <div class="table-responsive">
    <table class="table table-striped">
    
      <thead>
        <tr>
          <th>#</th>
          <th>Filename</th>
          <th>Path</th>
          <th></th>
        </tr>
      </thead>

      <tbody>
        @foreach (Asset::all() as $asset)
          
          <tr>
            <td>{{ $asset->id }}</td>
            <td>{{ $asset->filename }}</td>
            <td>{{ $asset->path }}</td>
            <td>{{ link_to('/', 'View', ['class'=>'pull-right']) }}</td>
          </tr>

        @endforeach
      </tbody>
    </table>
  </div>
