@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'User Profile',
    'activePage' => 'profile',
    'activeNav' => '',
])

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="title">{{__(" Edit Profile")}}</h5>
          </div>
          <div class="card-body">
            <form method="post" action="{{ route('profile.update') }}" autocomplete="off"
            enctype="multipart/form-data">
              @csrf
              @method('put')
              @include('alerts.success')
                <div class="row">
                    <div class="col-md-6 pr-1">
                        <div class="form-group">
                            <label>{{__(" Name")}}</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
   
                        <div class="form-group">
                          <label for="exampleInputEmail1">{{__(" Email address")}}</label>
                          <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email', auth()->user()->email) }}">
                          @include('alerts.feedback', ['field' => 'email'])
                        </div>
                        
                        @if( auth()->user()->level === 3)
                        <div class="form-group">
                            <label>{{__(" Adkernal Username")}}</label>
                            <input type="text" name="adkernal_l" placeholder="Adkernal Login" class="form-control" value="{{ old('adkernal_l', auth()->user()->adkernal_l) }}">
                            @include('alerts.feedback', ['field' => 'adkernal_l'])
                        </div>
   
                        <div class="form-group">
                            <label>{{__(" Adkernal Password")}}</label>
                            <input type="text" name="adkernal_p" class="form-control" placeholder="Adkernal Password" value="{{ old('adkernal_p', auth()->user()->adkernal_p) }}">
                            @include('alerts.feedback', ['field' => 'adkernal_p'])
                        </div>

                        <div class="form-group">
                            <label>{{__(" Remote Feed ID")}}</label>
                            <input type="text" name="remotefeed_id" class="form-control" placeholder="Remote Feed ID" value="{{ old('remotefeed_id', auth()->user()->remotefeed_id) }}">
                            @include('alerts.feedback', ['field' => 'remotefeed_id'])
                        </div>

                        <div class="form-group">
                            <label>{{__(" Advertiser ID")}}</label>
                            <input type="text" name="advertiser_id" class="form-control" placeholder="Advertiser ID" value="{{ old('advertiser_id', auth()->user()->advertiser_id) }}">
                            @include('alerts.feedback', ['field' => 'advertiser_id'])
                        </div>
                        @endif
                  </div>
                </div>
                <div class="row">
                  <div class="card-footer ">
                    <button type="submit" class="btn btn-primary btn-round">{{__('Save')}}</button>
                  </div>
                  <hr class="half-rule"/>
                </div>
            </form>
          </div>
          <div class="card-header">
            <h5 class="title">{{__("Password")}}</h5>
          </div>
          <div class="card-body">
            <form method="post" action="{{ route('profile.password') }}" autocomplete="off">
              @csrf
              @method('put')
              @include('alerts.success', ['key' => 'password_status'])
              <div class="row">
                <div class="col-md-7 pr-1">
                  <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                    <label>{{__(" Current Password")}}</label>
                    <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="old_password" placeholder="{{ __('Current Password') }}" type="password"  required>
                    @include('alerts.feedback', ['field' => 'old_password'])
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-7 pr-1">
                  <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                    <label>{{__(" New password")}}</label>
                    <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('New Password') }}" type="password" name="password" required>
                    @include('alerts.feedback', ['field' => 'password'])
                  </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-7 pr-1">
                <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                  <label>{{__(" Confirm New Password")}}</label>
                  <input class="form-control" placeholder="{{ __('Confirm New Password') }}" type="password" name="password_confirmation" required>
                </div>
              </div>
            </div>
            <div class="card-footer ">
              <button type="submit" class="btn btn-primary btn-round ">{{__('Change Password')}}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    </div>
  </div>
@endsection