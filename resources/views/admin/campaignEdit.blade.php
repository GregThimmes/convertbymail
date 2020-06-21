@extends('layouts.app', [
    'namePage' => 'Create Campaign',
    'class' => '',
    'activePage' => 'campaignCreate',
  ])

@section('content')

<div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Edit Campaign {{ $campaign->name }}</h6>
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
                  <form method="POST" action="{{ action('CampaignController@update') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$campaign->id}}"/>
                    <div class="form-group">
                      <label for="client">Client <span class="text-red">*</span></label>
                      <select class="form-control" id="client_id" name="client_id" required>
                          <option value="">Select A Company</option>
                         @foreach ($companies AS $company)
                          <option value="{{ $company->id }}" {{ $campaign->client_id == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
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
                          <option value="{{ $rep->id }}" {{ $campaign->sales_rep_id == $rep->id ? 'selected' : '' }}>{{ $rep->name }}</option>
                         @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="io">IO <span class="text-red">*</span></label>
                      <select class="form-control" id="io_id" name="io_id" required>
                          @foreach ($orders AS $order)
                          <option value="{{ $order->id }}" {{ $campaign->io_id == $order->id ? 'selected' : '' }}>{{ $order->name }}</option>
                         @endforeach
                      </select>
                    </div>
                    
                    <div class="form-group">
                      <label for="example-date-input" class="form-control-label">Broadcast Date <span class="text-red">*</span></label>
                      <input class="form-control" type="date" name="broadcast_date" value="{{$campaign->broadcast_date}}" id="date-input" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlSelect1">Campaign Name <span class="text-red">*</span></label>
                      <input type="text" class="form-control" name="name" id="name-field" value="{{$campaign->name}}" required>
                    </div>
                    <div class="form-group">
                      <label for="quantity">Quantity <span class="text-red">*</span></label>
                      <input type="number" class="form-control" name="quantity" id="quantity-field" value="{{$campaign->quantity}}" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlSelect1">Friendly From <span class="text-red">*</span></label>
                      <input type="email" class="form-control" name="friendly_from" id="from-field" value="{{$campaign->friendly_from}}" required>
                    </div>
                    <div class="form-group">
                      <label for="SubjectLine">Subject Line <span class="text-red">*</span></label>
                      <input type="text" class="form-control" name="subject_line" id="subject-field" value="{{$campaign->subject_line}}" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlSelect1">Notes <span class="text-red">*</span></label>
                      <input type="text" class="form-control" name="notes" id="notes-field" value="{{$campaign->notes}}">
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlTextarea1">Creative</label>
                      <textarea class="form-control" name="creative_o" id="creative-input" rows="10" required>{{$campaign->creative}}</textarea>
                    </div>
                    <div class="form-group">
                       <button type="submit" class="btn btn-success btn-submit">Update Campaign</button>
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
@push('js')

<script type="text/javascript" charset="utf-8">
jQuery(document).ready(function (){
    jQuery('select[name="client_id"]').on('change',function(){
        var companyID = jQuery(this).val();
        if(companyID)
        {
            jQuery.ajax({
                url : '../../ajax/company/insertionorder?id=' +companyID,
                type : "GET",
                dataType : "json",
                success:function(data)
                {
                    jQuery('select[name="io_id"]').empty();
                    jQuery.each(data, function(key,value){
                        $('select[name="io_id"]').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                }
            });
        }
        else
        {
            $('select[name="io"]').empty();
        }
    });
});
</script>
@endpush