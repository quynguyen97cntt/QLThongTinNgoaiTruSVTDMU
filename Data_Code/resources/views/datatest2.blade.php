@if (!session()->has('tenadmin'))
echo "
<script>window.location = 'login'</script>";
@endif
<!doctype html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('template-admin/Content/assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('template-admin/Content/assets/vendor/fonts/circular-std/style.css')}}">
    <link rel="stylesheet" href="{{asset('template-admin/Content/assets/libs/css/style.css')}}">
    <link rel="stylesheet"
        href="{{asset('template-admin/Content/assets/vendor/fonts/fontawesome/css/fontawesome-all.css')}}">
    <link rel="stylesheet" href="{{asset('template-admin/Content/assets/vendor/charts/chartist-bundle/chartist.css')}}">
    <link rel="stylesheet" href="{{asset('template-admin/Content/assets/vendor/charts/morris-bundle/morris.css')}}">
    <link rel="stylesheet"
        href="{{asset('template-admin/Content/assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('template-admin/Content/assets/vendor/charts/c3charts/c3.css')}}">
    <link rel="stylesheet"
        href="{{asset('template-admin/Content/assets/vendor/fonts/flag-icon-css/flag-icon.min.css')}}">
    <title>Trang quản trị</title>
    <link rel="stylesheet" href="template-admin/Content/assets/vendor/bootstrap/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('template/css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/qgis2web.css">
    <link rel="stylesheet" href="css/MarkerCluster.css" />
    <link rel="stylesheet" href="css/MarkerCluster.Default.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
        integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
        crossorigin="" />
    <link rel="stylesheet" href="highcharts/highcharts.css">
    <link href="template-admin/Content/jquery-ui.css" rel="stylesheet" />
    
    <style>
        html,
        body {
            background-color: #ffffff;

        }

        li.dropdown:hover>ul.dropdown-menu {
            color: red;
            display: block;
            border: none;
        }
    </style>
    
    <style>
        html,
        body,
        #mapid {
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
        }
    </style>

    <style type="text/css">
        #container {
            height: 400px;
            max-width: 800px;
            min-width: 320px;
            margin: 0 auto;
        }
        .highcharts-pie-series .highcharts-point {
            stroke: #EDE;
            stroke-width: 2px;
        }
        .highcharts-pie-series .highcharts-data-label-connector {
            stroke: silver;
            stroke-dasharray: 2, 2;
            stroke-width: 2px;
        }
    </style>
</head>

<body>
    <!-- Script  highcharts-->
    <script src="highcharts/highcharts.js"></script>
    <script src="highcharts/exporting.js"></script>
    <!-- ============================================================== -->

    <div class="container-fluid clearfix">
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a href="trang-quan-tri"><img src="{{asset('template/images/logo_tdmu.png')}}" height="80" class="navbar-brand" alt="banner index"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item">
                            <div id="custom-search" class="top-search-bar">
                                @if (session()->has('tenadmin'))
                                <p class="nav-item">
                                    <div class="dropdown show">
                                        <a class="dropdown-toggle" style="text-decoration: none;" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-user-cog"></i> Tài khoản
                                        </a>
                                      
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" style="width: 200px;">
                                          <span class="pl-4" style="font-size: 1rem; "><b>Xin chào, {{session('tenadmin')}}</b></span>
                                          <a class="dropdown-item" href="thoatadmin"><i class="fas fa-edit"></i> Đổi mật khẩu</a>
                                          <a class="dropdown-item" href="thoatadmin"><i class="fa fa-fw fa-rocket"></i> Đăng xuất</a>
                                        </div>
                                      </div>
                                </p>
                                @endif
                            </div>
                        </li>

                    </ul>
                </div>
            </nav>
        </div>
        <!-- Menu -->
        <div class="float-left nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="trang-quan-tri"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider"></li>
                            <li class="nav-item">
                                <a class="nav-link @if(Route::is('QLDSKhuNhaTro')) active @endif" href="{{route('QLDSKhuNhaTro')}}">
                                    <i class="fas fa-map-marked-alt"></i>Bản đồ quản lý khu trọ
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(Route::is('quan-ly-khu-tro')) active @endif" href="{{route('quan-ly-khu-tro')}}">
                                    <i class="fa fa-fw fa-rocket"></i>Quản lý khu trọ
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(Route::is('danhsachSV')) active @endif" href="{{route('danhsachSV')}}">
                                    <i class="fa fa-list" aria-hidden="true"></i>Quản lý thông tin sinh viên
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(Route::is('quan-ly-bai-viet')) active @endif" href="{{route('quan-ly-bai-viet')}}">
                                    <i class="far fa-file"></i>Quản lý bài viết
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(Route::is('quan-ly-tai-khoan')) active @endif" href="{{route('quan-ly-tai-khoan')}}">
                                    <i class="fas fa-user-circle"></i>Quản lý tài khoản
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-1-2" aria-controls="submenu-1-2"><i class="far fa-calendar-minus"></i>Quản lý thống kê</a>
                                <div id="submenu-1-2" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link @if(Route::is('thong-ke-theo-phuong')) active @endif" href="{{route('thong-ke-theo-phuong')}}">Thống kê theo phường</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link @if(Route::is('thong-ke-theo-chu-tro')) active @endif" href="{{route('thong-ke-theo-chu-tro')}}">Thống kê theo khu trọ</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            
                        </ul>
                    </div>
                </nav>
            </div>
        </div>


        <div class="dashboard-wrapper mt-5 mr-2" style="margin-top: 50px;">
            <div class="dashboard-ecommerce">
                <!-- Kết thúc menu -->

                <!-- Nội dung -->
                    @yield('master-admin')
                <!-- Kết thúc nội dung -->

                <!-- Menu -->
            </div>
        </div>
      </div>
    <!-- Optional JavaScript -->

    <script src="template-admin/Scripts/jquery-1.10.2.js"></script>
    <script src="template-admin/Scripts/jquery.min.js"></script>
    <script type="text/javascript" src="template-admin/Scripts/jquery-ui.min.js"></script>
    <!-- jquery 3.3.1 -->
    <script src="template-admin/Content/assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="template-admin/Content/assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="template-admin/Content/assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
    <script src="template-admin/Content/assets/libs/js/main-js.js"></script>
    <!-- chart chartist js -->
    <script src="template-admin/Content/assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
    <!-- sparkline js -->
    <script src="template-admin/Content/assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <!-- morris js -->
    <script src="template-admin/Content/assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <!-- chart c3 js -->
    <script src="template-admin/Content/assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="template-admin/Content/assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <script src="template-admin/Content/assets/vendor/charts/c3charts/C3chartjs.js"></script>
    <script src="template/js/fade-alert.js"></script>
    <script src="{{asset('template/js/dssv.js')}}"></script>
</body>
</html>