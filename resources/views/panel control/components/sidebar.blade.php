<div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html">OMDB dzaki</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">OZ</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">{{ __('messages.PAGES') }}</li>
            <li class="dropdown active">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-film"></i><span>{{ __('messages.Movies') }}</span></a>
              <ul class="dropdown-menu">
                <li  class="{{ Route::is('dashboard*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/dashboard') }}">{{ __('messages.Search Movies') }}</a></li>
                <li  class="{{ Route::is('favorit*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/favorit')}}">{{ __('messages.My Favorites') }}</a></li>
              </ul>
            </li>
    