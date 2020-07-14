@extends('layouts.master-admin')
@section('title','Quản lý khu trọ')
@section('master-admin')

<!-- Noi dung -->

<div class="row mb-3"></div>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-4 float-left" style="font-size: 20px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-primary" href="trang-quan-tri"></a> </li>
                        <li class="breadcrumb-item active" aria-current="page">Quản lý khu trọ</li>
                    </ol>
                </nav>
            </div>

            <!-- Tìm kiếm khu nhà trọ -->

            <div class="col-md-5 navbar-nav ml-3">
                <form action="{{route('tim-kiem-khu-tro')}}" method="GET">
                    <div id="custom-search" class="top-search-bar">
                        <input class="form-control" name="timkhutro" type="text" placeholder="Nhập tên chủ trọ, tên nhà trọ, mã SV...">
                    </div>
                </form>
            </div>
            <!-- Tìm kiếm khu nhà trọ -->

            <div class="col-md-2 d-flex align-items-center">
                <button class="btn btn-success rounded-circle" data-toggle="modal" data-target="#addModal">
                    <i class="fa fa-plus"></i>
                </button>

                <!-- Modal thêm -->
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="addModalLabel">Thêm Khu Trọ</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>

                            <div class="modal-body">
                            <form action="{{route('DangKyKhuTro')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="col-form-label font-weight-bold">Tên nhà trọ<span
                                                    class="text-danger"> (*)</span></label>
                                                    <input type='text' class='form-control' required name='txtTennhatro'>
                                        </div>

                                        <div class="form-group col-6">
                                            <label class="col-form-label font-weight-bold">Họ và tên lót
                                                <span class="text-danger"> (*)</span></label>
                                                <input type='text' class='form-control' required name='txtHotenlot'>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="col-form-label font-weight-bold">Tên
                                                <span class="text-danger"> (*)</span></label>
                                                <input type='text' class='form-control' required name='txtTen'>
                                        </div>

                                        <div class="form-group col-6">
                                            <label class="col-form-label font-weight-bold">CMND/Thẻ căn cước<span
                                                    class="text-danger"> (*)</span></label>
                                                    <input type='number' class='form-control' required name='txtCmnd'>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="col-form-label font-weight-bold">Địa chỉ
                                                <span class="text-danger"> (*)</span></label>
                                            <textarea type="text" name="txtDiachi" required class="form-control" placeholder="Số 6, Trần Văn Ơn, Thủ Dầu Một, Bình Dương" style="resize: none" rows="4"></textarea>
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="col-form-label font-weight-bold">Điện thoại
                                                <span class="text-danger"> (*)</span></label>
                                                <input type='number' class='form-control' required name='txtSodienthoai'>
                                        </div>
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-success" value="Thêm">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Huỷ</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- End modal thêm -->
            </div>

        </div>
    </div>
    <?php //Hiển thị thông báo thành công?>
    @if ( Session::has('success') )
    <div class="alert alert-success alert-dismissible m-2" role="alert" id="success-alert">
        <strong>{{ Session::get('success') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
    </div>
    @endif

    <?php //Hiển thị thông báo lỗi?>
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

    <div class="row mx-auto">
            <form action="{{ route('nhapnhatro') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="btn mb-2">
                <button class="btn btn-success ml-2 mr-2">Nhập dữ liệu</button>
                <a class="btn btn-primary mr-2" href="{{ route('xuatnhatro') }}">Xuất dữ liệu</a>
            </form>
        </div>

        <div class="row table-responsive mx-auto" style="font-size: 16px">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="center">Mã khu trọ</th>
                        <th scope="col">Tên khu trọ</th>
                        <th scope="col">Chủ trọ</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                                    $i=1
                                ?>
                    @foreach ($dsNhatro as $nhatro )
                    <?php 
                                        $them = $nhatro->gid."them";
                                        $sua = $nhatro->gid."$them";
                                        $xoa = $nhatro->gid."xoa";
                                        $dssvotro=$nhatro->gid."dssvotro"?>
                    <tr>
                        <td scope="row">{{$i++ + ($dsNhatro->currentPage() -1)* $pageSize }}</th>
                        <td scope="row" class="text-center">{{$nhatro->gid}}</td>
                        <td scope="row">{{$nhatro->tennhatro}}</td>
                        <td scope="row">{{$nhatro->tenchutro}}</td>
                        <td scope="row" class="text-wrap" style="width: 20em;">{{$nhatro->diachi}}</td>
                        <td scope="row">{{$nhatro->sodienthoai}}</td>
                        <td scope="row">

                            <div class="dropdown show">
                                <a class="dropdown-toggle" style="text-decoration: none;" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                              
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" style="width: 17rem;">
                                    <ul style="list-style: none;">
                                        <li>
                                            <form class="form-control border-0" action="{{ route('DSSVotro',['gid' => $nhatro->gid])}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="idChuTro" value="{{$nhatro->gid}}" >
                                                <button class="border-0" data-toggle="tooltip" data-placement="right" data-html="true">
                                                    <i class="fas fa-th-list"></i> Danh sách sinh viên
                                                </button >
                                            </form>
                                        </li>
                                        <li data-toggle="modal" data-target="#{{$sua}}">
                                            <a href="#" class="nav-link" data-toggle="tooltip" data-placement="left"
                                                data-html="true"><i class="fa fa-edit fa-lg"></i> Cập nhật</a>
                                        </li>
                                        <li data-toggle="modal" data-target="#{{$xoa}}">
                                            <a href="#" class="nav-link" data-toggle="tooltip" data-placement="right"
                                                data-html="true"><i class="fa fa-trash-alt fa-lg"></i> Loại bỏ</a>
                                        </li>
                                    </ul>
                                </div>
                              </div>

                            
                            {{-- show list --}}

                            <!-- Modal sửa -->
                            <div class="modal fade" id="{{$sua}}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title" id="editModalLabel">Sửa Thông
                                                Tin Khu Trọ</h3>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('SuaNT',['gid' => $nhatro->gid])}}" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <label class="col-form-label font-weight-bold">Mã khu
                                                        trọ:</label>
                                                    <input type="text" name="tennhatro" value="{{$nhatro->gid}}"
                                                        class="form-control" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label font-weight-bold">Tên khu
                                                        trọ:</label>
                                                    <input type="text" value="{{$nhatro->tennhatro}}" name="tennhatro"
                                                        class="form-control" id="tensv-name">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label font-weight-bold">Họ và tên lót:</label>
                                                    <input type="text" value="{{$nhatro->ho}}" name="ho"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label font-weight-bold">Tên:</label>
                                                    <input type="text" value="{{$nhatro->ten}}" name="ten"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label font-weight-bold">Địa
                                                        chỉ:</label>
                                                    <textarea class="form-control"
                                                        name="diachi">{{$nhatro->diachi}}</textarea>

                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label font-weight-bold">Số điện
                                                        thoại:</label>
                                                    <input type="text" value="{{$nhatro->sodienthoai}}"
                                                        name="sodienthoai" class="form-control">
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Cập nhật</button>
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Đóng</button>

                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End modal sửa -->

                            <!-- Modal xóa -->

                            <div class="modal fade" id="{{$xoa}}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('XoaNT',['gid' => $nhatro->gid])}}" method="post">
                                            @csrf
                                            <div class="modal-header">
                                                <h2 class="modal-title" id="deleteModalLabel">Xóa Thông
                                                    Tin Khu Trọ</h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>


                                            <div class="modal-footer">
                                                <input type="submit" class="btn btn-danger" value="Xóa">
                                                <button type="button" class="btn btn-default float-left"
                                                    data-dismiss="modal">Hủy</button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End modal xóa -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-4">
        {{ $dsNhatro->links() }}

    </div>

    </div>
    <!-- </div> -->
</div>

@endsection