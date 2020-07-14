@extends('layouts.master-admin')
@section('title','Đổi mật khẩu admin')
@section('master-admin')
<!-- Noi dung -->

<div class="card">
    <div class="card-header card-header-primary">
        <h5 style="color: #999999">/ Đổi mật khẩu Admin</h5>
    </div>

    <div class="mt-3">
        <div id="container">
            @if ( Session::has('success') )
            <div class="alert alert-success alert-dismissible m-2" role="alert" id="success-alert">
                <strong>{{ Session::get('success') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            @endif

            <!-- Hiển thị thông báo lỗi? -->
            @if ( Session::has('error') )
            <div class="alert alert-danger alert-dismissible" role="alert">
                <strong>{{ Session::get('error') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            @endif
            <form action="doimatkhauadmin" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label font-weight-bold">Mật khẩu cũ:<span class="text-danger">
                            (*)</span></label>
                    <div class="col-sm-6">
                        <input type="password" required class="form-control" name="matkhaucu">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label font-weight-bold">Mật khẩu mới:<span class="text-danger">
                            (*)</span></label>
                    <div class="col-sm-6">
                        <input type="password" required class="form-control" name="matkhaumoi">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label font-weight-bold">Nhập lại mật khẩu mới:<span
                            class="text-danger"> (*)</span></label>
                    <div class="col-sm-6">
                        <input type="password" required class="form-control" name="xacnhanmatkhaumoi">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary float-right mr-3">Xác nhận</button>
            </form>
        </div>
    </div>
</div>
@endsection