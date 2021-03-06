<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link text-center">
        <span class="brand-text font-weight-light d-block p-2 {{ \Illuminate\Support\Facades\Route::currentRouteName() == 'dashboard' ? 'bg-primary' : ''}}">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
        <div style="direction: rtl">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="https://www.gravatar.com/avatar/52f0fbcbedee04a121cba8dad1174462?s=200&d=mm&r=g" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <span class="text-white d-block">{{ auth()->user()->username }}</span>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('posts.index') }}" class="nav-link {{ \Illuminate\Support\Facades\Route::currentRouteName() == 'posts.index' ? ' active' : ''}}">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                همه پست ها
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('posts.create') }}" class="nav-link  {{ \Illuminate\Support\Facades\Route::currentRouteName() == 'posts.create' ? ' active' : ''}}"">
                            <i class="nav-icon fa fa-th"></i>
                            <p>
                                ایجاد پست جدید
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
    </div>
    <!-- /.sidebar -->
</aside>
