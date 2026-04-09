<div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html">OMDB dzaki</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">OZ</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">PAGES</li>
            <li class="dropdown active">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-film"></i><span>Movies</span></a>
              <ul class="dropdown-menu">
                <li  class=active><a class="nav-link" href="{{ url('/dashboard') }}">Search Movies</a></li>
                <li><a class="nav-link" href="{{ url('/favorit')}}">My Favorites</a></li>
              </ul>
            </li>
      </div class="main-content">
         @yield('content')

      </div>