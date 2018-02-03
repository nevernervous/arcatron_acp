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
            </ul>
          </div>

          <div class="tab-content">
            <div class="tab-pane active" id="account-tab">
              <form class="form-horizontal ajax" method="POST" action="{{ route('postUpdateUser', $user->id) }}">
                <input type="hidden" name="type" value="account">
                <div class="form-group">
                  <label class="control-label col-md-2">User Name:</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" name="username" disabled value="{{ $user->name }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Email:</label>
                  <div class="col-md-10">
                    <input type="email" class="form-control" name="email" required value="{{ $user->email }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Page Access:</label>
                  <div class="col-md-10">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" class="styled" name="logs_page" {{ $user->logs_access ? 'checked' : ''  }}>
                        Logs Page
                      </label>
                    </div>
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
              <form class="form-horizontal ajax" method="POST" action="{{ route('postUpdateUser', $user->id) }}">
                <input type="hidden" name="type" value="customer">
                <div class="form-group">
                  <label class="control-label col-md-2">Assigned Customers:</label>
                  <div class="col-md-10">
                    <select data-placeholder="Select Customer" multiple="multiple" class="select" name="customers[]">
                      @foreach($customers as $customer)
                        <option value={{ $customer->id }} {{ in_array($customer->id, $assignedCustomers) ? 'selected' : '' }}>{{ $customer->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-offset-2 col-md-10">
                    <button type="submit" class="btn btn-success">Update</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
      @include('layouts.partials.footer')
  </div>
@endsection

@section('script')
  <script src="{{ asset('js/pages/users.js') }}"></script>
@endsection