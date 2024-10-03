  <!-- Main Sidebar Container -->
  <aside class="main-sidebar mi-side-color sidebar-light-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('dashboard') }}" class="brand-link">
          <span class="brand-text text-success"><b>NASECO </b> Seeds</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  {{-- <li class="nav-item">
                      <a href="{{ route('dashboard') }}" class="nav-link">
                          <i class="fas fa-tachometer-alt"></i>
                          <p>
                              Back to main dashboard
                          </p>
                      </a>
                  </li> --}}
                  <li class="nav-item">
                      <a href="{{ route('dashboard') }}" class="nav-link">
                          <i class="fas fa-car"></i>
                          <p>
                              Vehicle Management
                          </p>
                          <i class="fas fa-angle-left right"></i>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('categories.index') }}" class="nav-link">

                                  <p>
                                      Vehicle Categories
                                  </p>
                              </a>
                          </li>

                          <li class="nav-item">
                              <a href="{{ route('vehicles.index') }}" class="nav-link">

                                  <p>
                                      Vehicles
                                  </p>
                              </a>
                          </li>
                         
                          <li class="nav-item">
                            <a href="{{ route('drivers.index') }}" class="nav-link">

                                <p>
                                    Mechanics
                                </p>
                            </a>
                        </li>
                          <li class="nav-item">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
    
                                    <p>
                                        Incidents
                                    </p>
                                </a>
                            </li>
                              <li class="nav-item">
                      </ul>
                  </li>
                  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                 
                  <li class="nav-item">
                      <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="fas fa-user-tie"></i>

                          <p>
                              People Management
                          </p>
                          <i class="fas fa-angle-left right"></i>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('drivers.index') }}" class="nav-link">

                                <p>
                                    Drivers / Operators
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                              <a href="{{ route('operators.index') }}" class="nav-link">

                                  <p>
                                      Others
                                  </p>
                              </a>
                          </li>
                    </ul>
                </li>
                          
            </ul>
        </li>
                  <li class="nav-item">

                      <a href="{{ route('admin.users.index') }}" class="nav-link">
                          <i class="fas fa-user"></i> User Management


                          </p>
                      </a>



                  </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
