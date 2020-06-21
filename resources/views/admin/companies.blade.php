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
              <h6 class="h2 text-white d-inline-block mb-0">Companies</h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="companies/create" class="btn btn-sm btn-neutral">Create New Company</a>
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
                  <th>Active</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="list">
              @foreach ($companies as $company)
                <tr>
                   <td>
                      {{ $company->name }}
                  </td>
                  <td>
                    {{ $company->active === 1 ? "Active" : "Inactive" }}
                  </td>
                  <td class="">
                    <a class="dropdown-item" href="./companies/edit/{{$company->id}}">Edit Company</a>   
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