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
                    <a href="{{ route('fertilisers.index') }}" class="nav-link">
                        <h5 class="text-success"><b>
                               Fertiliser Module
                            </b></h5>
                    </a>
                    <hr class="p-0 m-0">
                </li>
                <li class="nav-item">
                    <a href="{{ route('fertiliser-in.index') }}" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <p>
                            Fertiliser In
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('fertiliser-out.index') }}" class="nav-link">
                        <i class="fas fa-minus"></i>
                        <p>
                            Fertiliser Out
                        </p>
                    </a>
                </li>
              
                <li class="nav-item">
                    <a href="fertiliser_report.php" class="nav-link">
                        <i class="fas fa-chart-bar"></i>
                        <p>
                          Reports
                          <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                          <a href="{{ route('fertiliser-in.report') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>fertiliser In Report</p>
                          </a>
                        </li>              
                        <li class="nav-item">
                          <a href="{{ route('fertiliser-out.report') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>fertiliser Out Report</p>
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
