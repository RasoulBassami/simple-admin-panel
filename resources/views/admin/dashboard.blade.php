@component('admin.layout.content', ['title' => 'پنل مدیریت'])

    @slot('breadcrumb')
        <li class="breadcrumb-item active">داشبورد</li>
    @endslot

    @include('admin.layout.errors')
    <div class="row">
        <div class="card card-dark col-md-10 offset-md-1 px-0">
            <div class="card-header">
                <h3 class="card-title"><h2>{{ auth()->user()->username }} خوش آمدید!</h2></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body d-flex justify-content-center">
                <div class="row col-md-8 d-flex justify-content-center">
                    @can('viewAny', \App\Models\Post::class)
                        <div class="col-6">
                            <a href="{{ route('admin.posts.index') }}" class="btn d-block p-5 bg-success-gradient">مشاهده همه پست ها</a>
                        </div>
                    @endcan
                    @if (auth()->user()->can('view', \App\Models\User::class) || auth()->user()->can('viewAdmin', App\Models\User::first()) )
                        <div class="col-6">
                            <a href="{{ route('admin.users.index') }}" class="btn d-block p-5 bg-info-gradient">مدیریت کاربران</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- /.card-body -->
            <div class="card-footer">
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
@endcomponent
