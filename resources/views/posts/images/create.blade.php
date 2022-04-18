@component('layout.content' , ['title' => 'افزودن تصویر جدید'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/dashboard">پنل مدیریت</a></li>
        <li class="breadcrumb-item">{{ $post->title }}</li>
        <li class="breadcrumb-item active">ثبت تصویر</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('layout.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ثبت تصویر</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('posts.images.store' , ['post' => $post->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div id="images_section">

                        </div>
                        <button class="btn btn-sm btn-danger" type="button" id="add_post_image">افزودن تصویر جدید</button>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ثبت تصاویر</button>
                        <a href="{{ route('posts.images.index' , ['post' => $post->id]) }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

@endcomponent
