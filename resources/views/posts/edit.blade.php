@component('layout.content', ['title' => 'ویرایش پست'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">داشبورد</a></li>
        <li class="breadcrumb-item active">ویرایش پست</li>
    @endslot

    @slot('scripts')
        <script>
            let deletingImages = [];
            $(".delete-image").click(function(e){
                e.preventDefault();
                var id = $(this).data("id");
                deletingImages.push(id);
                var target = e.target;
                target.closest('.col-md-3').remove();

                // var token = $("meta[name='csrf-token']").attr("content");
                // $.ajax(
                //     {
                //         url: "images/"+id,
                //         type: 'DELETE',
                //         data: {
                //             "id": id,
                //             "_token": token,
                //         },
                //         complete: function () {
                //             target.closest('.col-md-3').remove();
                //         }
                //     });
                });
            $('#edit_post').submit(function(e){
                $('#deleting_images').val(deletingImages);
                // console.log(deletingImages);
                return true;
            })
        </script>
    @endslot


    <div class="row">
        <div class="card card-info col-md-10 offset-md-1 px-0">
            <div class="card-header">
                <h3 class="card-title">فرم ویرایش پست</h3>
            </div>
            <!-- /.card-header -->

        @include('layout.errors')

        <!-- form start -->
            <form class="form-horizontal" id="edit_post" method="post" action="{{ route('posts.update' , ['post' => $post->id])}}"  enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="card-body">
                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">عنوان پست</label>
                        <input type="text" name="title" class="form-control" id="inputName3" value="{{ old('title') ?? $post->title }}">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">توضیحات</label>
                        <input type="text" name="description" class="form-control" id="inputEmail3" value="{{ old('description') ?? $post->description }}">
                    </div>
                    <div class="form-group">
                        <label for="inputBody" class="col-sm-2 control-label">متن اصلی</label>
                        <textarea name="body" class="form-control" id="inputBody" cols="20" rows="10">{{ old('body') ?? $post->body }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputImages" class="col-sm-2 control-label">تصاویر</label>
                        <input type="file" name="images[]" multiple class="form-control" id="inputImages" placeholder="تصاویر مدنظر خود را انتخاب کنید">
                        <input type="hidden" id="deleting_images" name="deletingImages[]">
                        <hr>
                        <div class="row images-box">
                            <div class="row col-12 mb-2">
                                <span class="px-2">تصاویر آپلود شده</span>
                            </div>
                            <div class="row col-12">
                            @forelse ($images as $image)
                                <div class="col-md-3 col-12 px-2 mb-2">
                                    <div class="background-images" style="background-image: url('{{ url($image->path)}}');">
                                        <a href="#" class="delete-image" data-id="{{ $image->id }}" >حذف تصویر</a>

                                    </div>
                                </div>
                            @empty
                                <p> ... تصویری وجود ندارد</p>
                            @endforelse
                            </div>
                        </div>
                        <hr>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2">
                            <div class="form-check">
                                <input type="checkbox" name="active" class="form-check-input" id="exampleCheck2" @if(old('active') || $post->is_active) checked @endif>
                                <label class="form-check-label" for="exampleCheck2">پست فعال باشد</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">اعمال تغییرات</button>
                    <a href="{{ route('posts.index') }}" class="btn btn-default float-left">لغو</a>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
@endcomponent
