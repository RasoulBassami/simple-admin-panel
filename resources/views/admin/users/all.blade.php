@component('admin.layout.content', ['title' => 'فهرست کاربران'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
        <li class="breadcrumb-item active">فهرست کاربران</li>
    @endslot
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">جدول کاربران</h3>

                    <div class="card-tools d-flex">
                        <form action="">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="search" class="form-control float-right" placeholder="جستجو">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        @canany(['create', 'createAdmin'], \App\Models\User::class)
                            <a class="btn btn-sm btn-primary mr-2" href="{{ route('admin.users.create') }}">ایجاد کاربر جدید</a>
                        @endcanany
                        @can('viewAdmin', auth()->user(), \App\Models\User::class)
                            <a class="btn btn-sm btn-dark mr-2" href="{{ request()->fullUrlWithQuery(['admin' => 1]) }}">کاربران ادمین</a>
                        @endcan
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody><tr>
                            <th>آی دی</th>
                            <th>نام</th>
                            <th>نام کاربری</th>
                            <th>عملیات</th>
                        </tr>
                        @foreach($users as $user)
                            @if($user->isAdmin())
                                @can('viewAdmin', auth()->user(), \App\Models\User::class)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td class="d-flex">
                                            @can('deleteAdmin', $user)
                                                <form method="post" action="{{ route('admin.users.destroy', ['user' => $user->id])}}">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-sm ml-1">حذف</button>
                                                </form>
                                            @endcan
                                            @can('updateAdmin', $user)
                                                <a href="{{ route('admin.users.edit' , ['user' => $user->id]) }}" class="btn btn-sm btn-primary">ویرایش</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endcan
                            @else
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td class="d-flex">
                                        @can('delete', $user)
                                            <form method="post" action="{{ route('admin.users.destroy', ['user' => $user->id])}}">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                            </form>
                                        @endcan
                                        @can('update', $user)
                                            <a href="{{ route('admin.users.edit' , ['user' => $user->id]) }}" class="btn btn-sm btn-primary mr-1">ویرایش</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endif

                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ $users->withQueryString()->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endcomponent
