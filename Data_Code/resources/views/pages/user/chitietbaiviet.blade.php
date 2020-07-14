@extends('layouts.master')
@section('master')
<div class="container mt-4 mb-4" style="color: #000000;">
    <div class="dashboard-wrapper">
        <div class="dashboard-ecommerce">
            <div class="container-fluid dashboard-content ">
                <div class="card" style="display: block !important;">
                    <div class="card-body mx-auto">
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


                        <!-- Ảnh mô tả -->
                        <div class="row d-flex justify-content-center w-100" style="text-align: center;">
                            <div id="carouselExampleControls" class="col-md-8 col-sm-12 carousel slide" style="background-color: #BDBDBD;" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <center><img class="d-block" src="images/{{$anhbaiviet[0]->name}}" height="300" alt=""></center>
                                    </div>
                                    @foreach($anhbaiviet as $imgbaiviet)
                                        <div class="carousel-item">
                                            <center><img class="d-block" src="images/{{$imgbaiviet->name}}" height="300" alt=""></center>
                                        </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <!-- Kết thúc ảnh mô tả -->
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-8 col-sm-12">
                                @foreach($dsBaiViet as $item)
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
                                @endforeach
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection