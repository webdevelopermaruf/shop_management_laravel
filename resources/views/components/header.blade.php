      <!-- ================================
         header
         ================================-->
      <header>
          <div class="main-header-wrapper">
              <div class="container">
                  <div class="row">
                      <a href="{{ url('/') }}" class="col-xs-6 si-box-padding">
                          <h3>Shoppi<span> Admin</span></h3>
                      </a>
                      <!-- end of col-xs-6 -->
                      <div class="col-xs-6 si-box-padding">
                          <div class="admin-user-wrapper">
                              <div class="user-img">
                                  <img src="images/author.png" class="img-responsive" alt="">
                              </div>
                              <!-- end of user-img -->
                              <div class="user-name btn-group">
                                  <button class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                      aria-expanded="false">{{ session()->get('name') }}
                                      <span>
                                          @if (session()->get('role') == 0)
                                              Developer
                                          @elseif(session()->get('role') == 1)
                                              Admin
                                          @elseif(session()->get('role') == 2)
                                              Manager
                                          @elseif(session()->get('role') == 3)
                                              Sales Man
                                          @endif
                                      </span>
                                  </button>
                                  <ul class="dropdown-menu dropdown-menu-right logout-drop">
                                      <li><a href="{{ url('/auth/logout') }}"><i
                                                  class="ti-power-off"></i><span>Logout</span></a></li>
                                      <li><a href="{{ url('/profile') }}"><i
                                                  class="ti-user"></i><span>Profile</span></a></li>
                                      <li><a href="{{ url('/app/settings') }}"><i
                                                  class="ti-settings"></i><span>Settings</span></a></li>
                                  </ul>
                                  <!-- end of dropdown-menu -->
                              </div>
                              <!-- end of user-name -->
                          </div>
                          <div style="margin-right:20px" class="admin-user-wrapper">
                              <button class='btn btn-sky-blue' id="fullscreen"><span class="ti-desktop" style="color:white;"></span></button>
                          </div>
                          <!-- end of admin-user-wrapper -->
                      </div>
                      <!-- end of col-xs-6 -->
                  </div>
                  <!-- end of row -->
              </div>
              <!-- end of container -->
          </div>
          <!-- end of main-header-wrapper -->

          <div class="menu-list">
              <nav class="navbar navbar-default menu-white-wrapper">
                  <div class="container">
                      <!-- Brand and toggle get grouped for better mobile display -->
                      <div class="navbar-header">
                          <!-- search-wrapper-head -->
                          <div class="search-wrapper-head search-nav-left clearfix visible-xs">
                              <div class="search-input-wrapper">
                                  <input type="text" name="search" placeholder="Search here...">
                              </div>
                              <div class="search-icon-wrapper">
                                  <a href="#"><i class="ti-search"></i></a>
                              </div>
                          </div>
                          <!-- end of search wrapper-head -->
                          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                              data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                              <span class="sr-only">Toggle navigation</span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                          </button>
                      </div>
                      <!-- end of navbar-header -->
                      <!-- Collect the nav links, forms, and other content for toggling -->
                      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                          <div class="row sec-cx">
                              <div class="col-md-12 si-box-padding">
                                  <ul class="nav navbar-nav">
                                      <li class="active">
                                          <a href="{{ url('/') }}">
                                              <i class="ti-dashboard"></i>Dashboard</a>
                                      </li>
                                      <li>
                                          <a href="{{ url('/category') }}">
                                              <i class="ti-harddrives"></i>
                                              Category
                                          </a>
                                      </li>
                                      <li>
                                          <a href="{{ url('/customer') }}">
                                              <i class="ti-user"></i>
                                              Customers
                                          </a>
                                      </li>
                                      <li>
                                          <a href="{{ url('/product') }}">
                                              <i class="ti-package"></i>
                                              Product
                                          </a>
                                      </li>
                                      <li>
                                          <a href="{{ url('/quick-order') }}">
                                              <i class="ti-shopping-cart"></i>
                                              Orders
                                          </a>
                                      </li>
                                      <li>
                                          <a href="{{ url('/return-order') }}">
                                              <i class="ti-back-right"></i>
                                              Return Orders
                                          </a>
                                      </li>
                                      <li>
                                          <a href="{{ url('/outofstock') }}">
                                              <i class="ti-alert"></i>
                                              Stock Out
                                          </a>
                                      </li>
                                      @if (session()->get('role') <= 1)
                                          <li>
                                              <a href="{{ url('/inventory') }}">
                                                  <i class="ti-archive"></i>
                                                  Inventory
                                              </a>
                                          </li>
                                      @endif
                                      <li>
                                          <a href="{{ url('/expenses') }}">
                                              <i class="ti-credit-card"></i>
                                              Expenses
                                          </a>
                                      </li>
                                      <li>
                                          <a href="{{ url('/report') }}">
                                              <i class="ti-file"></i>
                                              Report
                                          </a>
                                      </li>
                                  </ul>
                                  <!-- end of navbar-nav -->

                              </div>
                              <!-- end of col-md-12 -->
                          </div>
                          <!-- end of row -->
                      </div>
                      <!-- /.navbar-collapse -->
                  </div>
                  <!-- /.container-fluid -->
              </nav>
              <!-- end of navbar -->
          </div>
          <!-- end of menu-list -->
      </header>
      <!-- end of header -->
