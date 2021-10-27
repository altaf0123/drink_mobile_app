<aside class="main-sidebar elevation-4 sidebar-light-danger">
    <!-- Brand Logo -->
    <a href="{{route('admin.dashboard')}}" class="brand-link">
        <img src="{{asset('public/assets/images/unmasked-logo.png')}}"
             alt="Unmasked Logo"
             class="brand-image img-circle elevation-3"
             >
        <span class="brand-text font-weight-light">Unmasked</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('public/uploads/'.auth()->guard('admin')->user()->profile_picture)}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{auth()->guard('admin')->user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}" class="nav-link {{request()->is('admin/dashboard')?"active":""}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="" class="nav-link {{request()->is('admin/users*')?"active":""}}">
                        <i class="nav-icon fas fa-user-alt"></i>
                        <p>
                            Users
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="" class="nav-link {{request()->is('admin/posts*') && !request()->is('admin/posts/reports*')?"active":""}}">
                        <i class="nav-icon fas fa-clone"></i>
                        <p>
                            Posts
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="" class="nav-link {{request()->is('admin/posts/reports*')?"active":""}}">
                        <i class="nav-icon fas fa-paperclip"></i>
                        <p>
                            Post Reports
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.feedback')}}" class="nav-link {{request()->is('admin/feedback*')?"active":""}}">
                        <i class="nav-icon fas fa-comment"></i>
                        <p>
                            Feedbacks
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{request()->is('admin/content*')?"menu-open":""}}">
                    <a href="#" class="nav-link {{request()->is('admin/content*')?"active":""}}">
                        <i class="nav-icon fas fa-clipboard"></i>
                        <p>
                            General Content
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.content',['type'=>'privacy-policy'])}}" class="nav-link {{request()->is('admin/content/privacy-policy*')?"active":""}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Privacy Policy</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.content',['type'=>'terms-and-conditions'])}}" class="nav-link {{request()->is('admin/content/terms-and-conditions*')?"active":""}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Terms And Conditions</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link {{request()->is('admin/settings*')?"active":""}}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Settings
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
