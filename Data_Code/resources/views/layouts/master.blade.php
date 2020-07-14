<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="76x76" href="assets/img/fav.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WebGis - Quản Lý Sinh Viên Ngoại Trú - ĐH Thủ Dầu Một</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('template/css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <style>
        html, body {
            background-color: #ffffff;

        }
        li.dropdown:hover > ul.dropdown-menu {
                color: red;
                display: block;
                border: none;
        }
        </style>
        <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">

        <link rel="stylesheet" href="{{asset('css/leaflet.css')}}" />
        
        <link rel="stylesheet" href="{{asset('css/MarkerCluster.css')}}" />
        <link rel="stylesheet" href="{{asset('css/MarkerCluster.Default.css')}}" />
        <link rel="stylesheet" href="{{asset('css/qgis2web.css')}}" />
        <link rel="stylesheet" href="{{asset('css/L.Control.Locate.min.css')}}" />
        <link rel="stylesheet" href="{{asset('css/leaflet-search.css')}}" />
        <link rel="stylesheet" href="{{asset('css/dropzone.min.css')}}" />
        <link rel="stylesheet" href="{{asset('css/leaflet2.css')}}" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
        <style>
        html, body, #mapid {
                width: 100%;
                height: 100%;
                padding: 0;
                margin: 0;
            }
        </style>

        <style>
            html, body {
                margin: 0;
                width: 100%;
                height: 100%;
                }
                #map {
                float: left;
                margin: 0;
                width: 100%;
                height: 100%;
                }

                /*Wraperclass for the divicon*/
                .map-label {
                position: absolute;
                bottom: 0;left: -50%;
                display: flex;
                flex-direction: column;
                text-align: center;
                }
                /*Wrap the content of the divicon (text) in this class*/
                .map-label-content {
                order: 1;
                position: relative; left: -50%;
                background-color: #fff;
                border-radius: 5px;
                border-width: 2px;
                border-style: solid;
                border-color: #444;
                padding: 3px;
                white-space: nowrap;
                }
                /*Add this arrow*/
                .map-label-arrow {
                order: 2;
                width: 0px; height: 0px; left: 50%;
                border-style: solid;
                border-color: #444 transparent transparent transparent;
                border-width: 10px 6px 0 6px; /*[first number is height, second/fourth are rigth/left width]*/
                margin-left: -6px;
                }

                /*Instance classes*/
                .map-label.inactive {
                opacity: 0.5;
                }

                .map-label.redborder > .map-label-content {
                border-color: #e00;
                }
                .map-label.redborder > .map-label-arrow {
                border-top-color: #e00;
                }

                .map-label.redbackground > .map-label-content {
                white-space: default;
                color: #fff;
                background-color: #e00;
                }
        </style>
        <title></title>
</head>

