
<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">

        @if (Auth::user()->hasRole("Admin"))
            <li class="active"><a href="/admin/users">Users</a></li>    
            <li><a href="/admin/roles#roles">Roles &amp; Permissions</a></li>     
        @endif
    
    </ul>
</div>