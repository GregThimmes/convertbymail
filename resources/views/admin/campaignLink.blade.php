@extends('layouts.app', [
    'namePage' => 'Campaign Links',
    'class' => '',
    'activePage' => 'campaignLink',
  ])

@section('content')

<div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Campaign Links</h6>
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
              <a href="../view/{{ $id }}" class="btn btn-primary" target="_blank">View Creative</a>
            </div>
            <div class="card-body">
              <div class="row">
                  <div class="col-md-12">
                    <form method="POST" action="{{ action('CampaignController@store') }}">
                    {{ csrf_field() }}
                    
                    <div class="table-responsive">
                      <div>
                          <table class="table align-items-center">
                              <thead class="thead-light">
                                  <tr>
                                      <th scope="col">Link</th>
                                      <th scope="col">Clicks</th>
                                  </tr>
                              </thead>
                              <tbody class="list">
                                  

                                    @foreach($links AS $link)
                                        <tr>
                                        <td>http://convertbymail.com/campaign_page.php?c={{ $link->campaign_id }}~{{ $link->link_id }}</td>
                                        <td>
                                          <div class="form-group">
                                            <input type="number" class="form-control" name="total" id="total-field" required>
                                          </div>
                                        </td>
                                        </tr>
                                    @endforeach
                                  
                                </tbody>
                              </table>
                            </div>
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

@endpush