<!-- Main sidebar -->
<div class="sidebar sidebar-main">
  <div class="sidebar-content">
    <!-- User menu -->
    <div class="sidebar-user">
      <div class="category-content">
        <div class="media">
          <a href="{{ route('showProfile') }}" class="media-left"><img src="{{ asset(Auth::user()->avatar) }}" class="img-circle img-sm" alt=""></a>
          <div class="media-body">
            <span class="media-heading text-semibold">{{ Auth::user()->name }}</span>
            <div class="text-size-mini text-muted">
              <i class="icon-mail5 text-size-small"></i> &nbsp;{{ Auth::user()->email }}
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /user menu -->

    <!-- Main navigation -->
    <div class="sidebar-category sidebar-category-visible">
      <div class="category-content no-padding">
        <ul class="navigation navigation-main navigation-accordion">
          <li class="navigation-header">
            <span>Menu</span>
            <i class="icon-menu" title="Main pages"></i>
          </li>

          @if ( Auth::user()->live_access )
          <li class="{{ Request::is('*live*') ? 'active' : '' }}">
            <a href="{{ route('showLive') }}"><i class="icon-home4"></i> Live</a>
          </li>
          @endif

          @if ( Auth::user()->search_access )
          <li class="{{ Request::is('*search*') ? 'active' : '' }}">
            <a href="{{ route('showSearch') }}"><i class="icon-search4"></i> Search</a>
          </li>
          @endif

          @if ( Auth::user()->logs_access )
          <li class="{{ Request::is('*logs*') ? 'active' : '' }}">
            <a href="{{ route('showLogs') }}"><i class="icon-file-text2"></i> Logs</a>
          </li>
          @endif

          <li class="{{ Request::is('*profile*') ? 'active' : '' }}">
            <a href="{{ route('showProfile') }}"><i class="icon-user"></i>Profile</a>
          </li>

          @role('admin')
          <li class="{{ Request::is('*users*') ? 'active' : '' }}">
            <a href="{{ route('showUsers') }}"><i class="icon-users"></i> Users</a>
          </li>
          @endrole

          <li>
            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="icon-switch2"></i>Logout</a>
          </li>
          <li id="min" style="margin-top: 50%">
            <div id="hour" class="time" style="text-align: center; font-size: 30px;"></div>
            <div id="minute" class="time" style="text-align: center; font-size: 30px;"></div>
            <div id="month" class="time" style="text-align: center;"></div>
            <div id="year" class="time" style="text-align: center;"></div>
          </li>
          <li id="full" class="time"></li>
          <li class="">
            <a class="collapse-icon sidebar-control sidebar-main-toggle hidden-xs"><i class="fa fa-angle-double-left"></i> <div>Collapse sidebar</div></a>
          </li>
          <li class="">
            <a class="uncollapse-icon sidebar-control sidebar-main-toggle hidden-xs"><i class="fa fa-angle-double-right"></i></a>
          </li>
        </ul>
      </div>
    </div>
    <!-- /main navigation -->

  </div>
</div>
<!-- /main sidebar -->