
  <nav class="navbar navbar-expand-md navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fa fa-bars"></i>
  </button>
  <a class="navbar-brand" href="/"><img src="{{ asset("/images/sample_logo.jpg") }}" alt="Beef Short Ribs" width="40" height="40">
</a>
  
  <a class="navbar-brand" id="cart_anchor_tag" href="{{url('cart')}}"
      onclick="event.preventDefault();
                    document.getElementById('cart-form').submit();">
      <i class="fa fa-shopping-cart fa-2x" style="color:#b50e35"></i>
      <span class='badge badge-warning' id='lblCartCount'></span>
  </a>
  <form id="cart-form" action="{{url('cart')}}" method="POST" class="d-none">
      @csrf
      <input type="hidden" name="cart_data" id="session_cart_data" />
  </form>
  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/"><strong>Home</strong></a>
      </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><strong>{{ __('Login') }}</strong></a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}"><strong>{{ __('Register') }}</strong></a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">

                      <a class="nav-link" href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                                        sessionStorage.removeItem('ORDER_TOTAL');
                                        sessionStorage.removeItem('FOOD_LIST');
                                        sessionStorage.removeItem('CAPACITY_DATE');
                                        sessionStorage.removeItem('CART_COUNT');
                                        document.getElementById('logout-form').submit();">
                          <strong>{{ __('Logout') }}</strong>
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                    </li>
                @endguest
      
    </ul>
  </div>
</nav>