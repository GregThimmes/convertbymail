@extends('layouts.app', [
    'namePage' => 'Edit Campaign Cretive',
    'class' => '',
    'activePage' => 'campaignCreative',
  ])

@section('content')

<div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Edit Campaign Creative {{ $campaign->name }}</h6>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid mt--6">
      
      <!-- Dark table -->
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
            </div>
            <div class="card-body">
              <div class="row">
                  <div class="col-md-6">
                    @if(Session::has('success'))
                      <div class="alert alert-success">
                          {{ Session::get('success') }}
                          @php
                              Session::forget('success');
                          @endphp
                      </div>
                      @endif
                  <form method="POST" action="{{ action('CampaignController@updateCreative') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$campaign->id}}"/>
                    <div class="form-group">
                      <label for="exampleFormControlTextarea1">Creative</label>
                      <textarea class="form-control" name="creative_o" id="creative-input" rows="10" required>{{$campaign->creative}}</textarea>
                    </div>
                    <div class="form-group">
                       <button type="submit" class="btn btn-success btn-submit">Update Campaign Creative</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
@endsection