

<header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container-fluid">
        <div class="row" style="margin-left: 0px; margin-right: 0px; width: inherit;">
        <div class="col-4" style="padding-left: 0px;">
          <a type="button" class="navbar-brand" data-toggle="collapse" data-target="#navbar-collapse">
             <i class="fa fa-bars"></i>
          </a>
          </div>
          <div class="col-6">
          <a href="{{ url('admin/order') }}" class="navbar-brand"><b>ADMIN</b></a>
          </div>
          <div class="col-2">
          <i class="fa fa-shopping-cart fa-3x" style="color:#b50e35" class="navbar-brand"></i>
          </div>
            </div>

        <div class="collapse navbar-collapse" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="{{ url('admin/order') }}">Orders</a></li>
            <li><a href="{{ url('admin/calendar_capacity') }}">Capacity/Inventory</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
