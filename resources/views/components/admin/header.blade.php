

<header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container-fluid">
        <div class="row" style="margin-left: 0px; margin-right: 0px; width: inherit;">
        <div class="col-4" style="padding-left: 0px;">
          <a type="button" class="navbar-brand" data-toggle="collapse" data-target="#navbar-collapse">
             <i style="color:#000000;" class="fa fa-bars"></i>
          </a>
          </div>
          <div class="col-6">
          <a href="{{ url('admin/order') }}" style="color:#000000;" class="navbar-brand"><b>ADMIN</b></a>
          </div>
          <div class="col-2">
          <!-- <i class="fa fa-shopping-cart fa-3x" style="color:#b50e35" class="navbar-brand"></i> -->
          </div>
            </div>

        <div class="collapse navbar-collapse" id="navbar-collapse">
          <ul class="nav navbar-nav">
          <li><strong><a href="{{ url('admin/order') }}" style="color:#b50e35;">Home</a></strong></li>
            @guest
                <li class="nav-item">
                <strong><a class="nav-link" style="color:#b50e35;" href="/admin">{{ __('Login') }}</a></strong>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                    <strong><a class="nav-link" style="color:#b50e35;" href="/admin/register">{{ __('Register') }}</a></strong>
                    </li>
                @endif
            @else
                <li><strong><a href="{{ url('admin/order') }}" style="color:#b50e35;">Orders</a></strong></li>
                <li><strong><a href="{{ url('admin/calendar_capacity') }}" style="color:#b50e35;">Capacity/Inventory</a></strong></li>
                <li class="nav-item dropdown">

                  <strong><a class="nav-link" style="color:#b50e35;" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                  </a></strong>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
                </li>
            @endguest
          </ul>
        </div>
      </div>
    </nav>
  </header>
