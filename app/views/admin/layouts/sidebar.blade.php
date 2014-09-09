
<?php $page = isset($page)?$page:'settings'; ?>

<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">

        @if (Auth::user()->hasRole("Admin"))
            <li {{$page=='settings'?'class="active"':''}}><a href="/admin/settings">Settings</a></li>    
            <li {{$page=='users'?'class="active"':''}}><a href="/admin/users">Users</a></li>    
            <li {{$page=='roles'?'class="active"':''}}><a href="/admin/roles#roles">Roles &amp; Permissions</a></li>     
			<li {{$page=='themes'?'class="active"':''}}><a href="/admin/themes">Bootstrap Themes</a></li>     
            <li {{$page=='assets'?'class="active"':''}}><a href="/admin/assets">Assets</a></li>     
        @endif
    
    </ul>
</div>