@foreach (Role::all() as $role)
  <div class="checkbox">
    <label>
      <input type="checkbox" value="" name="roles[{{$role->id}}]" {{ (isset($user)&&$user->hasRole($role->name))?'checked':''}}>
      {{ $role->name }}
      </label>
  </div>
@endforeach

    


    