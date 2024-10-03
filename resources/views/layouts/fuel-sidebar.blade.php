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
                  
                  <li class="nav-item">
                      <a href="{{ route('fuel-out.report-sum') }}" class="nav-link">
                          <h5 class="text-success"><b>
                                 Fuel and Lubricants
                              </b></h5>
                      </a>
                      <hr class="p-0 m-0">
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('fuel-in.index') }}" class="nav-link">
                          <i class="fas fa-plus"></i>
                          <p>
                              Fuel In
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('fuel-out.index') }}" class="nav-link">
                          <i class="fas fa-minus"></i>
                          <p>
                              Fuel Out
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('lub-in.index') }}" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <p>
                            Lubs In
                        </p>
                    </a>
                </li>
                  <li class="nav-item">
                    <a href="{{ route('lub-out.index') }}" class="nav-link">
                        <i class="fas fa-minus"></i>
                        <p>
                            lubs Out
                        </p>
                    </a>
                </li>
                  <li class="nav-item">
                    <a href="{{ route('lubs.index') }}" class="nav-link">
                        <i class="fas fa-th-large"></i>
                        <p>
                            Lubricants
                        </p>
                    </a>
                </li>
                  

                  </li>
                  <li class="nav-item">
                      <a href="fuel_report.php" class="nav-link">
                          <i class="fas fa-chart-bar"></i>
                          <p>
                            Reports
                            <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('fuel-in.report') }}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Fuel In Report</p>
                            </a>
                          </li>              
                          <li class="nav-item">
                            <a href="{{ route('fuel-out.report') }}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Fuel Out Report</p>
                            </a>
                          </li> 
                          <li class="nav-item">
                            <a href="{{ route('fuel-out.report-sum') }}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Fuel Summary Report</p>
                            </a>
                          </li> 
                          <li class="nav-item">
                            <a href="{{ route('lub-in.report') }}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>lubs in Report</p>
                            </a>
                          </li>     
                          <li class="nav-item">
                            <a href="{{ route('lub-out.report') }}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>lubs Out Report</p>
                            </a>
                          </li> 
                                                 
                        </ul>
                  </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
