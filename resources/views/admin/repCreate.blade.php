@extends('layouts.app', [
    'namePage' => 'Create Sales Rep',
    'class' => '',
    'activePage' => 'repCreate',
  ])

@section('content')

<div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Create Sales Rep</h6>
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
                  <form method="POST" action="{{ action('UserController@repsStore') }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                      <label for="companyName">Name <span class="text-red">*</span></label>
                      <input type="text" class="form-control" name="name" id="name-field" required>
                    </div>

                    <div class="form-group">
                      <label for="repEmail">Email</label>
                      <input type="text" class="form-control" name="email" id="email-field">
                    </div>

                    <div class="form-group">
                       <button type="submit" class="btn btn-success btn-submit">Create Sales Rep</button>
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