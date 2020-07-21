@extends('layouts.master-admin')
@section('title','Quản lý sinh viên')
@section('master-admin')
<script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if (exist) {
        alert(msg);
    }
</script>


<!-- Noi dung -->

<div class=" mb-3"></div>
<div class="card">
    <div class=" card-header">
        <div class="row">
            <div class="col-md-4 float-left" style="font-size: 20px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-primary" href="trang-quan-tri"></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Quản lý thông tin sinh viên</li>
                    </ol>
                </nav>
            </div>

            <!-- Tìm kiếm sinh viên -->
            <div class="col-md-5 navbar-nav ml-3">
                <form action="{{route('tim-kiem-sinh-vien')}}" method="GET">
                    <div id="custom-search" class="top-search-bar">
                        <input class="form-control" name="timkiemsv" type="text" placeholder="Nhập tên, mã SV hoặc mã lớp...">
                    </div>
                </form>
            </div>
            <!-- End Tìm kiếm sinh viên -->

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
                                <h2 class="modal-title" id="addModalLabel">Thêm Sinh Viên</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>

                            <div class="modal-body">
                                <form action="themSV" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="col-form-label font-weight-bold">MSSV<span
                                                    class="text-danger"> (*)</span></label>
                                            <input type="text" name="mssv" required class="form-control">
                                        </div>

                                        <div class="form-group col-6">
                                            <label class="col-form-label font-weight-bold">Số
                                                điện thoại<span class="text-danger"> (*)</span></label>
                                            <input type="number" name="dienthoai" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="col-form-label font-weight-bold">Họ
                                                <span class="text-danger"> (*)</span></label>
                                            <input type="text" name="ho" required class="form-control">
                                        </div>

                                        <div class="form-group col-6">
                                            <label class="col-form-label font-weight-bold">Email<span
                                                    class="text-danger"> (*)</span></label>
                                            <input type="text" name="email" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="col-form-label font-weight-bold">Tên
                                                sinh viên<span class="text-danger"> (*)</span></label>
                                            <input type="text" name="ten" required class="form-control">
                                        </div>

                                        <div class="form-group col-6">
                                            <label class="col-form-label font-weight-bold">Giới
                                                tính:<span class="text-danger"> (*)</span></label></label>
                                            <select name="gioitinh" class="form-control">
                                                <option value="Nam">Nam</option>
                                                <option value="Nữ">Nữ</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="col-form-label font-weight-bold">Lớp<span class="text-danger">
                                                    (*)</span></label>
                                            <select name="lop" class="form-control">
                                                @foreach ($lop as $l)
                                                    <option value="{{$l->malop}}">{{$l->malop}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="col-form-label font-weight-bold">Ngày
                                                sinh:<span class="text-danger">(*)</span></label>
                                            <input type="date" name="ngaysinh" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="col-form-label font-weight-bold">Địa chỉ
                                                <span class="text-danger"> (*)</span></label>
                                            <textarea type="text" name="diachi" required class="form-control" style="resize: none" rows="4"></textarea>
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="col-form-label font-weight-bold">Tạm trú</label>
                                            <textarea type="text" name="tamtru" class="form-control" style="resize: none" rows="4"></textarea>
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

    <!-- Thông báo tìm kiếm -->

    <!-- end Thông báo tìm kiếm -->
    <!-- <div class="table table-reponsive"> -->
    <div class="card-body">

        <div class="row mx-auto">
            <form action="{{ route('nhapdssv') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="btn mb-2">
                <button class="btn btn-success ml-2 mr-2">Nhập dữ liệu</button>
                <a class="btn btn-primary mr-2" href="{{ route('xuatdssv') }}">Xuất dữ liệu</a>
            </form>
            <form action="{{ route('xoasinhvienlop') }}" method="POST" class="mt-1" enctype="multipart/form-data">
                @csrf
                <select name="xoasvlop" class="border border-secondary rounded" style="height: 70%">
                    @foreach ($lop as $l)
                        <option value="{{$l->malop}}">{{$l->malop}}</option>
                    @endforeach
                </select>
                <button class="btn ml-2 mr-2">Xoá sinh viên lớp</button>
                <a class="btn" href="{{ route('xoatatcasinhvien') }}">Xoá tất cả</a>
            </form>
        </div>

        <div>Tổng số: <?php echo $tongsl; ?> sinh viên</div>
        <div class="row table-responsive mx-auto" style="font-size: 16px">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">MSSV</th>
                        <th scope="col">Tên sinh viên</th>
                        <th scope="col">Lớp</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>

                    <?php $i=1 ?>
                    @foreach ($student as $item)
                    <?php $them = $item->mssv."them";
                                        $sua = $item->mssv."sua";
                                        $xoa = $item->mssv."xoa"; ?>
                    <tr>


                        <th scope="row">{{$i++ + ($student->currentPage() -1)* $pageSize }}</th>
                        <td>{{$item->mssv}}</td>
                        <td>
                            <form action="thong-tin-tro" class="mb-0" method="post">
                                @csrf
                                <input type="hidden" name="getmssv" value="{{$item->mssv}}">
                                <input type="submit" class="btn btn-link pl-0" style="font-size: 1rem; padding-top:0"
                                    value="{{$item->ho}} {{$item->ten}}" data-toggle="tooltip" data-html="true"
                                    data-placement="top" title="Chi tiết quá trình trọ">
                                </button>
                            </form>
                        </td>
                        <td>{{$item->lop}}</td>
                        <td>{{$item->dienthoai}}</td>
                        <td>


                            <div class="dropdown show">
                                <a class="dropdown-toggle" style="text-decoration: none;" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" style="width: 17rem;">
                                    <ul style="list-style: none;">
                                        <li data-toggle="modal" data-target="#{{$them}}">
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


                            <!-- Modal chi tiết -->

                            <div class="modal fade" id="{{$them}}" tabindex="-1" role="dialog"
                                aria-labelledby="detailModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title" id="detailModalLabel">Thông
                                                Tin Chi Tiết Sinh Viên</h3>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="row">
                                                    <div class="form-group col-6">
                                                        <label class="col-form-label font-weight-bold">MSSV:</label>
                                                        <input type="text" class="form-control" value="{{$item->mssv}}"
                                                            disabled>
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label class="col-form-label font-weight-bold">Tên
                                                            sinh viên:</label>
                                                        <input type="text" class="form-control" id="tensv-name"
                                                            value="{{$item->ho}} {{$item->ten}}" disabled>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-6">
                                                        <label class="col-form-label font-weight-bold">Số
                                                            điện thoại:</label>
                                                        <input type="text" class="form-control"
                                                            value="{{$item->dienthoai}}" disabled>
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label class="col-form-label font-weight-bold">Ngày
                                                            sinh:</label>
                                                        <input type="date" class="form-control"
                                                            value="{{$item->ngaysinh}}" disabled>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-6">
                                                        <label class="col-form-label font-weight-bold">Giới
                                                            tính:</label>
                                                        <input type="text" class="form-control"
                                                            value="{{$item->gioitinh}}" disabled>
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label class="col-form-label font-weight-bold">CMND/thẻ căn cước:</label>
                                                        <input type="text" class="form-control"
                                                            value="{{$item->cmnd}}" disabled>
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label class="col-form-label font-weight-bold">Email:</label>
                                                        <input type="text" class="form-control" value="{{$item->email}}"
                                                            disabled>
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label class="col-form-label font-weight-bold">Lớp:</label>
                                                        <input type="text" class="form-control"
                                                            value="{{$item->lop}}" disabled>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-6">
                                                        <label class="col-form-label font-weight-bold">Địa chỉ</label>
                                                        <textarea type="text" disabled class="form-control" style="resize: none" rows="4">{{$item->hokhau}}</textarea>
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label class="col-form-label font-weight-bold">Tạm trú</label>
                                                        <textarea  type="text" disabled class="form-control" style="resize: none" rows="4">{{$item->tamtru}}</textarea>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Huỷ</button>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- End modal chi tiết -->

                            <!-- Modal sửa -->

                            <div class="modal fade" id="{{$sua}}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('suaSV',['mssv' => $item->mssv])}}" method="post">
                                            @csrf
                                            <div class="modal-header">
                                                <h2 class="modal-title" id="editModalLabel">Cập Nhật Sinh Viên</h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="row">
                                                    <div class="form-group col-6">
                                                        <label class="col-form-label font-weight-bold">MSSV: <span class="text-danger"> (*)</span></label>
                                                        <input type="text" class="form-control" required value="{{$item->mssv}}"
                                                            name="mssv">
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label class="col-form-label font-weight-bold">Họ: <span class="text-danger"> (*)</span></label>
                                                        <input type="text" class="form-control" required value="{{$item->ho}}"
                                                            name="ho">
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="form-group col-6">
                                                        <label class="col-form-label font-weight-bold">Tên: <span class="text-danger"> (*)</span></label>
                                                        <input type="text" class="form-control" required value="{{$item->ten}}"
                                                            name="ten">
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label class="col-form-label font-weight-bold">Ngày
                                                            sinh: <span class="text-danger"> (*)</span></label>
                                                        <input type="date" class="form-control" required
                                                            value="{{$item->ngaysinh}}" name="ngaysinh">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-6">
                                                        <label class="col-form-label font-weight-bold">Giới
                                                            tính: <span class="text-danger"> (*)</span></label>

                                                        <select name="gioitinh" class="form-control">
                                                            <option selected hidden value="{{$item->gioitinh}}">
                                                                {{ $item->gioitinh=='Nam' ? 'Nam' : 'Nữ' }}</option>

                                                            <option value="Nam">Nam</option>
                                                            <option value="Nữ">Nữ</option>

                                                        </select>
                                                    </div>

                                                <div class="form-group col-6">
                                                    <label class="col-form-label font-weight-bold">Email: <span class="text-danger"> (*)</span></label>
                                                    <input type="text" class="form-control" required value="{{$item->email}}"
                                                        name="email">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label class="col-form-label font-weight-bold">Lớp<span class="text-danger"> (*)</span></label>
                                                    <select name="lop" class="form-control">
                                                        @foreach ($lop as $l)
                                                            <option value="{{$l->malop}}" @if($item->lop===$l->malop) selected="selected" @endif>{{$l->malop}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label class="col-form-label font-weight-bold">Số điện thoại: <span class="text-danger"> (*)</span></label>
                                                    <input type="text" class="form-control" required value="{{$item->dienthoai}}"
                                                        name="dienthoai">
                                                </div>
                                                
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label class="col-form-label font-weight-bold">Địa chỉ: <span class="text-danger"> (*)</span></label>
                                                    <textarea type="text" class="form-control" required rows="4" style="resize: none" name="diachi">{{$item->hokhau}}</textarea>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label class="col-form-label font-weight-bold">Tạm trú:</label>
                                                    <textarea type="text" class="form-control" rows="4" style="resize: none" name="tamtru">{{$item->tamtru}}</textarea>
                                                </div>
                                            </div>

                                    </div>
                                    <div class="modal-footer">


                                        <button type="submit" class="btn btn-success">Cập nhật</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Huỷ</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
        </div>

        <!-- End modal sửa -->

        <!-- Modal xóa -->

        <div class="modal fade" id="{{$xoa}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="deleteModalLabel">Xóa Thông
                            Tin Sinh Viên</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body mx-auto">
                        <span>Bạn có chắc muốn xóa sinh viên này?</span>
                    </div>
                    <div class="modal-footer float-left ">
                        <form action="{{ route('xoaSV',['mssv' => $item->mssv])}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger">Xóa</button>
                            <button type="button" class="btn btn-default " data-dismiss="modal">Hủy</button>

                        </form>
                    </div>
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
        {{ $student->links() }}

    </div>
</div>
</div>
<!-- </div> -->
@endsection