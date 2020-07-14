@extends('layouts.master-admin')
@section('title','Quản lý khu trọ')
@section('master-admin')
@if (!session()->has('tenadmin'))
    echo "<script>window.location='login'</script>";
@endif

<!-- Noi dung -->
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-4 float-left" style="font-size: 20px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-primary" href="trang-quan-tri"></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Quản lý bài viết</li>
                    </ol>
                </nav>
            </div>

            <!-- Search bar -->
            <div class="col-md-5 navbar-nav ml-3">
                <form>
                    <div id="custom-search" class="top-search-bar">
                        <input class="form-control" type="text" placeholder="Tìm kiếm..">
                    </div>
                </form>
            </div>
            <!-- End search bar -->

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

    <div class="card-body">
        <div class="row table-responsive mx-auto" style="font-size: 16px">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col">Tiêu đề</th>
                        <th scope="col">Nội dung</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col" class="text-center">Trạng thái</th>
                        <th scope="col" class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i=1
                    ?>
                    @foreach ($dsBaiViet as $baiviet )
                    <?php $sua= "sua".$baiviet->id;
                        $sua2="sua2".$baiviet->id;
                        $sua3="sua3".$baiviet->id;
                        $xoa = "xoa".$baiviet->id;
                        $idtuchoi = "idtuchoi".$baiviet->id;
                        $chitiet = "chitiet".$baiviet->id;
                    ?>
                    <tr>
                        <th scope="row">{{$i++ + ($dsBaiViet->currentPage() -1)* $pageSize }}</th>
                        <td class="text-wrap" style="width: 20rem">{{$baiviet->tieude}}</td>
                        <td class="text-wrap" style="width: 20rem">
                            <?php
                                $str = $baiviet->noidung;
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
                            ?>
                        </td>
                        <td>{{date('d-m-Y', strtotime($baiviet->ngaytao))}}</td>
                        @switch($baiviet->trangthaiduyet)
                        @case(0)
                        <td class="text-center">
                            <span class="text-warning mr-1"><i class="fas fa-dot-circle" title="Chờ duyệt"></i></span>
                        </td>
                        {{-- modal trạng thái --}}
                        <div class="modal fade" id="{{$sua}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('sua-trang-thai',['id' => $baiviet->id])}}" method="post">
                                        @csrf
                                        <div class="modal-header">
                                            <h2 class="modal-title" id="deleteModalLabel">Trạng thái bài viết</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="status1.{{$baiviet->id}}">
                                                    <span class="text-success mr-1" data-toggle="modal" data-target="#statusModal">
                                                        <i class="fas fa-check-circle"></i></span>Duyệt bài</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input position-static d-inline-block" type="radio" name="trangthai" id="status1.{{$baiviet->id}}" value="1" checked>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="status2.{{$baiviet->id}}"><span class="text-danger mr-1" data-toggle="modal" data-target="#statusModal">
                                                            <i class="fas fa-ban"></i></span>Không duyệt
                                                    </label>
                                                    <div class="form-check">
                                                        <input class="form-check-input position-static d-inline-block"  type="radio" name="trangthai" id="status2.{{$baiviet->id}}"  value="2" aria-label="...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success float-left">Lưu</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- end modal trạng thái --}}
                        @break
                        @case(1)
                        <td class="text-center">
                            <span class="text-success mr-1" data-toggle="modal" data-target="#{{$sua2}}">
                                <i class="fas fa-check-circle" data-toggle="tooltip" data-placement="right" data-html="true" title="Đã duyệt"></i>
                            </span>
                        </td>
                        {{-- end modal trạng thái --}}
                        @break
                        @case(2)
                        <td class="text-center">
                            <span class="text-danger mr-1" data-toggle="modal" data-target="#{{$sua3}}">
                                <i class="fas fa-ban" data-toggle="tooltip" data-placement="right" data-html="true" title="Không duyệt"></i>
                            </span>
                        </td>
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
                                            Xem và duyệt bài viết
                                            </a>
                                        </li>
                                        <li data-toggle="modal" data-target="#{{$xoa}}">
                                            <a href="#" class="nav-link" data-toggle="tooltip" data-placement="right" data-html="true" title="Xóa"><i class="fa fa-trash-alt fa-lg"></i>
                                            Xoá bài viết
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div> 

                            <!-- Modal duyệt -->
                            <div class="modal fade" id="{{$chitiet}}" tabindex="-1" role="dialog" aria-labelledby="duyetModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('sua-trang-thai',['id' => $baiviet->id])}}" method="post" id="frmDuyetKhuTro">
                                            @csrf
                                            <div class="modal-header">
                                                <h2 class="modal-title" id="deleteModalLabel">Chi Tiết Bài Viết</h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>
                                            <div class="modal-body">
                                            <!-- Ảnh mô tả -->
                                                @foreach($anhbaiviet as $imgbaiviet)
                                                    @if(strcmp($imgbaiviet->mabaiviet,$baiviet->id) ==0)
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
                                                        <small>ĐĂNG VÀO: {{date('d/m/Y', strtotime($baiviet->ngaytao))}}</small>
                                                        <h4 class="mt-3">{{$baiviet->tieude}}</h4>
                                                        <p><i class="fas fa-map-marker-alt"></i> {{$baiviet->tenpx}}, Thủ Dầu Một, Bình Dương</p>
                                                        <p> @if($baiviet->giaphong === null) <b style="color: green;">Thoả thuận</b> @else <b style="color: green;">{{number_format($baiviet->giaphong)}} /tháng</b> @endif</p>
                                                        <p>Liên hệ: <b>{{$baiviet->dienthoai}}</b></p>
                                                        <i class="fas fa-compress-arrows-alt"></i><span style="font-weight: 600"> Mô tả:</span> {!! $baiviet->noidung !!}
                                                    </div>
                                                    
                                                    <iframe style="width: 100%" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyD01bGo5UBq2VcFHCmiVJwyuOM43sN6Id4&q={{$baiviet->diachi}}" allowfullscreen></iframe>
                                                </div>
                                            </div>
                                                <!-- End nội dung bài viết -->
                                                <input type="hidden" name="trangthai" class="btn btn-danger" value="1">
                                            </div>

                                            <div class="modal-footer">
                                                <input type="submit" class="btn btn-danger" value="Duyệt">
                                                <a href="" class="btn btn-primary" data-placement="right" data-toggle="modal" data-target="#{{$idtuchoi}}" data-html="true">Từ chối</a>
                                                <button type="button" class="btn btn-default float-left" data-dismiss="modal">Hủy</button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End modal duyệt -->

                            <!-- Modal từ chối -->
                            <div class="modal fade" id="{{$idtuchoi}}" tabindex="-1" role="dialog" aria-labelledby="tuchoiModalLabel"  aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('sua-trang-thai',['id' => $baiviet->id])}}" method="post" id="frmTuChoiDuyet">
                                                @csrf
                                                <input type="hidden" name="trangthai" class="btn btn-danger" value="2">
                                                <div class="modal-header">
                                                    <h2 class="modal-title" id="deleteModalLabel">Từ Chối Duyệt Bài Viết</h3>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="col-form-label font-weight-bold">Lý do từ chối: </label>
                                                        <input type="text" value="" name="lydotuchoi" required class="form-control" id="lydotuchoi">
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <input type="submit" class="btn btn-danger" value="Từ chối và gửi phản hồi">
                                                    <button type="button" class="btn btn-default float-left" data-dismiss="modal">Hủy</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                            </div>
                            <!-- End modal từ chối -->

                            <!-- Modal xóa -->
                            <div class="modal fade" id="{{$xoa}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">Xóa bài viết</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body mx-auto">
                                            <span>Bạn có chắc muốn xóa bài viết này?</span>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('xoaBV',['id' => $baiviet->id])}}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Xóa</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
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
            {{ $dsBaiViet->links() }}
        </div>
    </div>
</div>
@endsection