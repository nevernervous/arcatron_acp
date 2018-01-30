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
        <form class="form-horizontal" action="#">
            <div class="form-group">
              <label class="control-label col-lg-2">User Name:</label>
              <div class="col-lg-10">
                <input type="text" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-lg-2">Email:</label>
              <div class="col-lg-10">
                <input type="email" class="form-control">
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
