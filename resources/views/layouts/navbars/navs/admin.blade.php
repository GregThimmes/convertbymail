<!-- Navbar -->
<nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <h2 class="text-white">Convert By Mail</h2>
          <!-- Navbar links -->
          <ul class="navbar-nav navbar-nav-hover justify-content-center">
            <li class="nav-item"><a href="{{ route('campaigns') }}" class="nav-link">Campaigns</a></li>
             <li class="nav-item"><a href="{{ route('orders') }}" class="nav-link">Orders</a></li>
             <li class="nav-item"><a href="{{ route('companies') }}" class="nav-link">Companies</a></li>
             <li class="nav-item"><a href="{{ route('reps') }}" class="nav-link">Sales Reps</a></li>
          </ul>
          <ul class="navbar-nav align-items-center ml-md-auto ">
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ni ni-bell-55"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">
                <!-- Dropdown header -->
                <div class="px-3 py-3">
                  <h6 class="text-sm text-muted m-0">You have <strong class="text-primary">0</strong> notifications.</h6>

                <!-- View all -->
                <a href="#!" class="dropdown-item text-center text-primary font-weight-bold py-3" style="display:none;">View all</a>
              </div>
            </li>
          </ul>
          <ul class="navbar-nav align-items-center ml-auto ml-md-0 ">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <div class="media-body  ml-2  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold"><?PHP echo Auth::user()->name; ?></span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu  dropdown-menu-right ">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="ni ni-user-run"></i>
                 {{ __('Logout') }}
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  <!-- End Navbar -->