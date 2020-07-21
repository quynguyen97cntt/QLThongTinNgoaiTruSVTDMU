@extends('layouts.master-admin')
@section('title','Quản lý khu trọ')
@section('master-admin')
@if (!session()->has('tenadmin'))
    echo "<script>window.location='login'</script>";
@endif
    <!-- Nội dung -->
    <div class="row mb-3"></div>
<div class="card">
    <div class="card-header">
        <div  class="row">
            <div class="col-md-4 float-left" style="font-size: 20px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-primary" href="trang-quan-tri"></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Quản lý thông tin cán bộ</li>
                    </ol>
                </nav>
            </div>

            <!-- Search bar -->
            <div class="col-md-5 navbar-nav ml-3">
                <form action="{{route('tim-kiem-can-bo')}}" method="GET">
                    <div id="custom-search" class="top-search-bar">
                        <input class="form-control" name="timkiemcb" type="text" placeholder="Nhập tên, mã cán bộ...">
                    </div>
                </form>
            </div>
            <!-- End search bar -->

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
                                <h2 class="modal-title" id="addModalLabel">Thêm Thông Báo</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>

                            <div class="modal-body">
                                <form action="themTTCB" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label class="col-form-label font-weight-bold">ID:</label>
                                            <input type="text" class="form-control" id="id" name="id" value="">
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label class="col-form-label font-weight-bold">Họ tên:</label>
                                            <input type="text" class="form-control" id="hoten" name="hoten" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label class="col-form-label font-weight-bold">Giới tính:</label>
                                            <select name="gioitinh" class="form-control">
                                                <option value="Nam">Nam</option>
                                                <option value="Nữ">Nữ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label class="col-form-label font-weight-bold">Ngày sinh:</label>
                                            <input type="date" class="form-control" id="ngaysinh" name="ngaysinh" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label class="col-form-label font-weight-bold">Số điện thoại:</label>
                                            <input type="number" class="form-control" id="sodienthoai" name="sodienthoai" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label class="col-form-label font-weight-bold">Email:</label>
                                            <input type="email" class="form-control" id="email" name="email" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label class="col-form-label font-weight-bold">CMND/ Thẻ căn cước:</label>
                                            <input type="number" class="form-control" id="cmnd" name="cmnd" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label class="col-form-label font-weight-bold">Địa chỉ:</label>
                                            <textarea rows="2" class="form-control" id="diachi" name="diachi" cols="20" style="font-weight: bold; color: #007bff"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label class="col-form-label font-weight-bold">Khoa:</label>
                                            <select name="idKhoa" class="form-control">
                                                @foreach ($khoa as $kh)
                                                    <option value="{{$kh->makhoa}}">{{$kh->tenkhoa}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label class="col-form-label font-weight-bold">CT Đào tạo:</label>
                                            <select name="CTDaoTao" class="form-control">
                                                @foreach ($ctdaotao as $ctdt)
                                                    <option value="{{$ctdt->tenct}}">{{$ctdt->tenct}}</option>
                                                @endforeach
                                            </select>
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

    <div class="ml-4 mb-3">Tổng số: <?php echo $tongsl; ?> cán bộ</div>
    <!-- <div class="table table-reponsive"> -->
    <div class="card-body">

        <div class="row table-responsive mx-auto" style="font-size: 16px">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                    <form action="" method="GET" id="frmSXNgoaiTru">
                    @csrf
                    <input type="hidden"  name="cotsxnt" id="cotsxnt" value="">
                        <th scope="col">#</th>
                        <th scope="col">Họ tên</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Email</th>
                        <th scope="col">CT Đào tạo</th>
                        <th scope="col"></th>
                    <form>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1 ?>
                    @foreach($canbo as $item)
                    <?php
                        $chitiet = $item->id."chitiet";
                        $sua = $item->id."sua";
                        $xoa = $item->id."xoa"; ?>
                    <tr>
                        <th scope="row">{{$i++ + ($canbo->currentPage() -1)* $pageSize }}</th>
                        <td><b style="color: #007bff">{{$item->hoten}}</b></td>
                        <td>
                            {{$item->sodienthoai}}
                        </td>
                        <td>
                            {{$item->email}}
                        </td>
                        <td>
                            {{$item->CTDaoTao}}
                        </td>

                        <td>
                        <div class="dropdown show">
                                <a class="dropdown-toggle" style="text-decoration: none;" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" style="width: 17rem;">
                                    <ul style="list-style: none;">
                                        <li data-toggle="modal" data-target="#{{$chitiet}}">
                                            <a href="#" class="nav-link" data-toggle="tooltip" data-html="true"
                                                data-placement="left"><i class="fas fa-eye fa-lg"></i> Chi tiết
                                            </a>
                                        </li>
                                        <li data-toggle="modal" data-target="#{{$sua}}">
                                            <a href="#" class="nav-link" data-toggle="tooltip" data-placement="bottom"
                                                data-html="true"><i class="fa fa-edit fa-lg"></i> Cập nhật
                                            </a>
                                        </li>
                                        <li data-toggle="modal" data-target="#{{$xoa}}">
                                            <a href="#" class="nav-link" data-toggle="tooltip" data-placement="right"
                                                data-html="true"><i class="fa fa-trash-alt fa-lg"></i> Loại bỏ
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Modal thông tin -->

                            <div class="modal fade" id="{{$chitiet}}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="modal-title" id="editModalLabel">Thông tin chi tiết cán bộ</h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <input type="hidden" class="form-control" name="idCanbo"
                                                            value="{{$item->id}}">
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">ID:</label>
                                                            <input type="text" class="form-control" id="id" value="{{$item->id}}"
                                                                disabled>
                                                        </div> 
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Họ tên:</label>
                                                            <input type="text" class="form-control" id="id" value="{{$item->hoten}}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Giới tính:</label>
                                                            <input type="text" class="form-control" id="gioitinh" value="{{$item->gioitinh}}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Ngày sinh:</label>
                                                            <input type="text" class="form-control" id="ngaysinh" value="{{$item->ngaysinh}}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Số điện thoại:</label>
                                                            <input type="text" class="form-control" id="sodienthoai" value="{{$item->sodienthoai}}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Email:</label>
                                                            <input type="text" class="form-control" id="email" value="{{$item->email}}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">CMND/ Thẻ căn cước:</label>
                                                            <input type="text" class="form-control" id="cmnd" value="{{$item->cmnd}}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Địa chỉ:</label>
                                                            <textarea rows="2" disabled class="form-control" id="diachi" cols="20" style="font-weight: bold; color: #007bff">{{$item->diachi}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">ID Khoa:</label>
                                                            <input type="text" class="form-control" id="idKhoa" value="{{$item->idKhoa}}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">CT Đào tạo:</label>
                                                            <input type="text" class="form-control" id="CTDaoTao" value="{{$item->CTDaoTao}}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Đóng</button>

                                            </div>
                                    </div>
                                </div>
                            </div>

                            <!-- End Modal thông tin -->

                            <!-- Modal Sửa -->
                                <div class="modal fade" id="{{$sua}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="modal-title" id="editModalLabel">Sửa Thông Tin Cán Bộ</h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>

                                            <div class="modal-body">
                                                <form action="suaTTCB" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <input type="hidden" class="form-control" id="id" name="id" value="{{$item->id}}">
                                                            <label class="col-form-label font-weight-bold">ID:</label>
                                                            <input type="text" class="form-control" id="id" name="idCanBo" value="{{$item->id}}" disabled>
                                                        </div> 
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Họ tên:</label>
                                                            <input type="text" class="form-control" id="hoten" name="hoten" value="{{$item->hoten}}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Giới tính:</label>
                                                            <select name="gioitinh" class="form-control">
                                                                <option selected  value="{{$item->gioitinh}}">
                                                                    {{ $item->gioitinh=='Nam' ? 'Nam' : 'Nữ' }}
                                                                </option>
                                                                <option value="Nam">Nam</option>
                                                                <option value="Nữ">Nữ</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Ngày sinh:</label>
                                                            <input type="date" class="form-control" id="ngaysinh" name="ngaysinh" value="{{$item->ngaysinh}}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Số điện thoại:</label>
                                                            <input type="number" class="form-control" id="sodienthoai" name="sodienthoai" value="{{$item->sodienthoai}}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Email:</label>
                                                            <input type="email" class="form-control" id="email" name="email" value="{{$item->email}}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">CMND/ Thẻ căn cước:</label>
                                                            <input type="number" class="form-control" id="cmnd" name="cmnd" value="{{$item->cmnd}}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Địa chỉ:</label>
                                                            <textarea rows="2" class="form-control" id="diachi" name="diachi" cols="20" style="font-weight: bold; color: #007bff">{{$item->diachi}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">ID Khoa:</label>
                                                            <select name="idKhoa" class="form-control">
                                                                @foreach ($khoa as $kh)
                                                                    <option value="{{$kh->makhoa}}" @if($item->idKhoa===$kh->makhoa) selected="selected" @endif>{{$kh->tenkhoa}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">CT Đào tạo:</label>
                                                            <select name="CTDaoTao" class="form-control">
                                                                @foreach ($ctdaotao as $ctdt)
                                                                    <option value="{{$ctdt->tenct}}" @if($item->CTDaoTao===$ctdt->tenct) selected="selected" @endif>{{$ctdt->tenct}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                

                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn btn-success" value="Cập nhật">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Huỷ</button>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <!-- End modal Sửa -->

                            <!-- Modal xóa -->
                            <form action="xoaCB" method="POST">
                                @csrf
                                <div class="modal fade" id="{{$xoa}}" tabindex="-1" role="dialog"
                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="modal-title" id="deleteModalLabel">Xóa Thông Tin Cán Bộ</h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="{{$item->id}}" >
                                                <h5>Bạn có chắc muốn xóa thông tin cán bộ: <span>"{{$item->id}}"</span>
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
            {{ $canbo->links() }}

        </div>
    </div>
</div>
    <!-- Kết thúc nội dung -->

    <script src={{ url('ckadmin/ckeditor/ckeditor.js') }}></script>
    <script>
        CKEDITOR.replace( 'text', {filebrowserBrowseUrl: '{{ route('ckfinder_browser') }}',} );
    </script>
    @include('ckfinder::setup')
    
@endsection