<body class="bg-transparent">
    <header class="bg-blue">
        <div class="container" id="banner">
            <div class="row">
                <a href="{{route('/')}}"><img src="{{asset('template/images/logo_tdmu.png')}}" class="img-fluid" alt="banner index"></a>
                <img src="{{asset('template/images/banner_tdmu.png')}}" width="500" class="img-fluid" alt="banner index">
            </div>
        </div>
        <div class="nav bg-nav-blue" id="myHeader">
            <div class="container ">
                <nav class="navbar navbar-expand-lg p-0 navbar-light ">
                    <a class="navbar-brand" href="#"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse navbar-custom" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto font-weight-bold ">
                            @if(session()->has('tendn'))
                                @if(session()->has('quyensv'))
                                    <li class="nav-item active mr-1 p-1">
                                        <a class="nav-link text-white navbar-text" href="{{route('/')}}"><i class="fas fa-home"></i>
                                            Trang chủ
                                            <span class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="nav-item mr-1 p-1">
                                        <a class="nav-link text-white navbar-text" href="trang-tin"><i
                                            class="fas fa-file-alt"></i> Bài Viết</a>
                                    </li>
                                    
                                    <li class="nav-item mr-1 p-1">
                                        <a class="nav-link text-white navbar-text" href="thongbao">
                                            <i class="fas fa-bell"></i> Thông Báo</a>
                                    </li>
                                    
                                    <li class="nav-item mr-1 p-1">
                                        <div class="dropdown show">
                                            <a class="nav-link text-white navbar-text dropdown-toggle" style="text-decoration: none;" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-file-alt"></i> Thông tin sinh viên
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" style="width: 20rem;">
                                                <ul style="list-style: none;"> 
                                                    <li>
                                                        <a class="nav-link" href="{{route('capnhatngoaitru')}}">
                                                            <i class="fas fa-bookmark pl-3"></i> Cập nhật thông tin ngoại trú
                                                        </a>
                                                    </li>
                                                    <li>
                                                    <a class="nav-link" href="{{route('capnhatthongtinsv')}}">
                                                            <i class="fas fa-users pl-3"></i> Cập nhật thông tin sinh viên
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="nav-link" href="{{route('thong-tin-giang-vien')}}">
                                                        <i class="fas fa-chalkboard-teacher  pl-3"></i> Liên hệ giảng viên</a>
                                                    </li>
                                                    <li>
                                                        <a class="nav-link" href="{{route('lien-he')}}"><i
                                                                class="fas fa-address-book  pl-3"></i> Góp Ý</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="nav-item mr-1 p-1">
                                        <div class="dropdown show">
                                            <a class="nav-link text-white navbar-text dropdown-toggle" style="text-decoration: none;" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-user-cog"></i> Tài khoản </a>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" style="width: 17rem;">
                                                <ul style="list-style: none;"> 
                                                    <li><b class="pl-4"> Xin chào, {{session('tendn')}}</b></li>
                                                    <!-- <li data-toggle="modal" data-target="#suaTTSinhvien">
                                                        <a class="nav-link" href="#" data-toggle="tooltip" data-placement="left" data-html="true">
                                                            <i class="fas fa-user-edit pl-3"></i> Thông tin sinh viên
                                                        </a>
                                                    </li> -->
                                                    <li>
                                                        <a class="nav-link" href="doi-mat-khau">
                                                            <i class="fas fa-edit pl-3"></i> Đổi mật khẩu
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="nav-link" href="thoat">
                                                            <i class="fas fa-power-off pl-3"></i> Đăng xuất
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                @else
                                    <li class="nav-item mr-1 p-1">

                                        <div class="dropdown show">
                                            <a class="nav-link text-white navbar-text dropdown-toggle" style="text-decoration: none;" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-file-alt"></i> Quản lý trọ
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" style="width: 17rem;">
                                                <ul style="list-style: none;"> 
                                                    <li>
                                                        <a class="nav-link" href="danh-sach-bai-viet">
                                                            <i class="fas fa-bookmark pl-3"></i> Quản lý bài viết
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="nav-link" href="danh-sach-tro">
                                                            <i class="fas fa-users pl-3"></i> Danh sách sinh viên
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nav-item mr-1 p-1">
                                        <a class="nav-link text-white navbar-text" href="lien-he"><i
                                                class="fas fa-address-book"></i> Phản Hồi</a>
                                    </li>
                                    <li class="nav-item mr-1 p-1">
                                        <div class="dropdown show">
                                            <a class="nav-link text-white navbar-text dropdown-toggle" style="text-decoration: none;" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-user-cog"></i> Tài khoản </a>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" style="width: 17rem;">
                                                <ul style="list-style: none;"> 
                                                    <li><b class="pl-4"> Xin chào, {{session('tendn')}}</b></li>
                                                    <li data-toggle="modal" data-target="#suaTTChutro">
                                                        <a class="nav-link" href="#" data-toggle="tooltip" data-placement="left" data-html="true">
                                                            <i class="fas fa-user-edit pl-3"></i> Thông tin khu trọ
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="nav-link" href="doi-mat-khau">
                                                            <i class="fas fa-edit pl-3"></i> Đổi mật khẩu
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="nav-link" href="thoat">
                                                            <i class="fas fa-power-off pl-3"></i> Đăng xuất
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @else
                            <li class="nav-item active mr-1 p-1">
                                <a class="nav-link text-white navbar-text" href="welcome"><i class="fas fa-home"></i>
                                    Trang chủ
                                    <span class="sr-only">(current)</span></a>
                            </li>
                            <!-- <li class="nav-item mr-1 p-1">
                                <a class="nav-link text-white navbar-text" href="signup"><i class="fas fa-user-plus"></i> Đăng ký </a>
                            </li>
                            <li class="nav-item mr-1 p-1">
                                <a class="nav-link text-white navbar-text" href="login"><i  class="fas fa-user"></i> Đăng nhập </a>
                            </li> -->
                            @endif
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

    </header>

    <div>
        @yield('master')
    </div>
    <!-- Footer -->
    <footer class="page-footer font-small blue pt-4" style="background-color: rgb(66, 135, 245); color: #fff;">
        <!-- Footer Links -->
        <div class="container-fluid text-center text-md-left">
            <!-- Grid row -->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-6 mt-md-0 mt-3">
                    <!-- Content -->
                    <h6 class="text-uppercase"><b>Phòng Công tác Sinh viên – Trường Đại học Thủ Dầu Một</b></h6>
                    <ul class="">
                        <li class="nav-item">
                            <p>Địa chỉ: Tòa nhà làm việc của Phòng, Ban, Viện và các Khoa - Khu H3</p>
                        </li>
                        <li class="nav-item">

                            <p>Số 06 Trần Văn Ơn, phường Phú Hòa, tp Thủ Dầu Một, tỉnh Bình Dương</p>
                        </li>
                        <li class="nav-item">
                            <p>Điện thoại: (0274) 3822 518 - Số nội bộ 115</p>
                        </li>
                        <li class="nav-item">
                            <p>Website: congtacsinhvien.tdmu.edu.vn</p>
                        </li>
                    </ul>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
        <!-- Footer Links -->
        <hr class="separate py-0">
        <!-- Copyright -->
        <div class="footer-copyright text-center pb-2">© 2020 Copyright make by Nguyen Ngoc Quy
            <a href="#"> </a>
        </div>
        <!-- Copyright -->

    </footer>
    <!-- Footer -->

    @if (session()->has('tendn'))
        @if (session()->has('quyenchutro'))
        <!-- Modal Cập nhật thông tin chủ trọ -->
        <div class="modal fade" id="suaTTChutro" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="editModalLabel">Thông Tin Chủ Trọ
                            </h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('SuaTTChuTro',['gid' => session('makhutro')])}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label class="col-form-label font-weight-bold">Mã chủ trọ<span class="text-danger"> (*)</span></label>
                                <input type="text" readonly name="gid" required value="{{session('makhutro')}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label font-weight-bold">Tên nhà trọ<span class="text-danger"> (*)</span></label>
                                <input type="text" name="tennhatro" required value="{{session('tennhatro')}}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label font-weight-bold">Tên chủ trọ<span class="text-danger"> (*)</span></label>
                                <input type="text" name="tenchutro" required value="{{session('tenchutro')}}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label font-weight-bold">Số điện thoại <span class="text-danger"> (*)</span></label>
                                <input type="number" name="sodienthoai" required value="{{session('sodienthoai')}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label font-weight-bold">Giá phòng</label>
                                <input type="number" name="giaphong" value="{{session('giaphong')}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label font-weight-bold">Tiền điện</label>
                                <input type="number" name="dien" value="{{session('dien')}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label font-weight-bold">Tiền nước</label>
                                <input type="number" name="nuoc" value="{{session('nuoc')}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label font-weight-bold">Tiện ích</label>
                                <input type="text" name="tienich" value="{{session('tienich')}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label font-weight-bold">Số người trong 1 phòng</label>
                                <input type="number" name="songuoi" value="{{session('songuoi')}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label font-weight-bold">Trạng thái phòng</label>
                                <select name="trangthaiphong" id="trangthaiphong" class="form-control">
                                    <option value="0" @if(session("trangthaiphong") === "0") selected="selected" @endif>---Chọn trạng thái---</option>
                                    <option value="Còn phòng" @if(session("trangthaiphong") === "Còn phòng") selected="selected" @endif>Còn phòng</option>
                                    <option value="Hết phòng" @if(session("trangthaiphong") === "Hết phòng") selected="selected" @endif>Hết phòng</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label font-weight-bold">Địa chỉ<span class="text-danger"> (*)</span></label>
                                <textarea name="diachi" required class="form-control">{{session('diachi')}}</textarea>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                        <input type="submit" class="btn btn-success" value="Cập nhật">
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Cập nhật thông tin chủ trọ -->
        @endif

        @if (session()->has('quyensv'))
        <!-- Modal Cập nhật thông tin sinh viên -->
        <div class="modal fade" id="suaTTSinhvien" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="editModalLabel">Thông Tin Sinh Viên
                            </h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('SuaTTSinhVien',['mssv' => session('mssv')])}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label class="col-form-label font-weight-bold">Mã SV</label>
                                <input type="text" readonly name="mssv" value="{{session('mssv')}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label font-weight-bold">Họ tên</label>
                                <input type="text" disabled name="hoten" value="{{session('hosv')}} {{session('tensv')}}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label font-weight-bold">Email</label>
                                <input type="email" name="email" value="{{session('email')}}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label font-weight-bold">Số điện thoại</label>
                                <input type="text" name="dienthoai" value="{{session('dienthoai')}}" class="form-control">
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                        <input type="submit" class="btn btn-success" value="Cập nhật">
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Cập nhật thông tin sinh viên -->
        @endif
    @endif

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="assets/js/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="assets/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>CKEDITOR.replace('editor1'); </script>
    <script>CKEDITOR.replace('editor2'); </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/dropzone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script>
    <script>
        var fileList = new Array;
        var i =0;
        var uploadedDocumentMap = {}
        Dropzone.options.documentDropzone = {
          url: '{{ route('projects.storeMedia') }}',
          paramName: "file",
          uploadMultiple: true,
          maxFilesize: 8, // MB
          acceptedFiles: '.jpg, .png, .gif, .jpeg',
          addRemoveLinks: true,
          dictRemoveFile: 'Xoá ảnh',
          dictFileTooBig: 'Ảnh vượt quá 8MB cho phép!',
          headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          success: function (file, response) {
            $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
            uploadedDocumentMap[file.name] = response.name;
            fileList[i] = {"serverFileName" : response.filename, "imagename" : response.imagename, "fileName" : file.name,"fileId" : i };
            //console.log(fileList);
            i++;
          },
          removedfile: function(file, response) 
            {
                
                var rmvFile = "";
                for(f=0;f<fileList.length;f++){
                    if(fileList[f].fileName == file.name)
                    {
                        var str = fileList[f].imagename+"";
                        var kq =str.split(",").length;
                        var kq2 =str.split(",");

                        for(k=0; k< kq ;k++)
                        {
                            if(fileList[f].fileName==kq2[k])
                            {
                                rmvFile=fileList[f].serverFileName[k];
                            }
                        }
                    }
                }
                console.log(rmvFile);
                if (rmvFile){    
                    $.ajax({
                        headers: {
                                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                },
                        type: 'POST',
                        url: '{{ route('projects.deletefile') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            filename: rmvFile},
                        success: function (data){
                            console.log("File deleted successfully!!");
                        },
                        error: function(e) {
                            console.log(e);
                        }});
                        var fileRef;
                        return (fileRef = file.previewElement) != null ? 
                        fileRef.parentNode.removeChild(file.previewElement) : void 0;
                }
            },
            init: function() {
                $(this.element).addClass("dropzone");
                    this.on("success", function(file, serverFileName) {
                        fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i };
                        i++;
                    });
        }
    }
      </script>

      
</body>
</html>
