@extends('layouts.app')

@section('content')
  <div class="page-header">
    <div class="page-header-content">
      <div class="page-title">
        <h4>
          <i class="icon-home4 position-left"></i>
          <span class="text-semibold">Live</span>
        </h4>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="row">
      <div class="panel panel-white">
        <div class="panel-body">
          <table class="table" id="datatable-statuses">
            <thead>
            <tr>
              <th>Customer Name</th>
              <th>Device</th>
              <th>Device IP</th>
              <th>Department</th>
              <th>Time</th>
              <th>Critical Level</th>
              <th>Alarm State</th>
              <th>ACK</th>
            </tr>
            </thead>
          </table>
          {{--<div class="text-center">--}}
            {{--<button type="button" id="btn-show-less" class="btn btn-info collapse" onclick="showLess()">--}}
              {{--Show Less--}}
            {{--</button>--}}
            {{--<button type="button" class="btn btn-success" onclick="showMore()">--}}
              {{--Show More--}}
            {{--</button>--}}
          {{--</div>--}}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script type="text/javascript" src="{{ asset('assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/plugins/forms/selects/select2.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/pages/live.js') }}"></script>
@endsection