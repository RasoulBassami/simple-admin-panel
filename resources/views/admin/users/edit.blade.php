@component('admin.layout.content', ['title' => 'ویرایش کاربر'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
        <li class="breadcrumb-item active">ویرایش کاربر</li>
    @endslot

    @slot('scripts')
        <script>
            var checkboxes = $("#permission-selection").find("input[type='checkbox']");

            $("#adminCheck").change(function() {
                if ($(this).is(':checked')) {
                    checkboxes.each(function(){
                        jQuery(this).prop('disabled', false);
                    });
                } else {
                    checkboxes.each(function(){
                        jQuery(this).prop('disabled', true);
                    });
                }
            });
        </script>
    @endslot
    <div class="row">
        <div class="card card-info col-md-10 offset-md-1 px-0">
            <div class="card-header">
                <h3 class="card-title">فرم ایجاد کاربر</h3>
            </div>
            <!-- /.card-header -->

        @include('admin.layout.errors')

        <!-- form start -->
            <form class="form-horizontal" method="post" action="{{ route('admin.users.update', ['user' => $user->id])}}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="card-body">
                    <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">نام و نام خانوادگی</label>

                        <div class="col-sm-10">
                            <input type="text" name="name" value="{{ old('name') ?? $user->name }}" class="form-control" id="inputName" placeholder="نام و نام خانوادگی کاربر را وارد کنید">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputUserName" class="col-sm-2 control-label">نام کاربری</label>

                        <div class="col-sm-10">
                            <input type="text" name="username" value="{{ old('username') ?? $user->username }}" class="form-control" id="inputUserName" placeholder="نام کاربری کاربر را وارد کنید">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-2 control-label">پسورد</label>

                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" id="inputPassword" autocomplete="off" placeholder="ویرایش پسورد اختیاری است">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPasswordConfirm" class="col-sm-2 control-label"> تکرار پسورد</label>

                        <div class="col-sm-10">
                            <input type="password" name="password_confirmation" class="form-control" id="inputPasswordConfirm" placeholder="پسورد را وارد کنید">
                        </div>
                    </div>

                    @can('updateAdmin', $user)
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="form-check">
                                    <label for="adminCheck">
                                        <input type="checkbox" name="is_admin" {{ $user->isAdmin() ? ' checked' : '' }} class="form-check-input" id="adminCheck">
                                        کاربر ادمین باشد
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <label><strong>دسترسی ها</strong></label><br>
                            <div class="row" id="permission-selection">
                                @foreach($admin_permissions as $permission)
                                    <div class="col-md-3 col-12 px-2 mb-2">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="permission[]" class="ml-1" value="{{ $permission->id }}"
                                                {{ $user->hasPermission($permission->name) ? ' checked' : '' }}
                                                {{ !$user->isAdmin() ? ' disabled' :  ''}}>
                                            {{ $permission->label }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endcan
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">ویرایش کاربر</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-default float-left">لغو</a>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
@endcomponent
