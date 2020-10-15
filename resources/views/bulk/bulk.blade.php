@extends('layouts.app', [
    'namePage' => 'Ad Campaigns',
    'class' => '',
    'activePage' => 'bulk',
])

@section('content')
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Active Campaigns</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <button class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#exampleModal">Bulk Upload</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt--6">
    <div class="row">
        <!-- Light table -->
        <div class="col">
            <div class="card">
            <!-- Card header -->
                <div class="table-responsive">
                    <div id="myGrid" style="height: 400px;width:100%;" class="ag-theme-material"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="upload_csv" enctype="multipart/form-data" method="post" name="fileinfo">
          {{ csrf_field() }}
            <div class="custom-file">
                <input id="csv_file" name="csv_file" type="file" class="custom-file-input" id="customFileLang" lang="en">
                <label class="custom-file-label" for="customFileLang">Select file</label>
            </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input id="upload_button" class="btn btn-primary" type="submit" value="Upload File">
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
    <script type="text/javascript" charset="utf-8">
    // specify the columns
    var columnDefs = [
      //{headerName: "Id", field: "id"},
      {headerName: "Campaign Name", field: "name"},
      //{headerName: "Pricing Model", field: "pricing_model"},
      {headerName: "Start Date", field: "start_date"},
      {headerName: "End Date", field: "end_date"},
      //{headerName: "Offers", field: "price"},
      {headerName: "Total Budget", field: "budget_total"},
      {headerName: "Total Cost", field: "cost_total"},
      {headerName: "Daily Budget", field: "budget_daily"},
      {headerName: "Today's Cost", field: "cost_today"},
      //{headerName: "Budget Type", field: "budget_limiter_type"},
      //{headerName: "Clicks/Impressions per Day", field: "clicks_daily"},
      //{headerName: "Clicks/Impressions per IP", field: "conversions_daily"},
      {headerName: "Today's Clicks", field: "clicks_today"},
      {headerName: "Today's Impressions", field: "impressions_today"}
    ];

    // specify the data
    var rowData = [];

    // let the grid know which columns and what data to use
    var gridOptions = {
      columnDefs: columnDefs,
      rowData: rowData,
      rowHeight: 40,
      headerHeight: 40,
      defaultColDef: {
        filter: true // set filtering on for all cols
      },
      onFirstDataRendered: onFirstDataRendered,
      overlayLoadingTemplate:'<span class="ag-overlay-loading-center">Please wait while your rows are loading</span>',
      overlayNoRowsTemplate:'<span style="padding: 10px; border: 2px solid #444; background: lightgoldenrodyellow;">No data was returned</span>'
    };

    function onFirstDataRendered(params) {
        params.api.sizeColumnsToFit();
    }


    document.addEventListener('DOMContentLoaded', function () 
    {
        new agGrid.Grid(document.getElementById('myGrid'), gridOptions);
        gridOptions.api.showLoadingOverlay();
        var httpRequest = new XMLHttpRequest();
        httpRequest.open('GET', 'bulk/campaigns');
        httpRequest.send();
        httpRequest.onreadystatechange = function () 
        {
            if (httpRequest.readyState === 4 && httpRequest.status === 200) 
            {
                var httpResult = JSON.parse(httpRequest.response);
    
                if(httpRequest.length === 0)
                {
                  gridOptions.api.showNoRowsOverlay();
                }
                else
                {
                  gridOptions.api.hideOverlay();
                  gridOptions.api.setRowData(httpResult);
                }
                
            }
        };
    });


    $('#upload_csv').on('submit', function(event)
    {
      event.preventDefault();
      $('.modal').modal('toggle')
      swal({
            text: "Uploading...please wait",
            buttons: false,
            closeOnClickOutside: false,
          });
          $.ajax({
           url:"bulk/upload",
           method:"POST",
           data:new FormData(this),
           dataType:'json',
           contentType:false,
           cache:false,
           processData:false,
           success:function(result)
           {
            swal.close()
            if(result.status == 'Error')
            {
                swal({
                title: "Error",
                text: result.message,
                icon: "error",
                button: "Close",
              });
            }
            if(result.status == 'OfferError')
            {
              var myhtml = document.createElement("div");
              myhtml.innerHTML = result.message;

              swal({
                title: "Error",
                content: myhtml,
                icon: "error",
                button: "Close",
              });
            }

            if(result.status == 'SuccessError')
            {
              var myhtml = document.createElement("div");
              myhtml.innerHTML = result.message;
              swal({
                title: "Success With Errors",
                content: myhtml,
                icon: "success",
                button: "Close",
              });
            }
            if(result.status == 'Success')
            {
              swal({
                title: "Success",
                text: "Upload was successful",
                icon: "success",
                button: "Close",
              });

              var httpRequest = new XMLHttpRequest();
              httpRequest.open('GET', 'getCampaigns.php');
              httpRequest.send();
              httpRequest.onreadystatechange = function () 
              {
                  if (httpRequest.readyState === 4 && httpRequest.status === 200) 
                  {
                      var httpResult = JSON.parse(httpRequest.responseText);
                      gridOptions.api.setRowData(httpResult);
                  }
              };

            }
          }
          });
         });
  </script>
@endpush