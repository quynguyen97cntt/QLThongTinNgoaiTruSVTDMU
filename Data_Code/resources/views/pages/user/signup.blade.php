@extends('layouts.master')
@section('master')
<div class="card mt-4 mb-4 container">
    <div class="pl-5 pr-5 pt-3 pb-3">

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
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="txtTennhatro" class="font-weight-bold">Tên nhà trọ <i class="text-danger">(*)</i></label>
                        <input type="text" class="form-control" id="txtTennhatro" required name="txtTennhatro">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="txtHotenlot" class="font-weight-bold">Họ và tên lót <i class="text-danger">(*)</i></label>
                        <input type="text" class="form-control" id="txtHotenlot" required name="txtHotenlot">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="txtTen" class="font-weight-bold">Tên <i class="text-danger">(*)</i></label>
                        <input type="text" class="form-control" id="txtTen" required name="txtTen">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="txtCmnd" class="font-weight-bold">CMND/Thẻ căn cước <i class="text-danger">(*)</i></label> 
                        <input type="number" class="form-control" id="txtCmnd" required name="txtCmnd">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="txtSodienthoai" class="font-weight-bold">Điện thoại <i class="text-danger">(*)</i></label>
                        <input type="number" class="form-control" id="txtSodienthoai" required name="txtSodienthoai"> 
                    </div>
                    <div class="form-group col-md-6">
                        <label for="txtEmail" class="font-weight-bold">Email <i class="text-danger">(*)</i></label>
                        <input type="email" class="form-control" id="txtEmail" required name="txtEmail">
                    </div>
                </div>

                <div class="form-row">
                    <div class="row form-group col-md-12">
                        <div class="col-md-4">
                            <label for="vido" class="font-weight-bold">Vĩ độ: <i class="text-danger">(*)</i></label>
                            <input type="text"  required readonly class="form-control" name="vido" id="vido" placeholder="Vĩ độ...">
                        </div>
                        <div class="col-md-4">
                            <label for="kinhdo" class="font-weight-bold">Kinh độ: <i class="text-danger">(*)</i></label>
                            <input type="text" required readonly class="form-control" name="kinhdo" id="kinhdo" placeholder="Kinh độ...">
                        </div>
                        <div class="form-group col-md-3">
                            <button type="button" class="btn btn-primary form-control" style="margin-top: 15%" onclick="getLocation()">Lấy vị trí hiện tại</button>
                        </div>
                    </div>
                </div>

                <p id="thongbao"></p>

                <div class="form-group">
                    <div id="mapid" style="height: 530px;"></div>
                </div>

                <div class="form-row">
                    <div class="row form-group col-md-12">
                        <div class="col-md-4">
                            <label for="sonha" class="font-weight-bold">Số nhà: <i class="text-danger">(*)</i></label>
                            <input type="text"  required class="form-control" name="sonha" id="sonha" placeholder="Số nhà...">
                        </div>
                        <div class="col-md-4">
                            <label for="tenduong" class="font-weight-bold">Tên đường: <i class="text-danger">(*)</i></label>
                            <input type="text" required class="form-control" name="tenduong" id="tenduong" placeholder="Tên đường...">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="phuongxa" class="font-weight-bold">Phường/ xã: <i class="text-danger">(*)</i></label>
                            <input type="text" required class="form-control" name="phuongxa" readonly id="phuongxa" placeholder="Phường xã...">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="row form-group col-md-12">
                        <div class="col-md-4">
                            <label for="mathue" class="font-weight-bold">Mã số thuế: <i class="text-danger">(*)</i></label>
                            <input type="text"  required class="form-control" name="mathue" id="mathue" placeholder="Mã số thuế...">
                        </div>
                        <div class="col-md-6">
                            <label for="gpkd" class="font-weight-bold">Hình ảnh giấy phép kinh doanh: <i class="text-danger">(*)</i></label>
                            <input type="file" required class="form-control" name="gpkd" accept="image/*" required="true" onchange="validateFileType()" id="gpkd">
                        </div>
                    </div>
                </div>

                <div class="form-check">
                    <input type="checkbox" required class="form-check-input" id="dieukhoan" >
                    <label class="form-check-label" for="dieukhoan">Tôi cam kết thông tin tôi đăng ký là chính xác và chịu mọi trách nhiệm nếu cung cấp thông tin sai.</label>
                </div>
                <br />
                <button type="submit" class="btn btn-primary">Đăng ký</button>
            </form>
    </div>
</div>

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
        onLoadMap(position.coords.longitude, position.coords.latitude);
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
            <script src="./js/geojsondata.js"></script>
            <script>
                L.control.locate().addTo(map);

                    function createCustomIcon(feature, latlng) {
                        let myIcon = L.icon({
                            iconUrl: './img/iconruonghoc.png',

                            iconSize: [38, 50],
                            iconAnchor: [22, 45],
                        })
                        return L.marker(latlng, { icon: myIcon })
                    }

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

                    var tempLayer = L.layerGroup();
                    map.addLayer(tempLayer);

                    function onLoadMap(kinhdo, vido)
                    {
                        tempLayer.clearLayers();

                        $.ajax({
                                    type: "POST",
                                    url: "/sinhvienngoaitru/checkLocation",
                                    data: {"_token": "{{ csrf_token() }}",kinhdo: kinhdo, vido: vido},
                                    dataType: 'json',
                                    success: function (data) {
                                        if(data.trangthai == "1")
                                        {
                                            document.getElementById("vido").value = vido;
                                            document.getElementById("kinhdo").value = kinhdo;
                                            tempLayer.addLayer(L.marker([vido, kinhdo]));
                                            map.flyTo([vido, kinhdo], 15);
                                        }
                                        else
                                        {
                                            document.getElementById("vido").value = "";
                                            document.getElementById("kinhdo").value = "";
                                            alert(data.trangthai);
                                        }  
                                    },
                                    error: function (xhr, status, error) {
                                        alert("Thất bại!");
                                    }
                                });
                    }

                    var popup = L.popup();
                        function onMapClick(e)
                        {
                            tempLayer.clearLayers();

                            $.ajax({
                                    type: "POST",
                                    url: "/sinhvienngoaitru/checkLocation",
                                    data: {"_token": "{{ csrf_token() }}",kinhdo: e.latlng.lng, vido: e.latlng.lat},
                                    dataType: 'json',
                                    success: function (data) {
                                        if(data.trangthai == "1")
                                        {
                                            document.getElementById("vido").value = e.latlng.lat;
                                            document.getElementById("kinhdo").value = e.latlng.lng;
                                            tempLayer.addLayer(L.marker([e.latlng.lat, e.latlng.lng]));
                                            document.getElementById("phuongxa").value = data.tenphuong + ", Thủ Dầu Một, Bình Dương";
                                        }
                                        else
                                        {
                                            document.getElementById("vido").value = "";
                                            document.getElementById("kinhdo").value = "";
                                            document.getElementById("phuongxa").value = "";
                                            alert(data.trangthai);
                                        }  
                                    },
                                    error: function (xhr, status, error) {
                                        alert("Thất bại!");
                                    }
                                });

                            
                        }
                    map.on('click',onMapClick);

                    function validateFileType(){
                        var fileName = document.getElementById("gpkd").value;
                        var idxDot = fileName.lastIndexOf(".") + 1;
                        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
                        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png")
                        {}
                        else
                        {
                            document.getElementById("gpkd").value = "";
                            alert("Only jpg/jpeg and png files are allowed!");
                        }   
                    }
            </script>
@endsection