@extends('layouts.app')

@section('content')
  <div class="page-header">
    <div class="page-header-content">
      <div class="page-title">
        <h4>
          <i class="icon-users position-left"></i>
          <span class="text-semibold">Users</span>
        </h4>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="row">
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_new_user_mdal"><i class="icon-user-plus position-left"></i> Add New User</button>
    </div>
    <br>
    <div class="row">
      <div class="panel panel-white">
        <div class="panel-body">
          <table class="table table-striped" id="datatable-users">
            <thead>
            <tr>
              <th>User Name</th>
              <th>Email</th>
              <th>Group</th>
              <th>Created Date</th>
              <th class="text-center">Actions</th>
            </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>

    <div id="add_new_user_mdal" class="modal fade">
      <div class="modal-dialog">
        <form class="form-validate" action="{{ route('postAddUser') }}" method="post">
          {{ csrf_field() }}
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h6 class="modal-title">Add New User</h6>
            </div>

            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback has-feedback-left">
                    <input type="text" class="form-control" placeholder="User Name" name="username" required autofocus>
                    <div class="form-control-feedback">
                      <i class="icon-user-plus text-muted"></i>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group has-feedback has-feedback-left">
                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                    <div class="form-control-feedback">
                      <i class="icon-mail5 text-muted"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback has-feedback-left">
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                    <div class="form-control-feedback">
                      <i class="icon-user-lock text-muted"></i>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group has-feedback has-feedback-left">
                    <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirm" required>
                    <div class="form-control-feedback">
                      <i class="icon-user-lock text-muted"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="display-block">User Type:</label>

                <label class="radio-inline">
                  <input type="radio" class="styled" name="role" >
                  Admin
                </label>

                <label class="radio-inline">
                  <input type="radio" class="styled" name="role" checked="checked">
                  Operator
                </label>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Add</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/forms/validation/validate.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
  <script src="{{ asset('assets/js/pages/form_layouts.js') }}"></script>
  <script src="{{ asset('js/pages/users.js') }}"></script>

@endsection