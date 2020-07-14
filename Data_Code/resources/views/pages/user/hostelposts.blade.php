@if (!session()->has('tendn'))
    echo "<script>window.location='login'</script>";
@endif
@extends('layouts.master')
@section('master')
<div class="card mt-4 mb-4 container">
    <div class="card-header">
        <div class="row">
            <div class="col-md-4 float-left" style="font-size: 20px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-primary" href="danh-sach-bai-viet"></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Quản lý bài viết</li>
                    </ol>
                </nav>
            </div>

            <!-- Search bar -->
            <div class="col-md-4 navbar-nav ml-3 mt-2 pb-3">
                <form>
                    <div id="custom-search" class="top-search-bar">
                        <input class="form-control" type="text" placeholder="Tìm kiếm..">
                    </div>
                </form>
            </div>
            <!-- End search bar -->

            <div class="col-md-2 d-flex align-items-center">
                <button class="btn btn-success rounded-circle" data-toggle="modal" data-target="#addModalBaiViet">
                    <i class="fa fa-plus"></i>
                </button>

                <!-- Modal thêm -->

                <div class="modal fade" id="addModalBaiViet" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="addModalLabel">Thêm Bài Viết</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('ThemBaiViet')}}" method="post" enctype="multipart/form-data" id="frmTarget">
                                    @csrf
                                    <div class="form-group">
                                        <input type="hidden" name="makhutro" value="{{$khunhatro->gid}}"
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label font-weight-bold">Tiêu đề<span class="text-danger">
                                                (*)</span></label>
                                        <input type="text" name="tieude" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="document">Hình ảnh</label>
                                        <div class="needsclick dropzone" id="document-dropzone">
                                
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label font-weight-bold">Giá phòng</label>
                                        <input type="number" name="giaphong" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label font-weight-bold">Điện thoại liên hệ</label>
                                        <input type="number" name="sdt" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label font-weight-bold">Địa chỉ</label>
                                        <input type="text" name="diachi" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label font-weight-bold">Khu vực</label>
                                        <select name="vitri" class="form-control">
                                            @foreach($phuongxa as $px)
                                                <option value="{{$px->mapx}}">{{$px->tenpx}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label font-weight-bold">Nội dung<span
                                                class="text-danger"> (*)</span></label>
                                        <textarea name="noidung" class="form-control " id="editor1"></textarea>
                                    </div>


                            </div>
                            <div class="modal-footer">
                                <input type="submit" id="btnThemBaiViet" class="btn btn-success" value="Thêm">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>

                            </div>

                            </form>
                        </div>
                    </div>
                </div>
                <!-- End modal thêm -->
            </div>


        </div>






    </div>

    <div class="card-body">
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

        @if($anhtam)
            @foreach ($anhtam as $item)
                <img data-dz-thumbnail="" alt="avatar.png" src="data:image/png;base64,{{$item->name}}" width="100" height="100">
            @endforeach
        @endif
        <div class="row table-responsive mx-auto" style="font-size: 16px">
            @if($baiviet)
            <table class="table table-striped">
                <thead style="background: #3CADF1; color: antiquewhite">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tiêu đề</th>
                        <th scope="col">Nội dung</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Trạng thái duyệt</th>
                        <th scope="col">Thao tác</th>

                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                                    $y = 2 ?>

                    @foreach ($baiviet as $item)

                    <?php
                                    $suabv = "suabv" . $item->id;
                                    $chitiet = "chitiet" . $item->id;
                                    $xoabv = "xoabv" . $item->id; ?>
                    <tr>
                        <th scope="row">{{$i++ + ($baiviet->currentPage() -1)* $pageSize }}</th>
                        <th style="width: 32%;">{{$item->tieude}}</th>
                        <th style="width: 30%;"><?php
                            $str = $item->noidung;
                            $str = strip_tags($str);
                            if(strlen($str)>100) 
                            {
                                $strCut = substr($str, 0, 100);
                                $str = substr($strCut, 0, strrpos($strCut, ' ')).'...';
                                echo $str;
                            }
                            else 
                            {
                                echo $str;
                            }
                        ?></th>
                        <th>{{date('d-m-Y', strtotime($item->ngaytao))}}</th>
                        @switch($item->trangthaiduyet)
                        @case (0)
                        <th class="text-center">
                            <span class="text-warning mr-1"><i class="fas fa-dot-circle" data-toggle="tooltip"
                                    data-placement="right" data-html="true" title="Chờ duyệt"></i></span>

                        </th>

                        @break;
                        @case(1)
                        <th class="text-center">

                            <span class="text-success mr-1"><i class="fas fa-check-circle" data-toggle="tooltip"
                                    data-placement="right" data-html="true" title="Đã duyệt"></i></span>

                        </th>


                        {{-- end modal trạng thái --}}
                        @break
                        @case(2)
                        <th class="text-center">

                            <span class="text-danger mr-1"><i class="fas fa-ban" data-toggle="tooltip"
                                    data-placement="right" data-html="true" title="Không duyệt"></i></span>
                        </th>

                        @break
                        @endswitch


                        <td>
                            <div class="dropdown show">
                                    <a class="dropdown-toggle" style="text-decoration: none;" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-plus-circle"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" style="width: 17rem;">
                                    <ul style="list-style: none;"> 
                                        <li data-toggle="modal" data-target="#{{$chitiet}}">
                                            <a href="#" class="nav-link" data-toggle="tooltip" data-placement="right" data-html="true" title="Chi tiết"><i class="fas fa-info-circle"></i>
                                            Chi tiết bài viết
                                            </a>
                                        </li>
                                        @if($item->trangthaiduyet == 0)
                                            <li data-toggle="modal" data-target="#{{$suabv}}">
                                                <a href="#" class="nav-link" data-toggle="tooltip" data-placement="left" data-html="true">
                                                    <i class="fa fa-edit fa-lg"></i> Cập nhật bài viết
                                                </a>
                                            </li>
                                        @endif
                                        <li data-toggle="modal" data-target="#{{$xoabv}}">
                                            <a href="#" class="nav-link" data-toggle="tooltip" data-placement="right" data-html="true">
                                                <i class="fa fa-trash-alt fa-lg"></i> Xoá bài viết
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Modal chi tiết -->
                            <div class="modal fade" id="{{$chitiet}}" tabindex="-1" role="dialog" aria-labelledby="duyetModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                                <div class="modal-header">
                                                    <h2 class="modal-title" id="deleteModalLabel">Chi Tiết Bài Viết</h3>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>
                                                <div class="modal-body">
                                                <!-- Ảnh mô tả -->
                                                    @foreach($anhbaiviet as $imgbaiviet)
                                                        @if(strcmp($imgbaiviet->mabaiviet,$item->id) ==0)
                                                            <div class="row d-flex justify-content-center w-100" style="text-align: center;">
                                                                <div class="col-md-8 col-sm-12 carousel slide" style="background-color: #BDBDBD;">
                                                                    <center><img class="d-block" src="images/{{$imgbaiviet->name}}" height="300" alt=""></center>
                                                                </div>
                                                            </div>
                                                            <br /><br />
                                                        @endif
                                                    @endforeach
                                                <!-- Kết thúc ảnh mô tả -->
                                                    <!-- Nội dung bài viết -->
                                                    <div class="row d-flex justify-content-center">
                                                    <div class="col-md-10 col-sm-12">
                                                        <div>
                                                            <small>ĐĂNG VÀO: {{date('d/m/Y', strtotime($item->ngaytao))}}</small>
                                                            <h4 class="mt-3">{{$item->tieude}}</h4>
                                                            <p><i class="fas fa-map-marker-alt"></i> {{$item->tenpx}}, Thủ Dầu Một, Bình Dương</p>
                                                            <p> @if($item->giaphong === null) <b style="color: green;">Thoả thuận</b> @else <b style="color: green;">{{number_format($item->giaphong)}} /tháng</b> @endif</p>
                                                            <p>Liên hệ: <b>{{$item->dienthoai}}</b></p>
                                                            <i class="fas fa-compress-arrows-alt"></i><span style="font-weight: 600"> Mô tả:</span> {!! $item->noidung !!}
                                                        </div>
                                                        
                                                        <iframe
                                                        style="width: 100%"
                                                            height="450"
                                                            frameborder="0" style="border:0"
                                                            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyD01bGo5UBq2VcFHCmiVJwyuOM43sN6Id4
                                                            &q={{$item->diachi}}" allowfullscreen>
                                                        </iframe>
                                                    </div>
                                                </div>
                                                    <!-- End nội dung bài viết -->
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default float-left" data-dismiss="modal">Đóng</button>

                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End modal chi tiết -->

                            <!-- Modal sửa -->

                            <div class="modal fade" id="{{$suabv}}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title" id="editModalLabel">Sửa Bài Viết
                                                </h3>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('SuaBaiViet',['id' => $item->id])}}" method="post">
                                                @csrf

                                                <div class="form-group">
                                                    <label class="col-form-label font-weight-bold">Tiêu đề<span
                                                            class="text-danger"> (*)</span></label>
                                                    <input type="text" name="tieude" value="{{$item->tieude}}"
                                                        class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label font-weight-bold">Nội dung</label>
                                                    <textarea name="noidung" class="form-control" rows="8"
                                                        id="editor{{$y++}}">{!!$item->noidung!!}</textarea>

                                                </div>

                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" class="btn btn-success" value="Cập nhật">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Đóng</button>

                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- End modal sửa -->

                            <!-- Modal xóa -->

                            <div class="modal fade" id="{{$xoabv}}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title" id="deleteModalLabel">Xóa Bài Viết</h3>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                        </div>
                                        <div class="modal-body">
                                            <h5>Bạn có chắc muốn xóa bài viết <span>"{{$item->tieude}}"</span></h5>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('XoaBaiViet',['id' => $item->id])}}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Xóa</button>
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Hủy</button>

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
            <div class="d-flex justify-content-end mt-4">
                {{ $baiviet->links() }}
            </div>

            @else
            <div class="text-center"><i>Chưa có bài viết để hiện thị. Nhấn <a class="text-primary" data-toggle="modal"
                        data-target="#addModalBaiViet">vào đây</a> để tạo bài viết. </i></div>
            @endif
        </div>



    </div>
</div>
</div>
</div>
@endsection