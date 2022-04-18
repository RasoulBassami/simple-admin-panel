@component('admin.layout.content', ['title' => 'فهرست تمامی پست ها'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
        <li class="breadcrumb-item active">همه پست ها</li>
    @endslot
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">جدول پست ها</h3>

                    <div class="card-tools d-flex">
                        <form action="">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="search" class="form-control float-right" placeholder="جستجو">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <a class="btn btn-sm btn-success mr-2" href="{{ request()->fullUrlWithQuery(['active' => 1]) }}">پست های فعال</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody><tr>
                            <th>آی دی</th>
                            <th>نویسنده</th>
                            <th>عنوان</th>
                            <th>تاریخ ایجاد</th>
                            <th>وضعیت پست</th>
                        </tr>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->user->name }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->PersianCreatedAt() }}</td>
                                <td>
                                    @if($post->is_active)
                                        <span class="badge badge-success">فعال</span>
                                    @else
                                        <span class="badge bg-danger">غیرفعال</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ $posts->withQueryString()->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endcomponent