@component('layout.content', ['title' => 'ایجاد پست جدید'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">داشبورد</a></li>
        <li class="breadcrumb-item active">ایجاد پست جدید</li>
    @endslot

    <div class="row">
        <div class="card card-info col-md-10 offset-md-1 px-0">
            <div class="card-header">
                <h3 class="card-title">فرم ایجاد پست</h3>
            </div>
            <!-- /.card-header -->

        @include('layout.errors')

        <!-- form start -->
            <form class="form-horizontal" method="post" action="{{ route('posts.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">عنوان پست</label>
                        <input type="text" name="title" class="form-control" id="inputName3" placeholder="عنوان پست را وارد کنید" value="{{ old('title') }}">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">توضیحات</label>
                        <input type="text" name="description" class="form-control" id="inputEmail3" placeholder="توضیح مختصری در مورد این پست بنویسید"  value="{{ old('description') }}">
                    </div>
                    <div class="form-group">
                        <label for="inputBody" class="col-sm-2 control-label">متن اصلی</label>
                        <textarea name="body" class="form-control" id="inputBody" cols="20" rows="10">{{ old('body' , 'متن اصلی را وارد کنید') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputImages" class="col-sm-2 control-label">تصاویر</label>
                        <input type="file" name="images[]" multiple class="form-control" id="inputImages" placeholder="تصاویر مدنظر خود را انتخاب کنید">
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2">
                            <div class="form-check">
                                <input type="checkbox" name="active" class="form-check-input" id="exampleCheck2">
                                <label class="form-check-label" for="exampleCheck2">پست فعال باشد</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">ایجاد پست جدید</button>
                    <a href="{{ route('posts.index') }}" class="btn btn-default float-left">لغو</a>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
@endcomponent
