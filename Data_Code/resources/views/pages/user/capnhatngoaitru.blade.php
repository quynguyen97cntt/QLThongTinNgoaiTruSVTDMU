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
        
        @if($trangthai===1)
            @if($thuocnhatro===1)
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="ttchutro" class="font-weight-bold">Thông tin chủ trọ: <i class="text-danger">(*)</i></label>
                        <select name="ttchutro" id="ttchutro" onchange="setLuachonnhatro()" class="form-control">
                                <option value="0">--------- Chọn nhà trọ ---------</option>
                        @if($thuocnhatro===1)
                            @foreach($khutro2 as $item3)
                                <option value="{{$item3->gid}}" @if($item3->gid===$khutro[0]->gid) selected="selected" @endif>Họ tên: {{$item3->tenchutro}} - SĐT: {{$item3->sodienthoai}}</option>
                            @endforeach
                        @else
                            @foreach($khutro2 as $item3)
                                <option value="{{$item3->gid}}">Họ tên: {{$item3->tenchutro}} - SĐT: {{$item3->sodienthoai}}</option>
                            @endforeach
                        @endif
                        </select>
                    </div>
                </div>
                @foreach($SVNgoaiTru as $item)
                    <form action="{{route('capnhatTTNgoaitruSV',['mssv' => session('mssv')])}}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="checkbox" name="dangonharieng" id="dangonharieng" onchange="checkStatus2()">
                                <label  for="dangonharieng"  class="font-weight-bold mr-2 mt-2">Đang ở nhà riêng hoặc nhà trọ chưa liên kết với trường</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="loaicutru" class="font-weight-bold">Loại cư trú: <i class="text-danger">(*)</i></label>
                                <select name="loaicutru" id="loaicutru" disabled class="form-control">
                                    <option value="0" @if($item->loaicutru===0) selected="selected" @endif>Thường trú</option>
                                    <option value="1" @if($item->loaicutru===1) selected="selected" @endif>Tạm trú</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tenchungoaitru" class="font-weight-bold">Tên chủ hộ\chủ nhà trọ: <i class="text-danger">(*)</i></label>
                            <input type="text" class="form-control" name="tenchungoaitru" readonly id="tenchungoaitru" value="{{$item->tenchungoaitru}}" placeholder="Tên chủ hộ\chủ nhà trọ...">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="dienthoaichungoaitru" class="font-weight-bold">Điện thoại chủ hộ\chủ nhà trọ: <i class="text-danger">(*)</i></label>
                                <input type="number" class="form-control" readonly required name="dienthoaichungoaitru" id="dienthoaichungoaitru" value="{{$item->dienthoaichungoaitru}}" placeholder="Điện thoại chủ hộ\chủ nhà trọ...">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ngaydangky" class="font-weight-bold">Ngày đăng ký ngoại trú: </label>
                            <input type="date" class="form-control" readonly name="ngaydangky" value="{{date($item->ngaydangky)}}" id="ngaydangky">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="row form-group col-md-12">
                                <div class="col-md-4">
                                    <label for="vido" class="font-weight-bold">Vĩ dộ: <i class="text-danger">(*)</i></label>
                                    <input type="text" class="form-control" readonly required name="vido" id="vido" value="{{$item->vido}}" placeholder="Vĩ độ...">
                                </div>
                                <div class="col-md-4"> 
                                    <label for="kinhdo" class="font-weight-bold">Kinh độ: <i class="text-danger">(*)</i></label>
                                    <input type="text" class="form-control" readonly required name="kinhdo" id="kinhdo" value="{{$item->kinhdo}}" placeholder="Kinh độ...">
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="button" class="btn btn-primary form-control" id="btngetLocation" disabled  style="margin-top: 15%" onclick="getLocation()">Lấy vị trí hiện tại</button>
                                </div>
                            </div>
                        </div>
                        
                        <p id="thongbao"></p>

                        <div class="form-group">
                            <div id="mapid" style="height: 530px;"></div>
                        </div>

                        <div class="form-group">
                            <label for="diachi" class="font-weight-bold">Địa chỉ chủ hộ\chủ nhà trọ: <i class="text-danger">(*)</i></label>
                            <textarea class="form-control" readonly required rows="6" style="resize: none" name="diachi"
                        id="diachi">{{$item->diachingoaitru}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                @endforeach
            @else
            <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="ttchutro" class="font-weight-bold">Thông tin chủ trọ: <i class="text-danger">(*)</i></label>
                        <select name="ttchutro" id="ttchutro" disabled onchange="setLuachonnhatro()" class="form-control">
                                <option value="0">--------- Chọn nhà trọ ---------</option>
                        @if($thuocnhatro===1)
                            @foreach($khutro2 as $item3)
                                <option value="{{$item3->gid}}" @if($item3->gid===$khutro[0]->gid) selected="selected" @endif>Họ tên: {{$item3->tenchutro}} - SĐT: {{$item3->sodienthoai}}</option>
                            @endforeach
                        @else
                            @foreach($khutro2 as $item3)
                                <option value="{{$item3->gid}}">Họ tên: {{$item3->tenchutro}} - SĐT: {{$item3->sodienthoai}}</option>
                            @endforeach
                        @endif
                        </select>
                    </div>
                </div>
            @foreach($SVNgoaiTru as $item)
                    <form action="{{route('capnhatTTNgoaitruSV',['mssv' => session('mssv')])}}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="checkbox" name="dangonharieng" checked id="dangonharieng" onchange="checkStatus2()">
                                <label  for="dangonharieng"  class="font-weight-bold mr-2 mt-2">Đang ở nhà riêng hoặc nhà trọ chưa liên kết với trường</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="loaicutru" class="font-weight-bold">Loại cư trú: <i class="text-danger">(*)</i></label>
                                <select name="loaicutru" id="loaicutru" class="form-control">
                                    <option value="0" @if($item->loaicutru===0) selected="selected" @endif>Thường trú</option>
                                    <option value="1" @if($item->loaicutru===1) selected="selected" @endif>Tạm trú</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tenchungoaitru" class="font-weight-bold">Tên chủ hộ\chủ nhà trọ: <i class="text-danger">(*)</i></label>
                            <input type="text" class="form-control" name="tenchungoaitru" id="tenchungoaitru" value="{{$item->tenchungoaitru}}" placeholder="Tên chủ hộ\chủ nhà trọ...">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="dienthoaichungoaitru" class="font-weight-bold">Điện thoại chủ hộ\chủ nhà trọ: <i class="text-danger">(*)</i></label>
                                <input type="number" class="form-control" required name="dienthoaichungoaitru" id="dienthoaichungoaitru" value="{{$item->dienthoaichungoaitru}}" placeholder="Điện thoại chủ hộ\chủ nhà trọ...">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ngaydangky" class="font-weight-bold">Ngày đăng ký ngoại trú: </label>
                            <input type="date" class="form-control" name="ngaydangky" value="{{date($item->ngaydangky)}}" id="ngaydangky">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="row form-group col-md-12">
                                <div class="col-md-4">
                                    <label for="vido" class="font-weight-bold">Vĩ dộ: <i class="text-danger">(*)</i></label>
                                    <input type="text" class="form-control" required name="vido" id="vido" value="{{$item->vido}}" placeholder="Vĩ độ...">
                                </div>
                                <div class="col-md-4"> 
                                    <label for="kinhdo" class="font-weight-bold">Kinh độ: <i class="text-danger">(*)</i></label>
                                    <input type="text" class="form-control" required name="kinhdo" id="kinhdo" value="{{$item->kinhdo}}" placeholder="Kinh độ...">
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="button" class="btn btn-primary form-control" style="margin-top: 15%" id="btngetLocation" onclick="getLocation()">Lấy vị trí hiện tại</button>
                                </div>
                            </div>
                        </div>
                        
                        <p id="thongbao"></p>

                        <div class="form-group">
                            <div id="mapid" style="height: 530px;"></div>
                        </div>

                        <div class="form-group">
                            <label for="diachi" class="font-weight-bold">Địa chỉ chủ hộ\chủ nhà trọ: <i class="text-danger">(*)</i></label>
                            <textarea class="form-control" required rows="6" style="resize: none" name="diachi"
                        id="diachi">{{$item->diachingoaitru}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                @endforeach
            @endif
        @else
            @if($thuocnhatro===1)
            <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="ttchutro" class="font-weight-bold">Thông tin chủ trọ: <i class="text-danger">(*)</i></label>
                        <select name="ttchutro" id="ttchutro" onchange="setLuachonnhatro()" class="form-control">
                                <option value="0">--------- Chọn nhà trọ ---------</option>
                        @if($thuocnhatro===1)
                            @foreach($khutro2 as $item3)
                                <option value="{{$item3->gid}}" @if($item3->gid===$khutro[0]->gid) selected="selected" @endif>Họ tên: {{$item3->tenchutro}} - SĐT: {{$item3->sodienthoai}}</option>
                            @endforeach
                        @else
                            @foreach($khutro2 as $item3)
                                <option value="{{$item3->gid}}">Họ tên: {{$item3->tenchutro}} - SĐT: {{$item3->sodienthoai}}</option>
                            @endforeach
                        @endif
                        </select>
                    </div>
                </div>
                @foreach($khutro as $item2)
                    <form action="{{route('capnhatTTNgoaitruSV',['mssv' => session('mssv')])}}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="checkbox" name="dangonharieng" id="dangonharieng" onchange="checkStatus()">
                                <label for="dangonharieng" class="font-weight-bold mr-2 mt-2">Đang ở nhà riêng hoặc nhà trọ chưa liên kết với trường</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="loaicutru" class="font-weight-bold">Loại cư trú: <i class="text-danger">(*)</i></label>
                                <select name="loaicutru" disabled id="loaicutru" class="form-control">
                                    <option value="0">Thường trú</option>
                                    <option value="1" selected="selected">Tạm trú</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tenchungoaitru" class="font-weight-bold">Tên chủ hộ\chủ nhà trọ: <i class="text-danger">(*)</i></label>
                            <input type="text" readonly required class="form-control" name="tenchungoaitru" id="tenchungoaitru" placeholder="Tên chủ hộ\chủ nhà trọ..." value="{{$item2->tenchutro}}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="dienthoaichungoaitru" class="font-weight-bold">Điện thoại chủ hộ\chủ nhà trọ: <i class="text-danger">(*)</i></label>
                                <input type="number" class="form-control" readonly required name="dienthoaichungoaitru" id="dienthoaichungoaitru" placeholder="Điện thoại chủ hộ\chủ nhà trọ..." value="{{$item2->sodienthoai}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ngaydangky" class="font-weight-bold">Ngày đăng ký ngoại trú: </label>
                            <input type="date" class="form-control" name="ngaydangky" readonly value="{{date('Y-m-d')}}" id="ngaydangky">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="row form-group col-md-12">
                                <div class="col-md-4">
                                    <label for="vido" class="font-weight-bold">Vĩ độ: <i class="text-danger">(*)</i></label>
                                    <input type="text" readonly  required onchange="setVitri()" class="form-control" name="vido" id="vido" placeholder="Vĩ độ..." value="{{$item2->y}}">
                                </div>
                                <div class="col-md-4">
                                    <label for="kinhdo" class="font-weight-bold">Kinh độ: <i class="text-danger">(*)</i></label>
                                    <input type="text" readonly required onchange="setVitri()" class="form-control" name="kinhdo" id="kinhdo" placeholder="Kinh độ..." value="{{$item2->x}}">
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="button" class="btn btn-primary form-control" id="btngetLocation" disabled style="margin-top: 15%" onclick="getLocation()">Lấy vị trí hiện tại</button>
                                </div>
                            </div>
                        </div>

                        <p id="thongbao"></p>

                        <div class="form-group">
                            <div id="mapid" style="height: 530px;"></div>
                        </div>

                        <div class="form-group">
                            <label for="diachi" class="font-weight-bold">Địa chỉ chủ hộ\chủ nhà trọ: <i class="text-danger">(*)</i></label>
                            <textarea class="form-control" readonly required rows="6" style="resize: none" name="diachi"
                                id="diachi">{{$item2->diachi}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                @endforeach
            @else
            <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="ttchutro" class="font-weight-bold">Thông tin chủ trọ: <i class="text-danger">(*)</i></label>
                        <select name="ttchutro" id="ttchutro" onchange="setLuachonnhatro()" class="form-control">
                                <option value="0">--------- Chọn nhà trọ ---------</option>
                        @if($thuocnhatro===1)
                            @foreach($khutro2 as $item3)
                                <option value="{{$item3->gid}}" @if($item3->gid===$khutro[0]->gid) selected="selected" @endif>Họ tên: {{$item3->tenchutro}} - SĐT: {{$item3->sodienthoai}}</option>
                            @endforeach
                        @else
                            @foreach($khutro2 as $item3)
                                <option value="{{$item3->gid}}">Họ tên: {{$item3->tenchutro}} - SĐT: {{$item3->sodienthoai}}</option>
                            @endforeach
                        @endif
                        </select>
                    </div>
                </div>
            <form action="{{route('capnhatTTNgoaitruSV',['mssv' => session('mssv')])}}" method="POST">
                    @csrf
                    <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="checkbox" name="dangonharieng" id="dangonharieng" onchange="checkStatus()">
                                <label for="dangonharieng" class="font-weight-bold mr-2 mt-2">Đang ở nhà riêng hoặc nhà trọ chưa liên kết với trường</label>
                            </div>
                        </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="loaicutru" class="font-weight-bold">Loại cư trú: <i class="text-danger">(*)</i></label>
                            <select name="loaicutru" disabled id="loaicutru" class="form-control">
                                <option value="0">Thường trú</option>
                                <option value="1">Tạm trú</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tenchungoaitru" class="font-weight-bold">Tên chủ hộ\chủ nhà trọ: <i class="text-danger">(*)</i></label>
                        <input type="text" readonly required class="form-control" name="tenchungoaitru" id="tenchungoaitru" placeholder="Tên chủ hộ\chủ nhà trọ...">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="dienthoaichungoaitru" class="font-weight-bold">Điện thoại chủ hộ\chủ nhà trọ: <i class="text-danger">(*)</i></label>
                            <input type="number" class="form-control" readonly required name="dienthoaichungoaitru" id="dienthoaichungoaitru" placeholder="Điện thoại chủ hộ\chủ nhà trọ...">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="ngaydangky" class="font-weight-bold">Ngày đăng ký ngoại trú: </label>
                        <input type="date" class="form-control" name="ngaydangky" readonly value="{{date('Y-m-d')}}" id="ngaydangky">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="row form-group col-md-12">
                            <div class="col-md-4">
                                <label for="vido" class="font-weight-bold">Vĩ độ: <i class="text-danger">(*)</i></label>
                                <input type="text" readonly  required class="form-control" name="vido" id="vido" placeholder="Vĩ độ...">
                            </div>
                            <div class="col-md-4">
                                <label for="kinhdo" class="font-weight-bold">Kinh độ: <i class="text-danger">(*)</i></label>
                                <input type="text" readonly required class="form-control" name="kinhdo" id="kinhdo" placeholder="Kinh độ...">
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

                    <div class="form-group">
                        <label for="diachi" class="font-weight-bold">Địa chỉ chủ hộ\chủ nhà trọ: <i class="text-danger">(*)</i></label>
                        <textarea class="form-control" readonly required rows="6" style="resize: none" name="diachi"
                            id="diachi"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            @endif
        @endif
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
        document.getElementById("vido").value = position.coords.latitude;
        document.getElementById("kinhdo").value = position.coords.longitude;
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
                        document.getElementById("vido").value = vido;
                        document.getElementById("kinhdo").value = kinhdo;
                        tempLayer.addLayer(L.marker([vido, kinhdo]));
                    }
                    @if($trangthai===1)
                        @foreach($SVNgoaiTru as $item)
                            @if($item->kinhdo && $item->vido)
                                onLoadMap({{$item->kinhdo}}, {{$item->vido}});
                            @endif
                        @endforeach
                    @endif

                    var popup = L.popup();
                        function onMapClick(e)
                        {
                            var checkBox = document.getElementById("dangonharieng");
                            if (checkBox.checked == true)
                            {
                                tempLayer.clearLayers();
                                document.getElementById("vido").value = e.latlng.lat;
                                document.getElementById("kinhdo").value = e.latlng.lng;
                                tempLayer.addLayer(L.marker([e.latlng.lat, e.latlng.lng]));
                            }
                        }
                    map.on('click',onMapClick);

                    function setVitri()
                    {
                        tempLayer.clearLayers();
                        tempLayer.addLayer(L.marker([document.getElementById("vido").value, document.getElementById("kinhdo").value]));
                    }

                    function checkStatus()
                    {
                        tempLayer.clearLayers();
                        var checkBox = document.getElementById("dangonharieng");
                        if (checkBox.checked == true)
                        {
                            document.getElementById("ttchutro").value = "0";
                            document.getElementById("loaicutru").value = "0";
                            document.getElementById("tenchungoaitru").value = "";
                            document.getElementById("dienthoaichungoaitru").value = "";
                            document.getElementById("vido").value = "";
                            document.getElementById("kinhdo").value = "";
                            document.getElementById("diachi").value = "";
                            $("#ttchutro").attr('disabled', true);
                            $("#btngetLocation").removeAttr('disabled');
                            $("#loaicutru").removeAttr('disabled');
                            $("#tenchungoaitru").removeAttr('readonly');
                            $("#dienthoaichungoaitru").removeAttr('readonly');
                            $("#ngaydangky").removeAttr('readonly');
                            $("#vido").removeAttr('readonly');
                            $("#kinhdo").removeAttr('readonly');
                            $("#diachi").removeAttr('readonly');
                        }
                        else
                        {
                            document.getElementById("loaicutru").value = "1";
                            $("#ttchutro").removeAttr('disabled');
                            $("#loaicutru").attr('disabled', true);
                            $("#btngetLocation").attr('disabled', true);
                            $("#tenchungoaitru").attr('readonly', true);
                            $("#dienthoaichungoaitru").attr('readonly', true);
                            $("#ngaydangky").attr('readonly', true);
                            $("#vido").attr('readonly', true);
                            $("#kinhdo").attr('readonly', true);
                            $("#diachi").attr('readonly', true);
                        }
                    }

                    function checkStatus2()
                    {
                        tempLayer.clearLayers();
                        var checkBox = document.getElementById("dangonharieng");
                        if (checkBox.checked == true)
                        {
                            document.getElementById("ttchutro").value = "0";
                            $("#ttchutro").attr('disabled', true);
                            $("#btngetLocation").removeAttr('disabled');
                            $("#loaicutru").removeAttr('disabled');
                            $("#tenchungoaitru").removeAttr('readonly');
                            $("#dienthoaichungoaitru").removeAttr('readonly');
                            $("#ngaydangky").removeAttr('readonly');
                            $("#vido").removeAttr('readonly');
                            $("#kinhdo").removeAttr('readonly');
                            $("#diachi").removeAttr('readonly');
                        }
                        else
                        {
                            $("#ttchutro").removeAttr('disabled');
                            $("#loaicutru").attr('disabled', true);
                            $("#btngetLocation").attr('disabled', true);
                            $("#tenchungoaitru").attr('readonly', true);
                            $("#dienthoaichungoaitru").attr('readonly', true);
                            $("#ngaydangky").attr('readonly', true);
                            $("#vido").attr('readonly', true);
                            $("#kinhdo").attr('readonly', true);
                            $("#diachi").attr('readonly', true);
                        }
                    }

                    function setLuachonnhatro(){
                        var makhutro = document.getElementById("ttchutro").value;
                        $.ajax({
                            url: "./lay-tt-khu-tro",
                            cache: false,
                            type: "GET",
                            data: {"makhutro": makhutro, "_token": "{{ csrf_token() }}"},
                            success: function(response) {
                                document.getElementById("loaicutru").value="1";
                                document.getElementById("tenchungoaitru").value = response.ttNhatro[0].tenchutro;
                                document.getElementById("dienthoaichungoaitru").value= response.ttNhatro[0].sodienthoai;
                                document.getElementById("vido").value= response.ttNhatro[0].y;
                                document.getElementById("kinhdo").value= response.ttNhatro[0].x;
                                document.getElementById("diachi").value= response.ttNhatro[0].diachi;
                                tempLayer.clearLayers();
                                tempLayer.addLayer(L.marker([response.ttNhatro[0].y,response.ttNhatro[0].x]));
                            },
                            error: function(request, status, error) {
                                console.log("An error occurred write log: " + error);
                            }
                        });
                    }

                    $(function () {
                        $("#ttchutro").select2();
                    });
            </script>
@endsection