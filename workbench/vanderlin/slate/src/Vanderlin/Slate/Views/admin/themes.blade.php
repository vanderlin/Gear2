



















<!-- Modal -->
<div class="modal fade" id="theme-head-code" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      

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
        <?php $active_theme = Config::get('slate::active-bootstrap-theme') ?>
        <?php $themes = File::directories(public_path().'/assets/themes') ?>
        @foreach ($themes as $theme)

          <?php 
            $name  = substr($theme, strripos($theme, '/')+1);
            $theme = ucfirst( $name );

            $is_installed = false;
            $installed_theme = null;

            foreach ($installed_themes as $it) {
              if($it->name == $name) {
                $is_installed = true;
                $installed_theme = $it;
                break;
              } 
            }
          ?>
          <tr>


            <td>{{ $theme }}</td>
            <td>{{ $is_installed ? link_to("admin/themes/{$installed_theme->id}/edit?modal=true", 'Edit', ['data-toggle'=>'modal', 'data-target'=>'#theme-head-code']) : '' }}</td>
            @if ($is_installed)
              <td>{{ link_to("admin/themes/{$installed_theme->id}?activate=".($installed_theme->active?'false':'true'), $installed_theme->active?'Deactivate':'Activate', ['class'=>'btn '.($installed_theme->active?'btn-success':'btn-default').' pull-right']) }}</td>
            @else
              <td>{{ link_to("admin/themes/{$name}/install", 'Install', ['class'=>'btn btn-default pull-right']) }}</td>
            @endif
          </tr>

        @endforeach
      </form>
    </tbody>
  </table>
</div>
