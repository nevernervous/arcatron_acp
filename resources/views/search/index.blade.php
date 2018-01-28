@extends('layouts.app')

@section('content')
  <div class="page-header">
    <div class="page-header-content">
      <div class="page-title">
        <h4>
          <i class="icon-home4 position-left"></i>
          <span class="text-search4">Search</span>
        </h4>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="row">
      <form method="GET" action="{{ route('showSearch') }}">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-md-2">
            <div class="form-group form-group-material">
              <label class="control-label animate">Customer Name</label>
              <input type="text" class="form-control" placeholder="Customer Name">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group form-group-material">
              <label class="control-label animate">Device Name</label>
              <input type="text" class="form-control" placeholder="Device Name">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group form-group-material">
              <label class="control-label animate">Department Name</label>
              <input type="text" class="form-control" placeholder="Department Name">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group form-group-material">
              <label class="control-label animate">Critical Level</label>
              <input type="text" class="form-control" placeholder="Critical Level">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group form-group-material">
              <label class="control-label animate">Alarm State</label>
              <input type="text" class="form-control" placeholder="Alarm State">
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="row">
      <div class="panel panel-white">
        <div class="panel-body">
          <table class="table" id="datatable-search">
            <thead>
            <tr>
              <th>Customer Name</th>
              <th>Device</th>
              <th>Device IP</th>
              <th>Department</th>
              <th>Time</th>
              <th>Critical Level</th>
              <th>Alarm State</th>
            </tr>
            </thead>
            <tbody>
              @foreach($statuses as $status)
                <tr id={{'status-'. $status->id}}>
                  <td>{{$status->customer->name}}</td>
                  <td>{{$status->device_name}}</td>
                  <td>{{$status->device_ip}}</td>
                  <td>{{$status->department_name}}</td>
                  <td>{{$status->date}}</td>
                  <td>{{$status->critical_level}}</td>
                  <td>{{$status->alarm_state}}</td>
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

  {{--<script type="text/javascript" src="{{ asset('assets/js/core/libraries/jasny_bootstrap.min.js') }}"></script>--}}
  {{--<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>--}}
  {{--<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/selects/bootstrap_select.min.js') }}"></script>--}}
  {{--<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/styling/uniform.min.js') }}"></script>--}}
  {{--<script type="text/javascript" src="{{ asset('assets/js/core/libraries/jquery_ui/core.min.js') }}"></script>--}}
  {{--<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/selects/selectboxit.min.js') }}"></script>--}}
  {{--<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js') }}"></script>--}}
  {{--<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/tags/tagsinput.min.js') }}"></script>--}}
  {{--<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/tags/tokenfield.min.js') }}"></script>--}}
  {{--<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/inputs/touchspin.min.js') }}"></script>--}}
  {{--<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/inputs/maxlength.min.js') }}"></script>--}}
  {{--<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/inputs/formatter.min.js') }}"></script>--}}

  <script type="text/javascript" src="{{ asset('js/pages/search.js') }}"></script>
@endsection