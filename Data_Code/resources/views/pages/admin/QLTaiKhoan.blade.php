@extends('layouts.master-admin')
@section('title','Quản lý tài khoản')
@section('master-admin')


<!-- Noi dung -->

<div class="row mb-3"></div>
<div class="card">
    <div class="card-header">
        <div  class="row">
            <div class="col-md-4 float-left" style="font-size: 20px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-primary" href="trang-quan-tri"></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Quản lý tài khoản</li>
                    </ol>
                </nav>
            </div>

            <!-- Search bar -->
            <div class="col-md-5 navbar-nav ml-3">
                <form action="{{route('tim-kiem-tai-khoan')}}" method="GET">
                    <div id="custom-search" class="top-search-bar">
                        <input class="form-control" name="timkiemtk" type="text" placeholder="Tìm kiếm..">
                    </div>
                </form>
            </div>
            <!-- End search bar -->

            <div class="col-md-2 d-flex align-items-center">
                <button class="btn btn-success rounded-circle" data-toggle="modal" data-target="#addModal">
                    <i class="fa fa-plus"></i>
                </button>

                <!-- Modal thêm -->
                <form action="themTK" method="POST">
                    @csrf
                    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="addModalLabel">Thêm Tài Khoản</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="col-form-label font-weight-bold">Tên tài khoản<span class="text-danger"> (*)</span></label>
                                            <input type="text" class="form-control" name="tendangnhap">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="col-form-label font-weight-bold">Mật khẩu<span class="text-danger"> (*)</span></label>
                                            <input type="password" class="form-control" name="matkhau">
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label class="col-form-label font-weight-bold">Quyền<span class="text-danger"> (*)</span></label>
                                            <select name="quyen" class="form-control">
                                                <option value="0">Chủ trọ</option>
                                                <option value="1">Admin</option>
                                                <option value="2">Sinh viên</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Thêm</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- End modal thêm -->

            </div> 
        </div>
    </div>



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
    <!-- <div class="table table-reponsive"> -->
    <div class="card-body">
        <div class="row table-responsive mx-auto" style="font-size: 16px; overflow-x: visible !important">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên tài khoản</th>
                        <th scope="col">Trạng thái</th>

                        <th scope="col">Quyền</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1 ?>
                    @foreach($taikhoan as $item)
                    <?php
                                        $sua = $item->id."sua";
                                        $xoa = $item->id."xoa"; ?>
                    <tr>
                        <th scope="row">{{$i++ + ($taikhoan->currentPage() -1)* $pageSize }}</th>
                        <td>{{$item->tendangnhap}}</td>
                        <td>
                            {{$item->trangthai===0 ? 'Chưa kích hoạt' : ''}}{{$item->trangthai===1 ? 'Đã kích hoạt' : ''}}
                        </td>

                        <td>{{$item->quyen===0 ? 'Chủ trọ' : ''}}{{$item->quyen===1 ? 'Admin' : ''}}{{$item->quyen===2 ? 'Sinh viên' : ''}}</td>
                        <td>

                            <div class="dropdown show">
                                <a class="dropdown-toggle" style="text-decoration: none;" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" style="width: 17rem;">
                                    <ul style="list-style: none;"> 
                                        <li data-toggle="modal" data-target="#{{$sua}}">
                                            <a href="#" class="nav-link" data-toggle="tooltip" data-placement="bottom"
                                                data-html="true"><i class="fa fa-edit fa-lg"></i> Khôi phục mật khẩu
                                            </a>
                                        </li>
                                        <li>
                                            <form class="form-control border-0" action="{{route('suaQuyenTK',['id' => $item->id, 'tendangnhap' => $item->tendangnhap])}}" method="POST">
                                                @csrf
                                                <button href="" class="border-0"><i class="fas fa-exchange-alt"></i> Đổi quyền
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form class="form-control border-0" action="{{route('kichhoatTK',['id' => $item->id, 'tendangnhap' => $item->tendangnhap])}}" method="POST">
                                                @csrf
                                                <button href="" class="border-0"><i class="fas fa-lock-open"></i> Kích hoạt
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form class="form-control border-0" action="{{route('khoaTK',['id' => $item->id, 'tendangnhap' => $item->tendangnhap])}}" method="POST">
                                                @csrf
                                                <button href="" class="border-0"><i class="fas fa-user-lock"></i> Khóa
                                                </button>
                                            </form>
                                        </li>
                                        <li data-toggle="modal" data-target="#{{$xoa}}">
                                            <a href="#" class="nav-link" data-toggle="tooltip" data-placement="right"
                                                data-html="true"><i class="fa fa-trash-alt fa-lg"></i> Xoá
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>


                            <!-- Modal sửa -->

                            <div class="modal fade" id="{{$sua}}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <form action="{{route('suaTK',['id' => $item->id])}}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h2 class="modal-title" id="editModalLabel">Khôi phục mật khẩu</h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <input type="hidden" class="form-control" name="matkhau"
                                                            value="{{$item->tendangnhap}}">
                                            </div>
                                            
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Xác nhận</button>
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Đóng</button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- End modal sửa -->

                            <!-- Modal xóa -->
                            <form action="{{route('xoaTK',['id' => $item->id])}}" method="post">
                                @csrf
                                <div class="modal fade" id="{{$xoa}}" tabindex="-1" role="dialog"
                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="modal-title" id="deleteModalLabel">Xóa Tài Khoản</h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>
                                            <div class="modal-body">
                                                <h5>Bạn có chắc muốn xóa tài khoản <span>"{{$item->tendangnhap}}"</span>
                                                </h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Xóa</button>
                                                <button type="button" class="btn btn-default float-left"
                                                    data-dismiss="modal">Hủy</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- End modal xóa -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-4">
            {{ $taikhoan->links() }}

        </div>
    </div>
</div>
    <!-- </div> -->
    @endsection