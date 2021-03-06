<!-- Main navbar -->
<div class="navbar navbar-default header-highlight" style="background: transparent; border: 0">
  <div class="navbar-header">
    <a class="navbar-brand" href="{{ route('showLive') }}">
      <img src="{{ asset('images/logo_white.png') }}" alt="">
      <span>Advanced Control Panel</span>
    </a>

    <ul class="nav navbar-nav visible-xs-block">
      <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
      <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
    </ul>
  </div>

  {{--<div class="navbar-collapse collapse" id="navbar-mobile">--}}
    {{--<ul class="nav navbar-nav">--}}
          {{--<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>--}}
    {{--</ul>--}}

    {{--<ul class="nav navbar-nav navbar-right">--}}
      {{--<li class="dropdown dropdown-user">--}}
        {{--<a class="dropdown-toggle" data-toggle="dropdown">--}}
          {{--<img src="{{ asset('images/user.png') }}" alt="">--}}
          {{--<span>{{ Auth::user()->name }}</span>--}}
          {{--<i class="caret"></i>--}}
        {{--</a>--}}

        {{--<ul class="dropdown-menu dropdown-menu-right">--}}
          {{--<li><a href="{{ route('showProfile') }}"><i class="icon-user"></i>Profile</a></li>--}}
          {{--<li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="icon-switch2"></i> Logout</a></li>--}}
        {{--</ul>--}}
      {{--</li>--}}
    {{--</ul>--}}
  {{--</div>--}}
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
  {{ csrf_field() }}
  </form>
</div>
<!-- /main navbar -->