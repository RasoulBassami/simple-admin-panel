@component('layout.content', ['title' => 'پنل مدیریت'])

    @slot('breadcrumb')
        <li class="breadcrumb-item active">داشبورد</li>
    @endslot

    @include('layout.errors')
    <div class="row">
        <div class="card card-dark col-md-10 offset-md-1 px-0">
            <div class="card-header">
                <h3 class="card-title"><h2>{{ auth()->user()->username }} خوش آمدید!</h2></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body d-flex justify-content-center">
                <div class="row col-md-8 d-flex justify-content-center">
                    <div class="col-6">
                        <a href="{{ route('posts.index') }}" class="btn d-block p-5 bg-success-gradient">مشاهده همه پست ها</a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('posts.create') }}" class="btn d-block p-5 bg-primary-gradient">ایجاد پست جدید</a>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
@endcomponent
