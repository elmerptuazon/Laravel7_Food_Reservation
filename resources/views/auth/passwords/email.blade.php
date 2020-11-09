{{--

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection--}}

@extends('index')

@section('content')
<form method="POST" class="form-signin text-center" action="{{ route('password.email') }}">
@csrf
<div class="container">
@if (session('status'))
    <div class="alert alert-success" role="alert">
    {{ session('status') }}
    </div>
@endif
<img src="{{ asset("/images/sample_logo.jpg") }}" class="mb-4" alt="Beef Short Ribs" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">{{ __('Reset Password') }}</h1>
  <label for="inputEmail" class="sr-only">{{ __('E-Mail Address') }}</label>
  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  placeholder="Email address" autocomplete="email" required autofocus>
  @error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror

  <br />
  <button class="btn btn-lg btn-primary btn-block" type="submit">{{ __('Send Password Reset Link') }}</button>
  
  <p class="mt-5 mb-3 text-muted">© 2020 Sunday Smoker</p>
  </div>
</form>

@endsection

