<!-- Navbar -->
<nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg navbar-light">
    <div class="container">
      <a class="navbar-brand" href="../../../index.html">
        Convert By Mail
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse navbar-custom-collapse collapse" id="navbar-collapse">
        <div class="navbar-collapse-header">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="../../../index.html">
                <img src="../../assets/img/brand/dark.svg" height="40">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <ul class="navbar-nav mr-auto" style="display:none;">
          <li class="nav-item">
          <a href="{{ route('login') }}" class="nav-link">
            <i class="now-ui-icons design_app"></i> {{ __("Dashboard") }}
          </a>
          </li>
          <li class="nav-item @if ($activePage == 'register') active @endif">
            <a href="{{ route('register') }}" class="nav-link">
              <i class="now-ui-icons tech_mobile"></i> {{ __("Register") }}
            </a>
          </li>
          <li class="nav-item @if ($activePage == 'login') active @endif ">
            <a href="{{ route('login') }}" class="nav-link">
              <i class="now-ui-icons users_circle-08"></i> {{ __("Login") }}
            </a>
          </li>
        </ul>
        <hr class="d-lg-none" />
      </div>
    </div>
  </nav>
<!-- End Navbar -->