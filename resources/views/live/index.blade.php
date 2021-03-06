@extends('layouts.app')

@section('content')
  {{--<div class="page-header">--}}
    {{--<div class="page-header-content">--}}
      {{--<div class="page-title">--}}
        {{--<h4>--}}
          {{--<i class="icon-home4 position-left"></i>--}}
          {{--<span class="text-semibold">Live</span>--}}
        {{--</h4>--}}
      {{--</div>--}}
    {{--</div>--}}
  {{--</div>--}}
  <div class="content {{ Auth::user()->ack_access ? 'ack_allowed' : '' }}" style="margin-top: -48px">
    <div class="row">
      <div class="panel panel-white live" style="margin-bottom: 10px">
        <div class="panel-heading">
          <h6 class="panel-title" style="display: inline">OFFLINE Devices</h6>
          <div style="margin-left: 20px; display: inline">
            <span style="margin-right: 10px">Today: <span id="offline_today" class="badge badge-primary">0</span></span>
            <span style="margin-right: 10px">Week: <span id="offline_week" class="badge badge-success">0</span></span>
            <span style="margin-right: 10px">Month: <span id="offline_month" class="badge badge-info">0</span></span>
          </div>
        </div>
        <div class="panel-body">
          <table class="table" id="datatable-offline" cellspacing="0" cellpadding="0" width="100%">
            <thead>
            <tr>
              <th>Customer</th>
              <th>Department</th>
              <th>Device</th>
              <th>IP</th>
              <th>Time</th>
              <th>Critical Level</th>
              <th>Alarm State</th>
              <th>Mute</th>
              @if (Auth::user()->ack_access)
              <th>ACK</th>
              @endif
            </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="panel panel-white live" style="margin-bottom: 10px">
        <div class="panel-heading" >
          <h6 class="panel-title" style="display: inline">PACKET LOSS Devices</h6>
          <div style="margin-left: 20px; display: inline">
            <span style="margin-right: 10px">Today: <span id="packet_today" class="badge badge-primary">0</span></span>
            <span style="margin-right: 10px">Week: <span id="packet_week" class="badge badge-success">0</span></span>
            <span style="margin-right: 10px">Month: <span id="packet_month" class="badge badge-info">0</span></span>
          </div>
        </div>
        <div class="panel-body">
          <table class="table" id="datatable-packet-loss" width="100%">
            <thead>
            <tr>
              <th>Customer</th>
              <th>Department</th>
              <th>Device</th>
              <th>IP</th>
              <th>Time</th>
              <th>Critical Level</th>
              <th>Alarm State</th>
              @if (Auth::user()->ack_access)
                <th>ACK</th>
              @endif
            </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="panel panel-white live" style="margin-bottom: 5px">
        <div class="panel-heading" >
            <h6 class="panel-title" style="display:inline;">ONLINE Devices</h6>
            <div style="margin-left: 20px; display: inline">
              <span style="margin-right: 10px">Today: <span id="online_today" class="badge badge-primary">0</span></span>
              <span style="margin-right: 10px">Week: <span id="online_week" class="badge badge-success">0</span></span>
              <span style="margin-right: 10px">Month: <span id="online_month" class="badge badge-info">0</span></span>
            </div>
        </div>
        <div class="panel-body">
          <table class="table" id="datatable-online" cellspacing="0" width="100%">
            <thead>
            <tr>
              <th>Customer</th>
              <th>Department</th>
              <th>Device</th>
              <th>IP</th>
              <th>Time</th>
              <th>Critical Level</th>
              <th>Alarm State</th>
              <th>Last State</th>
              <th>Last Time</th>
              @if (Auth::user()->ack_access)
                <th>ACK</th>
              @endif
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
  <audio id="beep" src="{{ asset('wav/beep.wav') }}" preload="auto"></audio>
@endsection

@section('script')
  <script type="text/javascript" src="{{ asset('assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/plugins/forms/selects/select2.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/pages/live.js') }}"></script>
@endsection