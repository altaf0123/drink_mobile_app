<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">


        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-cog"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <a href="{{route('admin.settings.account')}}" class="dropdown-item">
                    <i class="fas fa-cog mr-2"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{route('admin.logout')}}" class="dropdown-item dropdown-footer">LOGOUT</a>
            </div>
        </li>

    </ul>
</nav>
