@if (Session::get('error'))
    <div class="alert alert-error alert-danger">
        @if (is_array(Session::get('error')))
            {{ head(Session::get('error')) }}
    	@else 
		{{ Session::get('error') }}
        @endif
    </div>

@endif

@if (Session::get('notice'))
    <div class="alert">{{ Session::get('notice') }}</div>
@endif
