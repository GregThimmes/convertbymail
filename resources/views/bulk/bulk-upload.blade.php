@extends('layouts.app', [
    'namePage' => 'Bulk Upload',
    'class' => '',
    'activePage' => 'bulk upload',
])

@section('content')
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Bulk Upload</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="/bulk" class="btn btn-sm btn-neutral"><i class="ni ni-bold-left"></i>
 Back to Camapign List</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt--6">
    <div class="row">
        <!-- Light table -->
        <div class="col">
            <div class="card p-4">
            <!-- Card header -->
            <div class="row">
              <div class="col-8">
                <div class="alert alert-default" role="alert">
                  <p>Use the following upload tool to upload the provided template.  The upload will return a success message or a row by row error message.   Do not try to re-upload the same file, as you will get duplicate campaigns inserted.</p>
          
                  <button class="btn btn-icon btn-3 btn-warning" type="button">
                    <span class="btn-inner--text">Download Template</span>
                  </button>
                </div>
                <form id="upload_csv" enctype="multipart/form-data" method="post" name="fileinfo">
                  {{ csrf_field() }}
                  <div class="custom-file">
                      <input id="csv_file" name="csv_file" type="file" class="custom-file-input" id="customFileLang" lang="en">
                      <label class="custom-file-label" for="customFileLang">Select file</label>
                  </div>
                    <input id="upload_button" class="btn btn-primary mt-4" type="submit" value="Upload File">
                 </form>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <br/>
                 <div class="table-responsive"><div id="error-table"></div></div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script type="text/javascript" charset="utf-8">
    // specify the columns
    $('#upload_csv').on('submit', function(event)
    {
      event.preventDefault();

      var filePath = $("#csv_file").val(); 
      var file_ext = filePath.substr(filePath.lastIndexOf('.')+1,filePath.length);

      if (filePath.length === 0) {
        swal({
          title: "Error",
          text: 'Please choose a file',
          icon: "error",
          button: "Close",
        });
        return false;
      }

      if(file_ext != 'csv')
      {
        swal({
          title: "Error",
          text: 'Only CSV files are allowed.  Download the template above if needed.',
          icon: "error",
          button: "Close",
        });
        return false;
      }
      swal({
            text: "Uploading...please wait",
            buttons: false,
            closeOnClickOutside: false,
          });
          $.ajax({
           url:"../bulk/store",
           method:"POST",
           data:new FormData(this),
           dataType:'json',
           contentType:false,
           cache:false,
           processData:false,
           success:function(result)
           {
            swal.close();
            var $el = $('#csv_file'); 
            $el.wrap('<form>').closest( 'form').get(0).reset(); 
            $el.unwrap();
            if(result.status == 'Error')
            {
                $('#error-table').html(result.message);
            }
            if(result.status == 'Success')
            {
              swal({
                title: "Success",
                text: "Upload was successful",
                icon: "success",
                button: "Close",
              });
            }
          }
          });
         });
  </script>
@endpush