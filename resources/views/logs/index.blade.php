@extends('layouts.app')

@section('content')
  <div class="page-header">
    <div class="page-header-content">
      <div class="page-title">
        <h4>
          <i class="icon-home4 position-left"></i>
          <span class="text-file-text2">Logs</span>
        </h4>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="row">
      <div class="panel panel-white">
        <div class="panel-body">
          <table class="table" id="datatable-logs">
            <thead>
            <tr>
              <th>User Name</th>
              <th>Action</th>
              <th>Description</th>
              <th>IP</th>
              <th>Time</th>
            </tr>
            </thead>
            <tbody>
              @foreach($logs as $log)
                <tr>
                  <td>{{$log->user->name}}</td>
                  <td>{{$log->action}}</td>
                  <td>{{$log->description}}</td>
                  <td>{{$log->ip}}</td>
                  <td>{{$log->created_at}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script type="text/javascript" src="{{ asset('assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/plugins/forms/selects/select2.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/pages/logs.js') }}"></script>
@endsection
