@if (!session()->has('tenadmin'))
    echo "<script>window.location='login'</script>";
@endif
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="icon" sizes="76x76" href="{{asset('assets/img/fav.ico')}}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    WebGis - Quản Lý Sinh Viên Ngoại Trú - ĐH Thủ Dầu Một
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

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
    <link rel="stylesheet" href="{{asset('css/L.Control.Locate.min.css')}}" />
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
    <link href="assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body class="">
    <!-- Script  highcharts-->
    <script src="highcharts/highcharts.js"></script>
    <script src="highcharts/exporting.js"></script>
    <!-- ============================================================== -->

  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="assets/img/sidebar-1.jpg">
      
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item @if(Route::is('QLDSKhuNhaTro')) active @endif">
            <a class="nav-link" href="{{route('QLDSKhuNhaTro')}}">
                <i class="fas fa-map-marked-alt"></i><p>Quản lý khu trọ</p>
            </a>
          </li>
          <li class="nav-item @if(Route::is('danhsachSV')) active @endif">
            <a class="nav-link" href="{{route('danhsachSV')}}">
                <i class="fa fa-list" aria-hidden="true"></i><p>Quản lý sinh viên</p>
            </a>
          </li>
          <li class="nav-item @if(Route::is('danhsachCB')) active @endif">
            <a class="nav-link" href="{{route('danhsachCB')}}">
                <i class="fas fa-stream"></i><p>Quản lý cán bộ</p>
            </a>
          </li>
          <li class="nav-item @if(Route::is('quanlyngoaitru')) active @endif">
            <a class="nav-link" href="{{route('quanlyngoaitru')}}">
                <i class="fas fa-bookmark" aria-hidden="true"></i><p>Quản lý ngoại trú</p>
            </a>
          </li>
          <li class="nav-item @if(Route::is('quan-ly-bai-viet')) active @endif">
            <a class="nav-link" href="{{route('quan-ly-bai-viet')}}">
                <i class="far fa-file"></i><p>Quản lý bài viết</p>
            </a>
          </li>
          <li class="nav-item @if(Route::is('quan-ly-thong-bao')) active @endif">
            <a class="nav-link" href="{{route('quan-ly-thong-bao')}}">
              <i class="fas fa-bell"></i><p>Quản lý thông báo</p>
            </a>
          </li>
          <li class="nav-item @if(Route::is('quan-ly-tai-khoan')) active @endif">
            <a class="nav-link" href="{{route('quan-ly-tai-khoan')}}">
                <i class="fas fa-user-circle"></i><p>Quản lý tài khoản</p>
            </a>
          </li>
          <li class="nav-item @if(Route::is('thong-ke-theo-phuong')) active @endif @if(Route::is('thong-ke-theo-chu-tro')) active @endif">
                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1-2" aria-controls="submenu-1-2">
                    <i class="far fa-calendar-minus"></i><p>Quản lý thống kê</p></a>
                <div id="submenu-1-2" class="collapse submenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link @if(Route::is('thong-ke-theo-phuong')) active @endif" href="{{route('thong-ke-theo-phuong')}}">
                                <p>Thống kê theo phường</p></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(Route::is('thong-ke-theo-chu-tro')) active @endif" href="{{route('thong-ke-theo-chu-tro')}}">
                                <p>Thống kê theo khu trọ</p></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(Route::is('thong-ke-sinh-vien-phuong')) active @endif" href="{{route('thong-ke-sinh-vien-phuong')}}">
                                <p>Thống kê sinh viên phường</p></a>
                        </li>
                    </ul>
                </div>
          </li>        
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a href="trang-quan-tri"><img src="{{asset('template/images/logo_tdmu.png')}}" height="60" alt="logo"></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <form class="navbar-form">
              <div class=""></div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-cog"></i>
                  <p class="d-lg-none d-md-block">
                    Tài khoản
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <span class="dropdown-item">Xin chào, {{session('tenadmin')}}</span>
                <a class="dropdown-item" href="{{route('doimatkhauadmin')}}"><i class="fas fa-edit"></i> Đổi mật khẩu</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="thoatadmin"><i class="fa fa-fw fa-rocket"></i> Đăng xuất</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
	  
	  
      <div class="content">
          <div class="row">
            <div class="col-md-12">
                    @yield('master-admin')
            </div>
          </div>
      </div>
	  
      <footer class="footer">
        <div class="container-fluid">
          <nav class="float-left">
            
          </nav>
          <div class="copyright float-right">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>, made with by Nguyen Ngoc Quy
          </div>
        </div>
      </footer>
    </div>
  </div>
  
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="assets/js/plugins/moment.min.js"></script>
  <script src="assets/js/plugins/sweetalert2.js"></script>
  <script src="assets/js/plugins/jquery.validate.min.js"></script>
  <script src="assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <script src="assets/js/plugins/bootstrap-selectpicker.js"></script>
  <script src="assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <script src="assets/js/plugins/jquery.dataTables.min.js"></script>
  <script src="assets/js/plugins/bootstrap-tagsinput.js"></script>
  <script src="assets/js/plugins/jasny-bootstrap.min.js"></script>
  <script src="assets/js/plugins/fullcalendar.min.js"></script>
  <script src="assets/js/plugins/jquery-jvectormap.js"></script>
  <script src="assets/js/plugins/nouislider.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <script src="assets/js/plugins/arrive.min.js"></script>
  {{--<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>--}}
  <script src="assets/js/plugins/chartist.min.js"></script>
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <script src="assets/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>
  <script src="template-admin/Content/assets/vendor/slimscroll/jquery.slimscroll.js"></script>
  <script src="template-admin/Content/assets/libs/js/main-js.js"></script>
  <script src="template-admin/Content/assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
  <script src="template-admin/Content/assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
  <script src="template-admin/Content/assets/vendor/charts/morris-bundle/raphael.min.js"></script>
  <script src="template-admin/Content/assets/vendor/charts/c3charts/c3.min.js"></script>
  <script src="template-admin/Content/assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
  <script src="template-admin/Content/assets/vendor/charts/c3charts/C3chartjs.js"></script>
  <script src="template/js/fade-alert.js"></script>
  <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#btnChuaDK").click(function(e){
        e.preventDefault();
        document.getElementById("frmXuatNgoaiTru").setAttribute("action", "{{ route('xuatdsSVChuaDKNgoaiTru') }}"); 
        document.getElementById("btnChuaDK").setAttribute("type", "submit");
        document.getElementById('btnChuaDK').dispatchEvent(new MouseEvent("click"));
	});

  $("#btnDaDK").click(function(e){
        e.preventDefault();
        document.getElementById("frmXuatNgoaiTru").setAttribute("action", "{{ route('xuatdsSVDKNgoaiTru') }}"); 
        document.getElementById('btnDaDK').dispatchEvent(new MouseEvent("click"));
	});

  $("#sxntmssv").click(function(e){
        e.preventDefault();
        document.getElementById("frmSXNgoaiTru").setAttribute("action", "{{route('sap-xep-ngoai-tru')}}");
        document.getElementById("cotsxnt").setAttribute("value", "mssv");  
        document.getElementById('sxntmssv').dispatchEvent(new MouseEvent("click"));
	});

  $("#sxntloaicutru").click(function(e){
        e.preventDefault();
        document.getElementById("frmSXNgoaiTru").setAttribute("action", "{{route('sap-xep-ngoai-tru')}}");
        document.getElementById("cotsxnt").setAttribute("value", "loaicutru");  
        document.getElementById('sxntloaicutru').dispatchEvent(new MouseEvent("click"));
	});

  $("#sxntlop").click(function(e){
        e.preventDefault();
        document.getElementById("frmSXNgoaiTru").setAttribute("action", "{{route('sap-xep-ngoai-tru')}}");
        document.getElementById("cotsxnt").setAttribute("value", "lop");  
        document.getElementById('sxntlop').dispatchEvent(new MouseEvent("click"));
	});

  $("#sxntngaydk").click(function(e){
        e.preventDefault();
        document.getElementById("frmSXNgoaiTru").setAttribute("action", "{{route('sap-xep-ngoai-tru')}}");
        document.getElementById("cotsxnt").setAttribute("value", "ngaydangky");  
        document.getElementById('sxntngaydk').dispatchEvent(new MouseEvent("click"));
	});

  $("#btnxemDSNgoaitru").click(function(e){
        e.preventDefault();
        document.getElementById("frmXuatNgoaiTru").setAttribute("action", "{{route('xem-ds-ngoai-tru')}}");
        document.getElementById('btnxemDSNgoaitru').dispatchEvent(new MouseEvent("click"));
  });
  
