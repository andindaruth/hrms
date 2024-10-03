  <!-- Main Sidebar Container -->
  <aside class="main-sidebar mi-side-color sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <span class="brand-text text-success"><b>NASECO </b> Workshop</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('equipment.actions') }}" class="nav-link">
                    <i class="fas fa-tasks"></i>
                        <p>
                            Actions
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('equipment.items') }}" class="nav-link">
                    <i class="fas fa-wrench"></i>
                        <p>
                            Items
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('equipment.tools') }}" class="nav-link">
                    <i class="fas fa-toolbox"></i>
                        <p>
                            Tools
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('equipment.spare_parts') }}" class="nav-link">
                    <i class="fas fa-cogs"></i>
                        <p>
                            Spareparts
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('equipment.material') }}" class="nav-link">
                    <i class="fas fa-cogs"></i>
                        <p>
                            Material
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('equipment.workshop') }}" class="nav-link">
                    <i class="fas fa-tools"></i>
                        <p>
                            Workshop
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('equipment.farm') }}" class="nav-link">
                    <i class="fas fa-tractor"></i>
                        <p>
                            Farm
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('equipment.all') }}" class="nav-link">
                    <i class="fas fa-tractor"></i>
                        <p>
                            All
                        </p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('equipment.actions.returned') }}" class="nav-link">
                    <i class="fas fa-redo"></i>
                        <p>
                            Returned
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('equipment.actions.taken_non_returnable') }}" class="nav-link">
                    <i class="fas fa-handshake-slash"></i>
                        <p>
                            Taken non returnable
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('equipment.actions.repaired') }}" class="nav-link">
                    <i class="fas fa-check-circle"></i>
                        <p>
                            Repaired
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('equipment.actions.disposed') }}" class="nav-link">
                    <i class="fas fa-trash"></i>
                        <p>
                            Disposed
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('equipment.actions.report_in') }}" class="nav-link">
                    <i class="fas fa-clipboard-list"></i>
                        <p>
                            Report In
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('equipment.actions.report_out') }}" class="nav-link">
                    <i class="fas fa-clipboard-list"></i>
                        <p>
                            Report Out
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
