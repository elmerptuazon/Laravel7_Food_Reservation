@extends('index')

@section('content')

<div class="row justify-content-center">
<div class="col-md-6">
<div class="card">
<article class="card-body">
<h4>Register</h4>
<form method="POST" action="{{ route('register') }}">
@csrf
	<div class="form-row">
		<div class="col form-group">
			<label>First name </label>   
		  	<input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="" required>
            @error('first_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
		</div> <!-- form-group end.// -->
		<div class="col form-group">
			<label>Last name</label>
		  	<input type="text"  class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder=" " required>
            @error('last_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
		</div> <!-- form-group end.// -->
	</div> <!-- form-row end.// -->
	<div class="form-group">
		<label>Email address</label>
		<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="" required>
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
		<small class="form-text text-muted"><i>We'll never share your email with anyone else.</i></small>
	</div> <!-- form-group end.// -->
    <div class="form-group">
		<label>Mobile No.</label>
		<input type="tel" class="form-control @error('mobile') is-invalid @enderror" maxlength="11" name="mobile" placeholder="" pattern="[0]{1}[9]{1}[0-9]{9}" required>
        @error('mobile')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <small class="form-text text-muted"><i>e.g. 09123456789</i></small>
	</div>
    <div class="form-group">
		<label>Password</label>
		<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="" required>
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group">
		<label>Confirm Password</label>
		<input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" placeholder="" required>
    </div>
    <div class="form-group">
		<label>Address</label>
		<input type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="" required>
        @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
	</div>
	<div class="form-row">
		<div class="form-group col-md-6">
		  <label>City</label>
                <select id="cityinput" name="city" class="form-control">
                    <option value="caloocan">{{ ucwords('caloocan')}}</option>
                    <option value="las pinas">{{ ucwords('las pinas')}}</option>
                    <option value="makati">{{ ucwords('makati')}}</option>
                    <option value="mandaluyong">{{ ucwords('mandaluyong')}}</option>
                    <option value="marikina">{{ ucwords('marikina')}}</option>
                    <option value="muntinlupa">{{ ucwords('muntinlupa')}}</option>
                    <option value="navotas">{{ ucwords('navotas')}}</option>
                    <option value="paranaque">{{ ucwords('paranaque')}}</option>
                    <option value="pasay">{{ ucwords('pasay')}}</option>
                    <option value="pasig">{{ ucwords('pasig')}}</option>
                    <option value="pateros">{{ ucwords('pateros')}}</option>
                    <option value="quezon city">{{ ucwords('quezon city')}}</option>
                    <option value="san juan">{{ ucwords('san juan')}}</option>
                    <option value="taguig">{{ ucwords('taguig')}}</option>
                    <option value="valenzuela">{{ ucwords('valenzuela')}}</option>
                </select>

		</div> <!-- form-group end.// -->
		<div class="form-group col-md-6">
		  <label>Country</label>
          <input type="text" class="form-control" name="province" value="{{ ucwords('metro manila')}}" aria-label="Small" aria-describedby="inputGroup-sizing-sm" readonly>        
		</div> <!-- form-group end.// -->
	</div> <!-- form-row.// -->
    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block"> Register  </button>
    </div> <!-- form-group// -->      
    <small class="text-muted">By clicking the 'Sign Up' button, you confirm that you accept our <br> Terms of use and Privacy Policy.</small>                                          
</form>
</article> <!-- card-body end .// -->
<div class="border-top card-body text-center">Have an account? <a href="/login">Log In</a></div>
</div> <!-- card.// -->
</div> <!-- col.//-->

</div> <!-- row.//-->




@endsection
