@extends('layouts.app')

@section('content')
  <div class="page-header">
    <div class="page-header-content">
      <div class="page-title">
        <h4>
          <i class="icon-user position-left"></i>
          <span class="text-semibold">User Edit</span>
        </h4>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <div class="tabbable">
            <ul class="nav nav-tabs nav-tabs-bottom">
              <li class="active"><a href="#account-tab" data-toggle="tab">Account</a></li>
              <li><a href="#customer-tab" data-toggle="tab">Customer Assign</a></li>
              <li><a href="#page-tab" data-toggle="tab">Page Access</a></li>
            </ul>
          </div>

          <div class="tab-content">
            <div class="tab-pane active" id="account-tab">
              <form class="form-horizontal" id="profile_form" method="POST" action="{{ route('postUpdateProfile') }}">
                <div class="form-group">
                  <label class="control-label col-md-2">User Name:</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" name="username" disabled autofocus
                           value="{{ $user->name }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Email:</label>
                  <div class="col-md-10">
                    <input type="email" class="form-control" name="email" required autofocus
                           value="{{ $user->email }}">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-offset-2 col-md-10">
                    <button type="submit" class="btn btn-success">Update</button>
                  </div>
                </div>
              </form>
            </div>

            <div class="tab-pane" id="customer-tab">
              Customer tab
            </div>

            <div class="tab-pane" id="page-tab">
              Page Access
            </div>
          </div>
        </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('js/pages/users.js') }}"></script>
@endsection