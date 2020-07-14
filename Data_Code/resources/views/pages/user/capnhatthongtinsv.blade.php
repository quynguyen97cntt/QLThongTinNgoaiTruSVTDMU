@extends('layouts.master')
@section('master')
<div class="card mt-4 mb-4 container">
    <div class="pl-5 pr-5 pt-3 pb-3">

        <!-- Hiển thị thông báo thành công>-->
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
        @foreach($sinhvien as $sv)
            <form action="{{route('capnhatTTSV',['mssv' => session('mssv')])}}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="hosv" class="font-weight-bold">Họ và tên lót:</label>
                    <input type="text" class="form-control" name="hosv" required id="hosv" value="{{$sv->ho}}" placeholder="Họ và tên lót...">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tensv" class="font-weight-bold">Tên:</label>
                        <input type="text" class="form-control" name="tensv" required id="tensv" value="{{$sv->ten}}" placeholder="Tên...">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="gioitinh" class="font-weight-bold">Giới tính:</label>
                        <select name="gioitinh" class="form-control">
                            <option value="Nam" @if($sv->gioitinh==='Nam') selected="selected" @endif>Nam</option>
                            <option value="Nữ" @if($sv->gioitinh==='Nữ') selected="selected" @endif>Nữ</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="ngaysinh" class="font-weight-bold">Ngày sinh: </label>
                        <input type="date" class="form-control" name="ngaysinh" required value="{{$sv->ngaysinh}}" id="ngaysinh">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="noisinh" class="font-weight-bold">Nơi sinh:</label>
                        <input type="text" class="form-control" name="noisinh" required id="noisinh" value="{{$sv->noisinh}}" placeholder="Nơi sinh...">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cmnd" class="font-weight-bold">CMND/thẻ căn cước:</label>
                        <input type="number" class="form-control" name="cmnd" required id="cmnd" value="{{$sv->cmnd}}" placeholder="CMND/thẻ căn cước...">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email" class="font-weight-bold">Email:</label>
                        <input type="email" class="form-control" name="email" required id="email" value="{{$sv->email}}" placeholder="Email...">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="dienthoai" class="font-weight-bold">Điện thoại:</label>
                        <input type="number" class="form-control" name="dienthoai" value="{{$sv->dienthoai}}" required id="dienthoai"
                            placeholder="Điện thoại...">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="diachi" class="font-weight-bold">Hộ khẩu thường trú:</label>
                        <textarea class="form-control" required rows="6" style="resize: none" name="diachi"
                            required id="diachi">{{$sv->hokhau}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lop" class="font-weight-bold">Lớp:</label>
                        <select name="lop" class="form-control">
                            @foreach($lop as $l)
                                <option value="{{$l->malop}}" @if(($sv->lop) === ($l->malop)) selected="selected" @endif>{{$l->malop}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        @endforeach
    </div>
</div>
@endsection