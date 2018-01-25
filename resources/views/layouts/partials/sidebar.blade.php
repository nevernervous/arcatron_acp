<!-- Main sidebar -->
<div class="sidebar sidebar-main">
  <div class="sidebar-content">
    <!-- User menu -->
    <div class="sidebar-user">
      <div class="category-content">
        <div class="media">
          <a href="#" class="media-left"><img src="{{ asset('images/user.png') }}" class="img-circle img-sm" alt=""></a>
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
          <li class="active">
            <a href="#"><i class="icon-home4"></i> <span>Live</span></a>
          </li>
          <li class="">
            <a href="#"><i class="icon-search4"></i> <span>Search</span></a>
          </li>
          <li class="">
            <a href="#"><i class="icon-users"></i> <span>Users</span></a>
          </li>
          <li class="">
            <a href="#"><i class="icon-file-text2"></i> <span>Logs</span></a>
          </li>
          <li class="">
            <a href="#"><i class="icon-switch2"></i> <span>Logout</span></a>
          </li>
        </ul>
      </div>
    </div>
    <!-- /main navigation -->

  </div>
</div>
<!-- /main sidebar -->