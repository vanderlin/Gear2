
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



<h1 class="page-header">Themes</h1>
<div class="table-responsive">
  <table class="table table-striped">
  
    <thead>
      <tr>
        <th>Name</th>
        <th>Head Code</th>
        <th></th>
      </tr>
    </thead>

    <tbody>
      <form>
        <?php $installed_themes = Theme::all() ?>
        <?php $active_theme = Config::get('config.active-bootstrap-theme') ?>
        <?php $themes = File::directories('assets/themes') ?>
        @foreach ($themes as $theme)

          <?php 
            $name  = substr($theme, strripos($theme, '/')+1);
            $theme = ucfirst( $name );
            $is_active = strtolower($name) == strtolower($active_theme);
            $on_off = $is_active ? 'false' : 'true';
            $is_installed = false;
            foreach ($installed_themes as $installed_theme) {
              if($installed_theme->name == $name) {
                $is_installed = true;
                break;
              } 
            }
          ?>
          <tr>


            <td>{{ $theme }}</td>
            <td>{{ link_to('#edit-head-code', 'Edit', ['data-toggle'=>'modal', 'data-target'=>'#myModal']) }}</td>
            @if ($is_installed)
              <td>{{ link_to("admin/themes/{$name}?activate={$on_off}", $is_active?'Deactivate':'Activate', ['class'=>'btn '.($is_active?'btn-success':'btn-default').' pull-right']) }}</td>
            @else
              <td>{{ link_to("admin/themes/{$name}?install=true", 'Install', ['class'=>'btn btn-default pull-right']) }}</td>
            @endif
          </tr>

        @endforeach
      </form>
    </tbody>
  </table>
</div>
