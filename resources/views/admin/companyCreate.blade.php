@extends('layouts.app', [
    'namePage' => 'Create Company',
    'class' => '',
    'activePage' => 'companyCreate',
  ])

@section('content')

<div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Create New Company</h6>
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
                  <form method="POST" action="{{ action('CompanyController@store') }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                      <label for="companyName">Name <span class="text-red">*</span></label>
                      <input type="text" class="form-control" name="name" id="name-field" required>
                    </div>

                    <div class="form-group">
                      <label for="companyAddress">Address</label>
                      <input type="text" class="form-control" name="address" id="address-field">
                    </div>

                    <div class="form-group">
                      <label for="companyAddress2">Address 2</label>
                      <input type="text" class="form-control" name="address2" id="address2-field">
                    </div>

                    <div class="form-group">
                      <label for="companyCity">City</label>
                      <input type="text" class="form-control" name="city" id="city-field">
                    </div>

                    <div class="form-group">
                      <label for="companyState">State</label>
                      <input type="text" class="form-control" name="state" id="state-field">
                    </div>

                    <div class="form-group">
                      <label for="companyAddress">Zip</label>
                      <input type="number" class="form-control" name="zip" id="zip-field">
                    </div>

                    <div class="form-group">
                      <label for="companyAddress">Phone</label>
                      <input type="number" class="form-control" name="phone" id="phone-field">
                    </div>

                    <div class="form-group">
                      <label for="companyFax">Fax</label>
                      <input type="text" class="form-control" name="fax" id="fax-field">
                    </div>

                    <div class="form-group">
                      <label for="companyWebsites">Website</label>
                      <input type="text" class="form-control" name="website" id="website-field">
                    </div>

          
                    <div class="form-group">
                       <button type="submit" class="btn btn-success btn-submit">Create Company</button>
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