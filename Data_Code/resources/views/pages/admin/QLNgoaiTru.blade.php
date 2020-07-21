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
                        <li class="breadcrumb-item active" aria-current="page">Quản lý ngoại trú</li>
                    </ol>
                </nav>
            </div>

            <!-- Search bar -->
            <div class="col-md-5 navbar-nav ml-3">
                <form action="{{route('tim-kiem-ngoai-tru')}}" method="GET">
                    <div id="custom-search" class="top-search-bar">
                        <input class="form-control" name="timkiemngoaitru" type="text" placeholder="Nhập mã SV hoặc mã lớp..">
                    </div>
                </form>
            </div>
            <!-- End search bar -->

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
        @if($trangthai===1)
            @foreach($thoigian as $item)
                <form action="{{ route('thietlapTG')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-3">
                            <label class="col-form-label font-weight-bold">Ngày bắt đầu:</label>
                            <input type="date" class="form-control" name="ngaybatdau" id="ngaybatdau"
                                value="{{$item->ngaybatdau}}">
                        </div>
                        <div class="form-group col-3">
                            <label class="col-form-label font-weight-bold">Ngày kết thúc:</label>
                            <input type="date" class="form-control" name="ngayketthuc" id="ngayketthuc"
                                value="{{$item->ngayketthuc}}">
                        </div>
                        <div class="col-1">
                            <button type="submit" class="form-control rounded-circle" name="thietlap" id="thietlap" style="margin-top: 90%;"><i class="fas fa-wrench"></i></button>
                        </div>
                    </div>
                </form>
            @endforeach
        @else
                <form action="{{ route('thietlapTG')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-3">
                            <label class="col-form-label font-weight-bold">Ngày bắt đầu:</label>
                            <input type="date" class="form-control" name="ngaybatdau" id="ngaybatdau"
                                value="">
                        </div>
                        <div class="form-group col-3">
                            <label class="col-form-label font-weight-bold">Ngày kết thúc:</label>
                            <input type="date" class="form-control" name="ngayketthuc" id="ngayketthuc"
                                value="">
                        </div>
                        <div class="col-1">
                            <button type="submit" class="form-control rounded-circle" name="thietlap" id="thietlap" style="margin-top: 90%;"><i class="fas fa-wrench"></i></button>
                        </div>
                    </div>
                </form>
        @endif

        <form action="{{ route('xuatdsSVDKNgoaiTru') }}" id="frmXuatNgoaiTru" method="post">
            @csrf
            @if($trangthai===1)
            @foreach($thoigian as $item)
                <div class="row">
                            <div class="form-group col-3">
                                <label class="col-form-label font-weight-bold">Từ ngày (xuất):</label>
                                <input type="date" class="form-control" name="ngaybatdauxuat" id="ngaybatdauxuat"
                                    value="{{$item->ngaybatdau}}">
                            </div>
                            <div class="form-group col-3">
                                <label class="col-form-label font-weight-bold">Đến ngày (xuất):</label>
                                <input type="date" class="form-control" name="ngayketthucxuat" id="ngayketthucxuat"
                                    value="{{$item->ngayketthuc}}">
                            </div>
                            <div class="col-1">
                                <button type="submit" class="form-control rounded-circle" name="btnxemDSNgoaitru" id="btnxemDSNgoaitru" style="margin-top: 90%;"><i class="fas fa-list"></i></button>
                            </div>
                </div>
            @endforeach
            @else
                <div class="row">
                                <div class="form-group col-3">
                                    <label class="col-form-label font-weight-bold">Từ ngày (xuất):</label>
                                    <input type="date" class="form-control" name="ngaybatdauxuat" id="ngaybatdauxuat"
                                        value="">
                                </div>
                                <div class="form-group col-3">
                                    <label class="col-form-label font-weight-bold">Đến ngày (xuất):</label>
                                    <input type="date" class="form-control" name="ngayketthucxuat" id="ngayketthucxuat"
                                        value="">
                                </div>
                                <div class="col-1">
                                    <button type="submit" class="form-control rounded-circle" name="btnxemDSNgoaitru" id="btnxemDSNgoaitru" style="margin-top: 90%;"><i class="fas fa-list"></i></button>
                                </div>
                    </div>
            @endif
            <div class="row">
                        <div class="form-group col-3">
                            <label class="col-form-label font-weight-bold">Loại cư trú:</label>
                            <select class="form-control" name="cbLoaicutru" id="cbLoaicutru">
                                <option value="alltype">Tất cả</option>
                                <option value="0">Thường trú</option>
                                <option value="1">Tạm trú</option>
                            </select>
                        </div>
                        <div class="form-group col-3">
                            <label class="col-form-label font-weight-bold">Lớp:</label>
                            <select class="form-control" name="cbLop" id="cbLop">
                                <option value="allclass">Tất cả</option>
                                <option value="D16HT01">D16HT01</option>
                                <option value="D16PM01">D16PM01</option>
                                <option value="D16PM02">D16PM02</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <input type="submit" class="form-control btn btn-primary" name="btnDaDK" id="btnDaDK" style="margin-top: 32%"
                                value="Đã đăng ký">
                        </div>
                        <div class="col-2">
                            <input type="button" class="form-control btn btn-primary" name="btnChuaDK" id="btnChuaDK" style="margin-top: 32%"
                                value="Chưa đăng ký">
                        </div>
                    </div>
        </form>
        <div>Tổng số: <?php echo $tongsl."/".$tongsv; ?> sinh viên đã cập nhật</div>
        <div id="mapid" class="col-md-12" style="height: 530px;"></div>

                            <!-- Modal thông tin -->

                            <div class="modal fade" id="mdXemTTNgoaiTru" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="modal-title" id="editModalLabel">Thông tin chi tiết ngoại trú</h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">MSSV:</label>
                                                            <input type="text" class="form-control" id="mssv" value=""
                                                                disabled>
                                                        </div> 
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Tên SV:</label>
                                                            <input type="text" class="form-control" id="tensv"
                                                                value="" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Tên chủ hộ/ chủ trọ:</label>
                                                            <input type="text" class="form-control" id="tenchngoaitru"
                                                                value="" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Điện thoại ngoại trú:</label>
                                                            <input type="text" class="form-control" id="dienthoaingoaitru"
                                                                value="" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Địa chỉ ngoại trú:</label>
                                                            <input type="text" class="form-control" id="diachingoaitru"
                                                                value="" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Loại cư trú:</label>
                                                            <input type="text" class="form-control" id="loaicutru"
                                                                value="" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Lớp:</label>
                                                            <input type="text" class="form-control" id="lop"
                                                                value="" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label class="col-form-label font-weight-bold">Ngày đăng ký:</label>
                                                            <input type="date" class="form-control" id="ngaydangky"
                                                                value="" disabled>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <div id="btnChiDuong"></div>
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Đóng</button>

                                            </div>
                                    </div>
                                </div>
                            </div>

                            <!-- End modal thông tin -->
    </div>
