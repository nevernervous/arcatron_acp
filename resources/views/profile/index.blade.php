@extends('layouts.app')

@section('content')
  <div class="page-header">
    <div class="page-header-content">
      <div class="page-title">
        <h4>
          <i class="icon-user position-left"></i>
          <span class="text-semibold">Profile</span>
        </h4>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h6 class="panel-title">Account</h6>
      </div>
      <div class="panel-body">
        <form class="form-horizontal ajax" method="POST" action="{{ route('postUpdateProfile') }}">
          <div class="form-group">
            <label class="control-label col-md-2">User Name:</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name="username" disabled value="{{ Auth::user()->name }}">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2">Email:</label>
            <div class="col-md-10">
              <input type="email" class="form-control" name="email" required value="{{ Auth::user()->email }}">
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
              <button type="submit" class="btn btn-success">Update</button>
              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#password_change_modal">Change Password</button>
            </div>

          </div>
        </form>
      </div>
    </div>

    <div id="password_change_modal" class="modal fade has-input">
      <div class="modal-dialog">
        <form class="form-validate ajax closeModalAfter" id="password_form" action="{{ route('postChangePassword') }}" method="post">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h6 class="modal-title">Change Password</h6>
            </div>

            <div class="modal-body">
              <div class="row">
                <div class="form-group has-feedback has-feedback-left">
                  <input type="password" class="form-control" placeholder="Old Password" name="old_password"
                         required>
                  <div class="form-control-feedback">
                    <i class="icon-lock2  text-muted"></i>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group has-feedback has-feedback-left">
                  <input type="password" id="password" class="form-control" placeholder="New Password" name="password"
                         required>
                  <div class="form-control-feedback">
                    <i class="icon-lock2  text-muted"></i>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group has-feedback has-feedback-left">
                  <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirm"
                         required>
                  <div class="form-control-feedback">
                    <i class="icon-lock2  text-muted"></i>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" id="close_add_new_user_modal" class="btn btn-link" data-dismiss="modal">Close
              </button>
              <button type="submit" class="btn btn-primary">Change</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('assets/js/plugins/forms/validation/validate.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/notifications/sweet_alert.min.js') }}"></script>
  <script src="{{ asset('js/pages/profile.js') }}"></script>
@endsection