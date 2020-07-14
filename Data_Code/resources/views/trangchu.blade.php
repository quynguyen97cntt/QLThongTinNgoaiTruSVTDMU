@extends('layouts.master')
@section('master')
<div class="card">
    <div class="card-body">
        <div class="form-group row d-flex justify-content-center">
            <div class="p-3 m-3 rounded-circle border border-info" style="width: 190px; height: 190px; text-align: center; line-height: 130px; background: #c4ffd6 url('./img/dangnhap.jpg') no-repeat center center fixed;">
                <a class="nav-link text-white navbar-text" href="login"><i  class="fas fa-user"></i> Đăng nhập </a>
            </div>
            <div class="ml-3 p-3 m-3 rounded-circle border border-info" style="width: 190px; height: 190px; text-align: center; line-height: 130px; background: #c4ffd6 url('./img/dangky.jpg') no-repeat center center fixed;">
                <a class="nav-link text-white navbar-text" href="signup"><i class="fas fa-user-plus"></i> Đăng ký </a>
            </div>
        </div>
    </div>
</div>
@endsection