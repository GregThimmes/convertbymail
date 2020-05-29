@extends('layouts.app', [
    'namePage' => 'Reset Password',
    'class' => 'bg-white',
    'activePage' => '',
])

@section('content')

    <div class="main-content">
        <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
          <div class="container">
            <div class="header-body text-center mb-4">
            </div>
          </div>

        </div>

        <div class="container mt--9 pb-5 text-gray">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary border border-soft mb-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <form role="form" method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="card card-login card-plain">
                                    <div class="card-header ">
                                        <h2>Password Reset</h2>
                                    </div>
                                    <div class="card-body ">
                                    
                                            @if (session('status'))
                                                <div class="alert alert-success" role="alert">
                                                    {{ session('status') }}
                                                </div>
                                            @endif
                                      

                                        <div class="input-group no-border form-control-lg {{ $errors->has('email') ? ' has-danger' : '' }}">

                                            <span class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-envelope"></i>
                                                </div>
                                            </span>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        </div>
                                        @error('email')
                                            <span style="display:block;" class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="card-footer ">
                                        <button  type = "submit" class="btn btn-primary btn-round btn-lg btn-block mb-3">{{ __('Send Password Reset Link') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection