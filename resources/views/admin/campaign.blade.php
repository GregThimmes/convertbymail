@extends('layouts.app', [
    'namePage' => 'Table List',
    'class' => 'sidebar-mini',
    'activePage' => 'table',
  ])

@section('content')

<div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Campaigns</h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="{{ route('campaign-create') }}" class="btn btn-sm btn-neutral">Create New Campaign</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid mt--6">
      
      <!-- Dark table -->
      <div class="row">
        <div class="col">
          <div class="card bg-default shadow">
            <div class="card-header  border-0">
              
            </div>
            <div class="table-responsive">
              <table id="datatable" class="table align-items-center table-light table-flush" cellspacing="0" width="100%">
              <thead class="thead-light">
                <tr>
                  <th>Name</th>
                  <th>Open Rate</th>
                  <th>URL</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="list">
              @foreach ($campaigns as $campaign)
                <tr>
                   <td>
                      <a href="http://ads.staycationmedia.com/adtrack/viewCreative.php?c={{ $campaign->id }}" target="_blank">{{ $campaign->name }}</a>
                  </td>
                   <td>
                      {{ $campaign->o_rate }}
                  </td>
                   <td>
                      http://ads.staycationmedia.com/process.php?c={{ $campaign->id }}
                  </td>
                  <td>
                    {{ $campaign->active === 1 ? "Active" : "Inactive" }}
                  </td>
                  <td class="">

                        <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                <a class="dropdown-item" href="campaign/edit/{{$campaign->id}}">Edit Campaign</a>
                                <a class="dropdown-item" href="campaign/links/{{$campaign->id}}">Edit Campaign Links</a>
                                <a class="dropdown-item" href="creative/edit/{{$campaign->id}}">Edit Creative</a>
                            </div>
                        </div>
                    </td>
              @endforeach                    
              </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>

    </div>

@endsection