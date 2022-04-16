@component('layout.content', ['title' => 'all posts'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="#">داشبورد</a></li>
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
                        @can('create', \App\Post::class)
                            <a class="btn btn-sm btn-primary mr-2" href="{{ route('posts.create') }}">ایجاد پست جدید</a>
                        @endcan
                        <a class="btn btn-sm btn-dark mr-2" href="{{ request()->fullUrlWithQuery(['active' => 1]) }}">پست های فعال</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody><tr>
                            <th>آی دی</th>
                            <th>عنوان</th>
                            <th>وضعیت پست</th>
                            <th>عملیات</th>
                        </tr>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td>
                                    @if($post->is_active)
                                        <span class="badge badge-success">فعال</span>
                                    @else
                                        <span class="badge bg-danger">غیرفعال</span>
                                    @endif
                                </td>
                                <td class="d-flex">
                                    @can('delete', $post)
                                        <form method="post" action="{{ route('posts.destroy', ['post' => $post->id])}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                        </form>
                                    @endcan
                                    @can('update', $post)
                                        <a class="btn btn-primary btn-sm mr-1" href="{{ route('posts.edit', ['post' => $post->id])}}">ویرایش</a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ $posts->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endcomponent
