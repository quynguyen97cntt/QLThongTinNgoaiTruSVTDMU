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
                        <li class="breadcrumb-item active" aria-current="page">Quản lý thông báo</li>
                    </ol>
                </nav>
            </div>

            <!-- Search bar -->
           
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
                                <form action="themTB" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label class="col-form-label font-weight-bold">Tiêu đề<span
                                                    class="text-danger"> (*)</span></label>
                                            <input type="text" name="tieude" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label class="col-form-label font-weight-bold">Nội dung
                                                <span class="text-danger"> (*)</span></label>

                                            <textarea name="noidung" required id="text" cols="30" rows="10"></textarea>
                    
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
                        <th scope="col" style="width: 30%;">Tiêu đề</th>
                        <th scope="col" style="width: 45%;">Nội dung</th>
                        <th scope="col">Ngày đăng</th>
                        <th scope="col"></th>
                    <form>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1 ?>
                    @foreach($DSThongBao as $item)
                    <?php
                        $chitiet = $item->id."chitiet";
                        $sua = $item->id."sua";
                        $xoa = $item->id."xoa"; ?>
                    <tr>
                        <th scope="row">{{$i++ + ($DSThongBao->currentPage() -1)* $pageSize }}</th>
                        <td><b style="color: #007bff">{{$item->tieude}}</b></td>
                        <td>
                            <?php
                                $str = $item->noidung;
                                $str = strip_tags($str);
                                if(strlen($str)>245) 
                                {
                                    $strCut = substr($str, 0, 245);
                                    $str = substr($strCut, 0, strrpos($strCut, ' ')).'...';
                                    echo $str;
                                }
                                else 
                                {
                                    echo $str;
                                }
                            ?>
                        </td>
                        <td>
                            {{$item->ngaydang}}
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
                                                <h2 class="modal-title" id="editModalLabel">Thông tin chi tiết thông báo</h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <input type="hidden" class="form-control" name="mssv"
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
                                                            <label class="col-form-label font-weight-bold">Tiêu đề:</label>
                                                            <textarea rows="2" disabled class="form-control" id="tieude" cols="20" style="font-weight: bold; color: #007bff">{{$item->tieude}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Nội dung:</label>
                                                            {!! $item->noidung !!}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Ngày đăng:</label>
                                                            <input type="text" class="form-control" id="ngaydang"
                                                                value="{{$item->ngaydang}}" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">ID Người đăng:</label>
                                                            <input type="text" class="form-control" id="nguoidang"
                                                                value="{{$item->nguoidang}}" disabled>
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
                                                <h2 class="modal-title" id="editModalLabel">Sửa Thông Báo</h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>

                                            <div class="modal-body">
                                                <form action="suaTB" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <input type="hidden" name="id" value="{{$item->id}}">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Tiêu đề<span
                                                                    class="text-danger"> (*)</span></label>
                                                                    <textarea rows="2" class="form-control" name="tieude" cols="20" style="font-weight: bold; color: #007bff">{{$item->tieude}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Nội dung
                                                                <span class="text-danger"> (*)</span></label>

                                                            <textarea name="noidung" required class="ckeditor" name="editor1" cols="30" rows="10">{{$item->noidung}}</textarea>
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
                            <form action="xoaTB" method="POST">
                                @csrf
                                <div class="modal fade" id="{{$xoa}}" tabindex="-1" role="dialog"
                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="modal-title" id="deleteModalLabel">Xóa Thông Báo</h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="{{$item->id}}" >
                                                <h5>Bạn có chắc muốn xóa thông báo <span>"{{$item->tieude}}"</span>
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
            {{ $DSThongBao->links() }}

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