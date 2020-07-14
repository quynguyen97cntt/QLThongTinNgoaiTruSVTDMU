@if (!session()->has('tendn'))
    echo "<script>window.location='login'</script>";
@endif
@extends('layouts.master')
@section('master')
<style>
    .modal-backdrop {
        z-index: 1040 !important;
    }

    .modal-dialog {
        margin: 2px auto;
        z-index: 1100 !important;
    }
</style>
<div class="card mt-4 mb-4 container">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-4 float-left" style="font-size: 20px;">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-primary" href="danh-sach-tro"></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Danh sách sinh viên trọ</li>
                            </ol>
                        </nav>
                    </div>
                    
                    <!-- Search bar -->
                    <div class="col-md-4 navbar-nav ml-3 mt-2 pb-3">
                        <form action="{{route('timkiemsvdangtro')}}" method="GET">
                            <div id="custom-search" class="top-search-bar">
                                <input class="form-control" name="timkiemsvtro" type="text" placeholder="Nhập tên sinh viên..">
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
                                        <h2 class="modal-title" id="addModalLabel">Thêm Sinh Viên</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="ThemDSSVTro" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label class="col-form-label font-weight-bold">Số CMND<span
                                                        class="text-danger"> (*)</span></label>
                                                <input type="number" required name="cmnd" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label font-weight-bold">Ngày đến<span
                                                        class="text-danger"> (*)</span></label>
                                                <input type="date" name="ngayden" required value="{{date('Y-m-d')}}"
                                                    class="form-control">
                                            </div>



                                            <div class="form-group">
                                                <label class="col-form-label font-weight-bold">Phòng số<span
                                                        class="text-danger"> (*)</span></label>
                                                <input type="text" name="sophong" required class="form-control">
                                            </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                                        <input type="submit" class="btn btn-success" value="Thêm">
                                    </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- End modal thêm -->

                    </div>
                </div>
            </div>
            <!-- End card Header -->

            <div class="card-body">
                <?php $tongsv = 0; ?>
                @foreach ($SVOTro as $item)
                <?php $tongsv++ ?>
                @endforeach
                <h5>Tổng số: {{$tongsv}} sinh viên đang trọ</h5>
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
                <div class="row table-responsive mx-auto" style="font-size: 16px">
                    <table class="table table-striped">
                        <thead style="background: #3CADF1; color: antiquewhite">
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Họ tên</th>
                                <th scope="col">Ngày sinh</th>
                                <th scope="col">Ngành</th>
                                <th scope="col">Ngày đến</th>
                                <th scope="col">Phòng</th>
                                <th scope="col"></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($SVOTro as $item)

                            <?php
                                            $sua = "sua" . $item->mssv;
                                            $xoa = "xoa" . $item->mssv; ?>
                            <tr>
                                <th scope="row">{{$i++ + ($SVOTro->currentPage() -1)* $pageSize }}</th>
                                <td>{{$item->ho}} {{$item->ten}}</td>
                                <td>{{date('d/m/Y', strtotime($item->ngaysinh))}}</td>
                                <td>{{$item->tenlop}}</td>
                                <td>{{date('d/m/Y', strtotime($item->ngayden))}}</td>
                                <td>{{$item->sophong}}</td>
                                <td>
                                    <div class="dropdown show">
                                        <a class="dropdown-toggle" style="text-decoration: none;" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-plus-circle"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" style="width: 17rem;">
                                            <ul style="list-style: none;"> 
                                                <li data-toggle="modal" data-target="#{{$sua}}">
                                                    <a href="#" class="nav-link"  data-toggle="tooltip" data-placement="left" data-html="true">
                                                        <i class="fa fa-edit fa-lg"></i> Cập nhật
                                                    </a>
                                                </li>
                                                <li data-toggle="modal" data-target="#{{$xoa}}">
                                                    <a href="#" class="nav-link"  data-toggle="tooltip" data-placement="right" data-html="true">
                                                        <i class="fa fa-trash-alt fa-lg"></i> Xoá
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Modal sửa -->

                                    <div class="modal fade" id="{{$sua}}" tabindex="-1" role="dialog"
                                        aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h2 class="modal-title" id="editModalLabel">Cập Nhật Sinh Viên
                                                        </h3>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('SuaDSSVTro',['id' => $item->id])}}"
                                                        method="post">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label class="col-form-label font-weight-bold">Số CMND<span
                                                                    class="text-danger"> (*)</span></label>
                                                            <input type="text" readonly name="cmnd" required
                                                                value="{{$item->cmnd}}" class="form-control">
                                                            <input type="hidden" readonly name="mssv" required
                                                                value="{{$item->mssv}}" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label font-weight-bold">Ngày đến<span
                                                                    class="text-danger"> (*)</span></label>
                                                            <input type="date" name="ngayden" required
                                                                value="{{$item->ngayden}}" class="form-control">
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-form-label font-weight-bold">Ngày
                                                                đi</label>
                                                            <input type="date" name="ngaydi" value="{{$item->ngaydi}}"
                                                                class="form-control">
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="hidden" name="makhutro" class="form-control">
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-form-label font-weight-bold">Phòng số<span
                                                                    class="text-danger"> (*)</span></label>
                                                            <input type="text" name="sophong" required
                                                                value="{{$item->sophong}}" class="form-control">
                                                        </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Đóng</button>
                                                    <input type="submit" class="btn btn-success" value="Cập nhật">
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
                                                <div class="modal-header">
                                                    <h2 class="modal-title" id="deleteModalLabel">Xóa Sinh Viên</h3>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5>Bạn có chắc muốn xóa sinh viên có mã số
                                                        <span>{{$item->mssv}}</span></h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('XoaDSSVTro',['id' => $item->id])}}"
                                                        method="post">
                                                        @csrf
                                                        <button type="button" class="btn btn-danger float-left"
                                                            data-dismiss="modal">Hủy</button>
                                                        <button type="submit" class="btn btn-dark">Xóa</button>
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
                    {{ $SVOTro->links() }}

                </div>
            </div>
    </div>
<div>
</div>
@endsection