</div>
    <!-- Kết thúc nội dung -->
    
    <script>
    var x = document.getElementById("thongbao");

    function getLocation() {
        if (navigator.geolocation) 
        {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } 
        else 
        {
            x.innerHTML = "Geolocation không được hỗ trợ bởi trình duyệt này.";
        }
    }

    function showPosition(position) {
        document.getElementById("vido").value = position.coords.latitude;
        document.getElementById("kinhdo").value = position.coords.longitude;
        //x.innerHTML = "Vĩ độ: " + position.coords.latitude + "<br>Kinh độ: " + position.coords.longitude;
    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                x.innerHTML = "Người sử dụng từ chối cho xác định vị trí."
                break;
            case error.POSITION_UNAVAILABLE:
                x.innerHTML = "Thông tin vị trí không có sẵn."
                break;
            case error.TIMEOUT:
                x.innerHTML = "Yêu cầu vị trí người dùng vượt quá thời gian quy định."
                break;
            case error.UNKNOWN_ERROR:
                x.innerHTML = "Một lỗi xảy ra không rõ nguyên nhân."
                break;
        }
    }
</script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script src="{{asset('js/leaflet.js')}}"></script>
            <script src="{{asset('js/L.Control.Locate.min.js')}}"></script>
            <script src="{{asset('js/leaflet-search.js')}}"></script>
            <script>
                var map = L.map('mapid').setView([10.9805, 106.6745], 13);
            </script>
            
            <script src="./js/geojsonbackground.js"></script>
            <script>
                var geojsonFeature = {

                    "type": "FeatureCollection",
                    "features": [
                                    @foreach($TTNgoaitru as $ngoaitru)
                                    {
                                        "type": "Feature",
                                        "properties": {
                                        "marker-color": "#ff0000",
                                        "marker-size": "medium",
                                        "marker-symbol": "",
                                        "mssv": "\"{{$ngoaitru->mssv}}\"",
                                        "tenchungoaitru": "\"{{$ngoaitru->tenchungoaitru}}\"",
                                        "dienthoaichungoaitru": "\"{{$ngoaitru->dienthoaichungoaitru}}\"",
                                        "diachingoaitru": "\"{{$ngoaitru->diachingoaitru}}\"",
                                        "loaicutru": "\"{{$ngoaitru->loaicutru}}\"",
                                        "ngaydangky": "\"{{$ngoaitru->ngaydangky}}\"",
                                        "ho": "\"{{$ngoaitru->ho}}\"",
                                        "ten": "\"{{$ngoaitru->ten}}\"",
                                        "vido": "\"{{$ngoaitru->vido}}\"",
                                        "kinhdo": "\"{{$ngoaitru->kinhdo}}\"",
                                        "lop": "\"{{$ngoaitru->lop}}\"",
                                        "x": "\"{{$ngoaitru->x}}\"",
                                        "y": "\"{{$ngoaitru->y}}\"",
                                    },
                                    "geometry": {
                                    "type": "Point",
                                    "coordinates": [
                                                {{ $ngoaitru-> x}},
                                                {{ $ngoaitru-> y}}
                                        ]
                                    }
                                },
                                    @endforeach
                                ]
                            };
        </script>
        <script src="./js/geojsondata.js"></script>
        <script>
            var tempLayer = L.layerGroup();
            var tempLayer2 = L.layerGroup();
            map.addLayer(tempLayer2);

            IconStyleTwo = L.icon({
                iconUrl: 'assets/img/marker-icon2.png'
            });

            IconStyleDefault = L.icon({
                iconUrl: 'assets/img/marker-icon.png'
            });
                L.control.locate().addTo(map);
                var khutro = L.geoJson(geojsonFeature, {
                    onEachFeature: function (feature, layer) {
                        layer.on({
                            click: function () {
                                if(tempLayer2.getLayers().length>0)
                                {
                                    tempLayer2.eachLayer(function (layer2) {
                                        layer2.setIcon(IconStyleDefault);
                                    });
                                }
                                tempLayer2.addLayer(layer.setIcon(IconStyleTwo));
                                tempLayer.clearLayers();

                                var mssv = feature.properties.mssv.replace(/\"/g, "");
                                var tenchungoaitru = feature.properties.tenchungoaitru.replace(/\"/g, "");
                                var dienthoaichungoaitru = feature.properties.dienthoaichungoaitru.replace(/\"/g, "");
                                var diachingoaitru = feature.properties.diachingoaitru.replace(/\"/g, "");
                                var loaicutru = feature.properties.loaicutru.replace(/\"/g, "");
                                var ngaydangky = feature.properties.ngaydangky.replace(/\"/g, "");
                                var lop = feature.properties.lop.replace(/\"/g, "");
                                var ho = feature.properties.ho.replace(/\"/g, "");
                                var ten = feature.properties.ten.replace(/\"/g, "");

                                document.getElementById("mssv").setAttribute("value", mssv);
                                document.getElementById("tensv").setAttribute("value", ho + " " + ten);
                                document.getElementById("tenchngoaitru").setAttribute("value", tenchungoaitru);
                                document.getElementById("dienthoaingoaitru").setAttribute("value", dienthoaichungoaitru);
                                document.getElementById("diachingoaitru").setAttribute("value", diachingoaitru);
                                document.getElementById("loaicutru").setAttribute("value", loaicutru);
                                document.getElementById("lop").setAttribute("value", lop);
                                document.getElementById("ngaydangky").setAttribute("value", ngaydangky);

                                $("#btnChiDuong").html('<a class="btn btn-outline-primary" target="_blank" href="https://www.google.com/maps/place/'+ feature.properties.y.replace(/\"/g, "") + ', '+ feature.properties.x.replace(/\"/g, "") +'?hl=vi-VN">Chỉ đường</a>');
                                $('#mdXemTTNgoaiTru').modal('show'); 
                            }
                        });
                    }
                }).addTo(map);

                    function createCustomIcon(feature, latlng) {
                        let myIcon = L.icon({
                            iconUrl: './img/iconruonghoc.png',

                            iconSize: [38, 50],
                            iconAnchor: [22, 45],
                        })
                        return L.marker(latlng, { icon: myIcon })
                    }

                    var truonghoc =L.geoJson(geojsonSchool,{
                        pointToLayer: createCustomIcon,
                        onEachFeature: function (feature, layer)
                        {
                            layer.bindPopup('<div style="width: 360px; font-weight: bold; font-size: 14px;">Tên trường: ' + feature.properties.tentruong + '<br /> Điện thoại: '+ feature.properties.dienthoai + '<br /> Địa chỉ: '+ feature.properties.diachi+"</div>");
                        }
                    }).addTo(map);

                    function highlight (layer) {
                        layer.setStyle({
                            fillOpacity: 0.01,
                        });
                        if (!L.Browser.ie && !L.Browser.opera) {
                            layer.bringToFront();
                        }
                    }

                    function dehighlight (layer) {
                    if (selected === null || selected._leaflet_id !== layer._leaflet_id) {
                        layer.setStyle({
                            fillOpacity: 0.2,
                        });
                    }
                    }

                    function select (layer) {
                    if (selected !== null) {
                        var previous = selected;
                    }
                        map.fitBounds(layer.getBounds());
                        selected = layer;
                        if (previous) {
                        dehighlight(previous);
                        }
                    }

                    var selected = null;

                    L.geoJson({
                        "type": "FeatureCollection",
                        "features": [
                                        @foreach($phuongxa as $px)
                                        {
                                            "type": "Feature",
                                            "properties": {
                                            "marker-color": "#ff0000",
                                            "marker-size": "medium",
                                            "marker-symbol": "",
                                            "gid": "\"{{$px['gid']}}\"",
                                            "fillColor": "{{$px['fillColor']}}",
                                            "color": "{{$px['color']}}",
                                            "tenphuong": "{{$px['tenphuong']}}"
                                        },
                                        "geometry": {
                                        "type": "Polygon",
                                        "coordinates": [
                                                    {{$px['geom']}}
                                            ]
                                        }
                                    },
                                        @endforeach
                                    ]
                        }, {
                            style: function (feature) {
                                return {
                                    weight: 2,
                                    color: feature.properties.color,
                                    fillColor: feature.properties.fillColor,
                                    fillOpacity: 0.2,
                                    radius: 500,
                                };
                            },
                            onEachFeature: function (feature, layer) {
                            layer.on({
                                    'mouseover': function (e) {
                                        highlight(e.target);
                                    },
                                    'mouseout': function (e) {
                                        dehighlight(e.target);
                                    },
                                    'click': function (e) {
                                    }
                                });
                            }
                    }).addTo(map);
                  
            </script>

@endsection