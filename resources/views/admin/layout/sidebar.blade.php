<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link text-center">
        <span class="brand-text font-weight-light d-block p-2 {{ \Illuminate\Support\Facades\Route::currentRouteName() == 'admin.dashboard' ? 'bg-primary' : ''}}">پنل مدیریت</span>
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
                    @can('viewAny', \App\Models\Post::class)
                    <li class="nav-item">
                        <a href="{{ route('admin.posts.index') }}" class="nav-link {{ \Illuminate\Support\Facades\Route::currentRouteName() == 'admin.posts.index' ? ' active' : ''}}">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                همه پست ها
                            </p>
                        </a>
                    </li>
                    @endcan

                    @if (auth()->user()->can('view', \App\Models\User::class) || auth()->user()->can('viewAdmin', App\Models\User::first()) )
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-users"></i>
                            <p>
                                فهرست کاربران
                            </p>
                        </a>
                    </li>
                    @endif

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
    </div>
    <!-- /.sidebar -->
</aside>
