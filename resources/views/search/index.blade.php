@extends('layouts.app')

@section('content')
  <div class="page-header">
    <div class="page-header-content">
      <div class="page-title">
        <h4>
          <i class="icon-search4 position-left"></i>
          <span class="text-semibold">Search</span>
        </h4>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="row">
      <form method="POST" action="{{ route('postSearch') }}">
        {{ csrf_field() }}
        <div class="row">
          @if (Auth::user()->hasRole('admin'))
          <div class="col-md-2">
            <div class="form-group">
              <label>Customer Name</label>
              <input type="text" class="form-control" placeholder="E.g: John" name="cf" value="{{ $cf or '' }}">
            </div>
          </div>
          @endif
          <div class="col-md-2">
            <div class="form-group">
              <label >Device Name</label>
              <input type="text" class="form-control" placeholder="E.g: NVR" name="dn" value="{{ $dn or '' }}">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label class="control-label animate">Department Name</label>
              <input type="text" class="form-control" placeholder="E.g: Scuola E.Fermi Palestra" name="dtn" value="{{ $dtn or '' }}">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label animate">Critical Level</label>
              <select data-placeholder="Select a State..." class="select-clear" name="cl">
                <option></option>
                <option value="1" {{$cl === '1' ? 'selected': ''}}>1</option>
                <option value="2" {{$cl === '2' ? 'selected': ''}}>2</option>
                <option value="3" {{$cl === '3' ? 'selected': ''}}>3</option>
                <option value="3" {{$cl === '4' ? 'selected': ''}}>4</option>
                <option value="3" {{$cl === '5' ? 'selected': ''}}>5</option>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label>Alarm State</label>
              <select data-placeholder="Select a Level..." class="select-clear" name="as">
                <option></option>
                <option value="0" {{$as === '0' ? 'selected': ''}}>ONLINE</option>
                <option value="1" {{$as === '1' ? 'selected': ''}}>OFFLINE</option>
                <option value="2" {{$as === '2' ? 'selected': ''}}>PACKET LOSS</option>
              </select>
            </div>
          </div>
          <div class="col-md-1">
            <div class="form-group form-group-material">
              <label class="control-label animate">Search</label>
              <button type="submit" class="form-control btn btn-primary"><i class="icon-search4 text-size-base"></i></button>
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
              <th>Customer</th>
              <th>Department</th>
              <th>Device</th>
              <th>IP</th>
              <th>Time</th>
              <th>Critical Level</th>
              <th>Alarm State</th>
            </tr>
            </thead>
            <tbody>
              @foreach($statuses as $status)
                <tr id={{'status-'. $status->id}}>
                  <td>{{$status->customer->name}}</td>
                  <td>{{$status->department_name}}</td>
                  <td>{{$status->device_name}}</td>
                  <td>{{$status->device_ip}}</td>
                  <td>{{$status->date}}</td>
                  <td>{{$status->critical_level}}</td>
                  <td>{{$status->alarm_state == 0 ? 'ONLINE' : ($status->alarm_state == 1 ? 'OFFLINE' : 'PACKET LOSS')}}</td>
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
  {{--<script type="text/javascript" src="{{ asset('assets/js/pages/form_select2.js') }}"></script>--}}
  <script type="text/javascript" src="{{ asset('js/pages/search.js') }}"></script>
@endsection