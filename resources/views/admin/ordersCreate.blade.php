@extends('layouts.app', [
    'namePage' => 'Create Order',
    'class' => '',
    'activePage' => 'orderCreate',
  ])

@section('content')

<div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Create New Order</h6>
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
                  <form method="POST" action="{{ action('InsertionOrderController@store') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label for="client">Client <span class="text-red">*</span></label>
                      <select class="form-control" id="client_id" name="client_id" required>
                          <option value="">Select A Company</option>
                         @foreach ($companies AS $company)
                          <option value="{{ $company->id }}">{{ $company->name }}</option>
                         @endforeach
                      </select>
                      @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="salesRep">Sales Rep <span class="text-red">*</span></label>
                      <select class="form-control" id="company" name="sales_rep_id" required>
                          <option value="">Select A Sales Rep</option>
                         @foreach ($sales_reps AS $rep)
                          <option value="{{ $rep->id }}">{{ $rep->name }}</option>
                         @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="quantity">ID <span class="text-red">*</span></label>
                      <input type="number" class="form-control" name="internal_id" id="internal-field" required>
                    </div>

                    <div class="form-group">
                      <label for="exampleFormControlSelect1">Name <span class="text-red">*</span></label>
                      <input type="text" class="form-control" name="name" id="name-field" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Type<span class="text-red">*</span></label>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="type" id="cpc-field" value="c" checked>
                          <label class="form-check-label" for="cpc">
                            CPC
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="type" id="cpm-field" value="m">
                          <label class="form-check-label" for="cpm">
                            CPM
                          </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Status<span class="text-red">*</span></label>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="status" id="open-field" value="c" checked>
                          <label class="form-check-label" for="cpc">
                            Open
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="status" id="closed-field" value="m">
                          <label class="form-check-label" for="cpm">
                            Closed
                          </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                      <label for="SubjectLine">Quantity <span class="text-red">*</span></label>
                      <input type="number" class="form-control" name="quantity" id="quantity-field" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlSelect1">Notes</label>
                      <input type="text" class="form-control" name="notes" id="notes-field">
                    </div>
          
                    <div class="form-group">
                       <button type="submit" class="btn btn-success btn-submit">Create Order</button>
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