</script>
  {{-- <script src="{{asset('template/js/dssv.js')}}"></script> --}}
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');
        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');
        window_width = $(window).width();


        $('.switch-sidebar-image input').change(function() {
          $full_page_background = $('.full-page-background');
          $input = $(this);

          if ($input.is(':checked')) {
            if ($sidebar_img_container.length != 0) {
              $sidebar_img_container.fadeIn('fast');
              $sidebar.attr('data-image', '#');
            }

            if ($full_page_background.length != 0) {
              $full_page_background.fadeIn('fast');
              $full_page.attr('data-image', '#');
            }

            background_image = true;
          } else {
            if ($sidebar_img_container.length != 0) {
              $sidebar.removeAttr('data-image');
              $sidebar_img_container.fadeOut('fast');
            }

            if ($full_page_background.length != 0) {
              $full_page.removeAttr('data-image', '#');
              $full_page_background.fadeOut('fast');
            }

            background_image = false;
          }
        });

        $('.switch-sidebar-mini input').change(function() {
          $body = $('body');
          $input = $(this);

          if (md.misc.sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            md.misc.sidebar_mini_active = false;
            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();
          } else {
            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');
            setTimeout(function() {
              $('body').addClass('sidebar-mini');
              md.misc.sidebar_mini_active = true;
            }, 300);
          }

          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);

        });
      });
    });
  </script>
    
</body>

</html>