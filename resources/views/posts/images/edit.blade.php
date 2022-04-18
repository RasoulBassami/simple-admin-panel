@component('layout.content' , ['title' => 'ویرایش تصویر'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/dashboard">پنل مدیریت</a></li>
        <li class="breadcrumb-item">{{ $post->title }}</li>
        <li class="breadcrumb-item active">ویرایش تصویر</li>
    @endslot

        <div class="row">
        <div class="col-lg-12">
            @include('layout.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ویرایش تصویر</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('posts.images.update' , ['post' => $post->id, 'image' => $image->id ]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div class="card-body">
                        {{--                        <h6>ویژگی محصول</h6>--}}
                        {{--                        <hr>--}}
                        <div id="images_section">
                            <div class="row image-field">
                                <div class="col-2">
                                    <img class="img-fluid" src="{{ url($image->image) }}" alt="{{ $image->alt }}">
                                </div>

                                <div class="col-5">
                                    <div class="form-group">
                                        <label>تغییر تصویر</label>

                                        <div class="input-group image-upload-group">
                                            <input id="upload" type="file" name="image" class="form-control border-0 transparent-input">
                                            <label id="upload-label" for="upload" class="text-muted">فایل جدید</label>
                                            <div class="input-group-append">
                                                <label for="upload" class="btn btn-light m-0 rounded-pill px-4">
                                                    <i class="fa fa-cloud-upload ml-1 text-muted"></i>
                                                    <small class="text-uppercase font-weight-bold text-muted">انتخاب تصویر</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <label>متن جایگزین تصویر</label>
                                        <input type="text" name="alt" class="form-control" value="{{ old('alt' , $image->alt) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش تصاویر</button>
                        <a href="{{ route('posts.images.index' , ['post' => $post->id]) }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

@endcomponent
