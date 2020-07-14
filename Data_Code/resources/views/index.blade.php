@extends('layouts.master')
@section('master')
<div class="card">
    <div class="card-body">
        <div>
            <div>
                <div class="form-group row">
                    <label class="font-weight-bold mr-2 ml-2 mt-2">Giá phòng</label>
                    <form action="{{route('/')}}" method="GET" id="frmLocGiaPhong" class="form-group col-sm-12 col-md-2 mr-5">
                    @csrf
                        <select name="giaphong"  id="giaphong" class="form-control">
                            <option value="all">---Xem tất cả---</option>
                            <option value="1000000">Khoảng 1 triệu</option>
                            <option value="2000000">Từ 1 triệu đến 2 triệu</option>
                            <option value="3000000">Từ 2 triệu đến 3 triệu</option>
                        </select>
                    </form>

                    <label class="font-weight-bold ml-2 mr-2 mt-2">Tìm kiếm</label>
                    <form action="{{route('timkiemkhunhatro')}}" method="GET" class="form-group col-sm-12 col-md-3">
                        <input class="form-control" name="timkhutro" type="text" placeholder="Nhập tên chủ trọ, tên nhà trọ...">
                    </form>
                </div>

                <div class="form-group row">
                    <label class="font-weight-bold mr-2 ml-2 mt-2">Xem theo lớp</label>
                    <form action="{{route('/')}}" method="GET" id="frmLocGiaPhong" class="form-group col-sm-12 col-md-2 mr-5">
                    @csrf
                        <select name="xemtheolop"  id="xemtheolop" class="form-control">
                            <option value="all">---Xem tất cả---</option>
                            <option value="D16HT01">D16HT01</option>
                            <option value="D16PM01">D16PM01</option>
                            <option value="D16PM02">D16PM02</option>
                        </select>
                    </form>

                    <form class="form-group col-sm-12 col-md-2">
                        <input type="checkbox" id="statusStudentsTC" >
                        <label class="font-weight-bold mr-2 mt-2">Có sinh viên</label>
                    </form>
                    <label class="font-weight-bold ml-2 mr-2 mt-2">Phóng to</label>

                    <form class="form-group col-sm-12 mr-5 col-md-2">
                        <select name="phuongxa"  id="phuongxa" class="form-control">
                            <option value="">---Chọn khu vực---</option>
                            @foreach($phuongxa as $px)
                                <option value="{{$px->toadodiem}}">{{$px->tenpx}}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script src="{{asset('js/leaflet.js')}}"></script>
            <script src="{{asset('js/L.Control.Locate.min.js')}}"></script>
            <script src="{{asset('js/leaflet-search.js')}}"></script>
                
            <div id="contentchange">
                    <div class="row justify-content-center ">
                        <div id="mapid" style="height: 530px;"></div>
                    </div>
                    <script>
                        var map = L.map('mapid').setView([10.9805, 106.6745], 13);
                        var geojsonFeature = {
                                            "type": "FeatureCollection",
                                                "features": [
                                                    <?php echo $geojson; ?>
                                                ]
                                            };
                        L.geoJson({
                            "type": "FeatureCollection",
                            "features": [
                                            @foreach($phuongxaload as $px)
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
                                            select(e.target);
                                        }
                                    });
                                }
                        }).addTo(map);
                    </script>
                    <script src="./js/geojson.js"></script>
            </div>
        </div>
    </div>
</div>
@endsection