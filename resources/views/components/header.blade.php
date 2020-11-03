

{{--<header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container-fluid">
        <div class="row" style="margin-left: 0px; margin-right: 0px; width: inherit;">
        <div class="col-4" style="padding-left: 0px;">
          <a type="button" style="color:#000000;" class="navbar-brand" data-toggle="collapse" data-target="#navbar-collapse">
             <i class="fa fa-bars"></i>
          </a>
          </div>
          <div class="col-6">
          <a href="/" style="color:#000000;" class="navbar-brand"><b>LOGO</b></a>
          </div>
          <div class="col-2">
          <i class="fa fa-shopping-cart fa-2x" style="color:#b50e35" class="navbar-brand"></i>
          </div>
            </div>

        <div class="collapse" id="navbar-collapse">
          
        </div>
      </div>
      <!-- /.container-fluid -->
      
    </nav>
  </header>--}}


  <nav class="navbar navbar-expand-md fixed-top">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fa fa-bars"></i>
  </button>
  <a class="navbar-brand" href="/"><img src="{{ asset("/images/beef_short_ribs.jpg") }}" alt="Beef Short Ribs" width="40" height="40">
</a>
  <a class="navbar-brand" href="#"><i class="fa fa-shopping-cart fa-2x" style="color:#b50e35"></i></a>
  

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">

                      <a class="nav-link" href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                    </li>
                @endguest
      
    </ul>
  </div>
</nav>