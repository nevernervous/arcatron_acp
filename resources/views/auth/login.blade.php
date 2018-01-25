@extends('layouts.app')

@section('content')
  <div class="login-container bg-slate-800">
    <!-- Page container -->
    <div class="page-container">

      <!-- Page content -->
      <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

          <!-- Content area -->
          <div class="content pb-20">

            <!-- Form with validation -->
            <form class="form-validate" method="POST" action="{{ route('login') }}">
              {{ csrf_field() }}
              <div class="panel panel-body login-form">
                <div class="text-center">
                  <div class="icon-object border-slate-300 text-slate-300"><i
                      class="icon-reading"></i></div>
                  <h5 class="content-group">Login to your account
                    <small class="display-block">Your credentials</small>
                  </h5>
                </div>

                <div class="form-group has-feedback has-feedback-left">
                  <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required="required" autofocus>
                  <div class="form-control-feedback">
                    <i class="icon-mail5 text-muted"></i>
                  </div>
                  @if ($errors->has('email'))
                  <label id="email-error" class="validation-error-label" for="email">
                    {{ $errors->first('email') }}
                  </label>
                  @endif
                </div>

                <div class="form-group has-feedback has-feedback-left">
                  <input type="password" class="form-control" placeholder="Password" name="password" required="required">
                  <div class="form-control-feedback">
                    <i class="icon-lock2 text-muted"></i>
                  </div>
                  @if ($errors->has('password'))
                    <label id="password-error" class="validation-error-label" for="password">
                      {{ $errors->first('password') }}
                    </label>
                  @endif
                </div>

                <div class="form-group login-options">
                  <div class="row">
                    <div class="col-sm-6">
                      <label class="checkbox-inline">
                        <input type="checkbox" class="styled" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Remember Me
                      </label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <button type="submit" class="btn bg-blue btn-block">Login <i
                      class="icon-arrow-right14 position-right"></i></button>
                </div>
              </div>
            </form>
            <!-- /form with validation -->

          </div>
          <!-- /content area -->

        </div>
        <!-- /main content -->

      </div>
      <!-- /page content -->

    </div>
    <!-- /page container -->
  </div>


  {{--<div class="container">--}}
  {{--<div class="row">--}}
  {{--<div class="col-md-8 col-md-offset-2">--}}
  {{--<div class="panel panel-default">--}}
  {{--<div class="panel-heading">Login</div>--}}

  {{--<div class="panel-body">--}}
  {{--<form class="form-horizontal" method="POST" action="{{ route('login') }}">--}}
  {{--{{ csrf_field() }}--}}

  {{--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">--}}
  {{--<label for="email" class="col-md-4 control-label">E-Mail Address</label>--}}

  {{--<div class="col-md-6">--}}
  {{--<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>--}}

  {{--@if ($errors->has('email'))--}}
  {{--<span class="help-block">--}}
  {{--<strong>{{ $errors->first('email') }}</strong>--}}
  {{--</span>--}}
  {{--@endif--}}
  {{--</div>--}}
  {{--</div>--}}

  {{--<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">--}}
  {{--<label for="password" class="col-md-4 control-label">Password</label>--}}

  {{--<div class="col-md-6">--}}
  {{--<input id="password" type="password" class="form-control" name="password" required>--}}

  {{--@if ($errors->has('password'))--}}
  {{--<span class="help-block">--}}
  {{--<strong>{{ $errors->first('password') }}</strong>--}}
  {{--</span>--}}
  {{--@endif--}}
  {{--</div>--}}
  {{--</div>--}}

  {{--<div class="form-group">--}}
  {{--<div class="col-md-6 col-md-offset-4">--}}
  {{--<div class="checkbox">--}}
  {{--<label>--}}
  {{--<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me--}}
  {{--</label>--}}
  {{--</div>--}}
  {{--</div>--}}
  {{--</div>--}}

  {{--<div class="form-group">--}}
  {{--<div class="col-md-8 col-md-offset-4">--}}
  {{--<button type="submit" class="btn btn-primary">--}}
  {{--Login--}}
  {{--</button>--}}

  {{--<a class="btn btn-link" href="{{ route('password.request') }}">--}}
  {{--Forgot Your Password?--}}
  {{--</a>--}}
  {{--</div>--}}
  {{--</div>--}}
  {{--</form>--}}
  {{--</div>--}}
  {{--</div>--}}
  {{--</div>--}}
  {{--</div>--}}
  {{--</div>--}}
@endsection

@section('script')
  <script src="{{ asset('assets/js/plugins/forms/validation/validate.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
  <script src="{{ asset('assets/js/pages/login_validation.js') }}"></script>
@endsection