{{--@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
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
<form method="POST" class="form-signin text-center" action="{{ route('password.update') }}">
@csrf
<div class="container">
<input type="hidden" name="token" value="{{ $token }}">

<img src="{{ asset("/images/sample_logo.jpg") }}" class="mb-4" alt="Beef Short Ribs" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">{{ __('Reset Password') }}</h1>
  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email address" value="{{ $email }}" autofocus="" readonly>
  @error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
    <br />
  <label for="inputPassword" class="sr-only">{{ __('Password') }}</label>
  <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="new-password">

  @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    <br />
  <label for="inputPassword" class="sr-only">{{ __('Confirm Password') }}</label>
  <input id="password-confirm" type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required autocomplete="new-password">

  <br />
  <button class="btn btn-lg btn-primary btn-block" type="submit">{{ __('Reset Password') }}</button>
  <p class="mt-5 mb-3 text-muted">© 2020 Sunday Smoker</p>
  </div>
</form>

@endsection

