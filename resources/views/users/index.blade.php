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
      <button type="button" class="btn btn-primary"><i class="icon-user-plus position-left"></i> Add New User</button>
    </div>
    <br>
    <div class="row">
      <div class="panel panel-white">
        <div class="panel-body">
          <table class="table datatable-users">
            <thead>
            <tr>
              <th>User name</th>
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
  </div>
@endsection

@section('script')
  <script type="text/javascript" src="{{ asset('assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/plugins/forms/selects/select2.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/pages/users.js') }}"></script>
@endsection