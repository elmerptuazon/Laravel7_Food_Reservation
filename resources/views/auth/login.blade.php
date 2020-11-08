@extends('index')

@section('content')

<form method="POST" class="form-signin text-center" action="{{ route('login') }}">
@csrf
<div class="container">

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
<img src="{{ asset("/images/sample_logo.jpg") }}" class="mb-4" alt="Beef Short Ribs" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">Login</h1>
  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email address" required="" autofocus="">
  @error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="inputPassword" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required="">
  @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  <div class="checkbox mb-3">
    <label>
    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
  <p class="mt-5 mb-3 text-muted">© 2020 Sunday Smoker</p>
  </div>
</form>

@endsection
