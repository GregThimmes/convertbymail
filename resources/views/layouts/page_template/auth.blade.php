
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@if (auth()->user()->isAdmin())
	@include('layouts.navbars.navs.admin')
@else
	@include('layouts.navbars.navs.auth')
@endif

@yield('content')
@include('layouts.footer')
