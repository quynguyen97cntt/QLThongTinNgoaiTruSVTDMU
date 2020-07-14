@extends('layouts.master-admin')
@section('title','Quản lý khu trọ')
@section('master-admin')

<!-- Nội dung -->
<div class="form-group row" style="padding: 0 !important">
    <form class="form-group col-sm-12 col-md-3">
        <select name="phuongxa" id="phuongxa" class="form-control">
            <option value="">---Chọn khu vực---</option>
            @foreach($chonphuongxa as $px)
            <option value="{{$px->toadodiem}}">{{$px->tenpx}}</option>
            @endforeach
        </select>
    </form>
    <form action="{{route('timkiembando')}}" method="GET" class="form-group col-sm-12 col-md-4">
        <input class="form-control" name="timkhutro" type="text" placeholder="Nhập tên chủ trọ, tên nhà trọ...">
    </form>
    <form action="{{route('trangthaiSV')}}" method="POST" id="frmStatusSD" class="form-group col-sm-12 col-md-4 mt-4">
        @csrf
        <div class="form-check">
            @if(session()->has('trangthaisv'))
            <input type="checkbox" class="form-check-input" id="statusStudents" onclick="Students()">
            @else
            <input type="checkbox" checked class="form-check-input" id="statusStudents" onclick="Students()">
            @endif
            <label class="form-check-label" for="statusStudents">Có sinh viên</label>
        </div>
    </form>
</div>
<div class="row justify-content-center form-group col-md-12" style="padding: 0 !important">
    <div id="mapid" class="col-md-9" style="height: 530px;"></div>

    <div class="col-md-3" style="border: 2px solid #DCD9BA !important; border-radius: 5px">
        <div id="loading" style="margin: 10px">Loading...</div>
        <div id="frmKhuTroBanDo"></div>
        <form class="form-group" action="themNhakhutro" id="frmThemKhuTroBanDo" method="POST"
            enctype="multipart/form-data">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <label for="txtTennhatro" class="font-weight-bold">Tên nhà trọ <i class="text-danger">(*)</i></label>
            <input type="text" class="form-control" id="txtTennhatro" required name="txtTennhatro">

            <label for="txtHotenlot" class="font-weight-bold">Họ và tên lót <i class="text-danger">(*)</i></label>
            <input type="text" class="form-control" id="txtHotenlot" required name="txtHotenlot">

            <label for="txtTen" class="font-weight-bold">Tên <i class="text-danger">(*)</i></label>
            <input type="text" class="form-control" id="txtTen" required name="txtTen">

            <label for="txtCmnd" class="font-weight-bold">CMND/Thẻ căn cước <i class="text-danger">(*)</i></label>
            <input type="number" class="form-control" id="txtCmnd" required name="txtCmnd">

            <label for="txtSodienthoai" class="font-weight-bold">Điện thoại <i class="text-danger">(*)</i></label>
            <input type="number" class="form-control" id="txtSodienthoai" required name="txtSodienthoai">
            
            <label for="txtEmail" class="font-weight-bold">Email </label>
            <input type="email" class="form-control" id="txtEmail" name="txtEmail">

            <label for="txtDiachi" class="font-weight-bold">Địa chỉ <i class="text-danger">(*)</i></label>
            <input type="text" class="form-control" id="txtDiachi" required name="txtDiachi">

            <label for="mathue" class="font-weight-bold">Mã số thuế: <i class="text-danger">(*)</i></label>
            <input type="text" required class="form-control" name="mathue" id="mathue" placeholder="Mã số thuế...">

            <label for="gpkd" class="font-weight-bold">Nhấn vào đây để upload GPKD<i class="text-danger">(*)</i></label>
            <input type="file" required class="form-control" name="gpkd" accept="image/*" required="true"
                onchange="validateFileType()" id="gpkd">

            <input type="hidden" id="kinhdo" name="x" value="">
            <input type="hidden" id="vido" name="y" value=""><br>
            <input type="submit" class="btn btn-success btn-xs form-control" name="txtThem" value="Thêm Khu Trọ">
        </form>
    </div>
</div>

<form action="{{ route('nhapnhatro') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" class="btn mb-2">
    <button class="btn btn-success ml-2 mr-2">Nhập dữ liệu</button>
    <a class="btn btn-primary mr-2" href="{{ route('xuatnhatro') }}">Xuất dữ liệu</a>
</form>

<h4 class="ml-5">DANH SÁCH NHÀ TRỌ ĐĂNG KÝ MỚI CHỜ XÉT DUYỆT</h4>
    <div class="pr-5 pl-5 pb-5 row table-responsive mx-auto" style="font-size: 16px">
            <table class="table table-striped">
                <thead class="thead">
                    <tr>
                    <input type="hidden"  name="cotsxnt" id="cotsxnt" value="">
                        <th scope="col">#</th>
                        <th scope="col">Tên nhà trọ</th>
                        <th scope="col">Tên chủ trọ</th>
                        <th scope="col">Điện thoại</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php $j=1; ?>
                @foreach ($DSDuyet as $duyet)
                <?php
                    $idduyet = $duyet->gid."duyetkhutro"; 
                    $idtuchoi = $duyet->gid."tuchoiduyet";
                ?>
                <tr>
                        <th scope="row">{{$j++}}</th>
                        <td><b style="color: #007bff">{{$duyet->tennhatro}}</b></td>
                        <td><b style="color: #007bff">{{$duyet->ho}} {{$duyet->ten}}</b></td>
                        <td><b style="color: #007bff">{{$duyet->sodienthoai}}</b></td>
                        <td><a href="" data-placement="right" data-toggle="modal" data-target="#{{$idduyet}}" data-html="true">Xem và duyệt</a></td>
                </tr>

                <!-- Modal duyệt -->
                <div class="modal fade" id="{{$idduyet}}" tabindex="-1" role="dialog" aria-labelledby="duyetModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <form action="{{route('duyet-khu-tro')}}" method="post" id="frmDuyetKhuTro">
                                @csrf
                                <div class="modal-header">
                                    <h2 class="modal-title" id="deleteModalLabel">Xét Duyệt Khu Trọ</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" readonly value="{{$duyet->gid}}" name="gid" class="form-control">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="col-form-label font-weight-bold">Tên nhà trọ: </label>
                                            <input type="text" readonly value="{{$duyet->tennhatro}}" name="tennhatro" class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="col-form-label font-weight-bold">Tên chủ trọ: </label>
                                            <input type="text" readonly value="{{$duyet->ho}} {{$duyet->ten}}" name="tenchutro" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="col-form-label font-weight-bold">Chứng minh thư: </label>
                                            <input type="text" readonly value="{{$duyet->cmnd}}" name="cmnd" class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="col-form-label font-weight-bold">Điện thoại: </label>
                                            <input type="text" readonly value="{{$duyet->sodienthoai}}" name="sodienthoai" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="col-form-label font-weight-bold">Email: </label>
                                            <input type="text" readonly value="{{$duyet->email}}" name="email" class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="col-form-label font-weight-bold">Mã số thuế: </label>
                                            <input type="text" readonly value="{{$duyet->masothue}}" name="masothue" class="form-control">
                                        </div>
                                    </div>
                                    <label class="col-form-label font-weight-bold">Hình ảnh giấy phép kinh doanh: </label>
                                    <div class="form-group">
                                        <center><img src="./images/gpkd/{{$duyet->hinhanhgpkd}}" width="500" height="600"></center>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="col-form-label font-weight-bold">Kinh độ: </label>
                                            <input type="text" readonly value="{{$duyet->x}}" name="kinhdo" class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="col-form-label font-weight-bold">Vĩ độ: </label>
                                            <input type="text" readonly value="{{$duyet->y}}" name="vido" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label font-weight-bold">Địa chỉ: </label>
                                        <input type="text" readonly value="{{$duyet->diachi}}" name="diachi" class="form-control">
                                    </div>
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
                <div class="modal fade" id="{{$idtuchoi}}" tabindex="-1" role="dialog" aria-labelledby="tuchoiModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="{{route('tu-choi-duyet')}}" method="post" id="frmTuChoiDuyet">
                                @csrf
                                <input type="hidden" readonly value="{{$duyet->gid}}" name="gid" class="form-control">
                                <input type="hidden" readonly value="{{$duyet->email}}" name="email" class="form-control">
                                <input type="hidden" readonly value="{{$duyet->hinhanhgpkd}}" name="hinhanhGpkd" class="form-control">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="deleteModalLabel">Từ Chối Duyệt Khu Trọ</h3>
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
                                    <input type="submit" class="btn btn-danger" value="Xóa yêu cầu và gửi phản hồi">
                                    <button type="button" class="btn btn-default float-left" data-dismiss="modal">Hủy</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End modal từ chối -->

                @endforeach
                </tbody>  
            </table>
    </div>
</div>

<!-- Modal xóa -->

<div class="modal fade" id="xoakhutro" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="frmXoaKhuTro">
                @csrf

                <input type="hidden" id="idKhutro" name="idKhutro" value="">
                <input type="hidden" id="hinhanhGpkd" name="hinhanhGpkd" value="">
                <div class="modal-header">
                    <h2 class="modal-title" id="deleteModalLabel">Xóa Thông
                        Tin Khu Trọ</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Lý do xoá: </label>
                        <input type="text" value="" name="lydoxoa" required class="form-control" id="lydoxoa">
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="submit" class="btn btn-danger" value="Xóa">
                    <button type="button" class="btn btn-default float-left" data-dismiss="modal">Hủy</button>

                </div>
            </form>
        </div>
    </div>
</div>
<!-- End modal xóa -->

<!-- Modal sửa -->
<div class="modal fade" id="suakhutro" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="editModalLabel">Sửa Thông
                    Tin Khu Trọ</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="frmSuaKhuTro">
                    @csrf
                    <input type="hidden" id="idKhutroSua" name="idKhutroSua" value="">
                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Mã khu
                            trọ:</label>
                        <input type="text" name="makhutro" value="" id="makhutro" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Tên khu
                            trọ:</label>
                        <input type="text" value="" name="tennhatro" class="form-control" id="tennhatro">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Họ và tên:</label>
                        <input type="text" value="" name="ten" id="ten" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Địa
                            chỉ:</label>
                        <textarea class="form-control" name="diachi" id="diachi"></textarea>

                    </div>
                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Số điện
                            thoại:</label>
                        <input type="text" value="" id="sodienthoai" name="sodienthoai" class="form-control">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Cập nhật</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>

            </div>
            </form>
        </div>
    </div>
</div>
<!-- End modal sửa -->

<!--Form DS Sinh Viên-->
<form class="form-control border-0" action="" method="POST" id="frmXemDSSV">
    @csrf
    <input type="hidden" name="idChuTro" id="idChuTro" value="">
    <input type="hidden" name="xemDSSV" id="xemDSSV" value="">
</form>
<!-- End Form DS Sinh Viên -->

<script>
    var x = document.getElementById("thongbao");

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        }
        else {
            x.innerHTML = "Geolocation không được hỗ trợ bởi trình duyệt này.";
        }
    }

    function showPosition(position) {
        document.getElementById("vido").value = position.coords.latitude;
        document.getElementById("kinhdo").value = position.coords.longitude;
    }

    function showError(error) {
        switch (error.code) {
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

<script>
    var geojsonFeature = {
        "type": "FeatureCollection",
        "features": [
            @foreach($dsNhatro as $nhatro)
            {
                "type": "Feature",
                "properties": {
                    "marker-color": "#ff0000",
                    "marker-size": "medium",
                    "marker-symbol": "",
                    "id": "\"{{$nhatro->gid}}\"",
                    "tennhatro": "\"{{$nhatro->tennhatro}}\"",
                    "ten": "\"{{$nhatro->tenchutro}}\"",
                    "tienich": "\"{{str_replace("\n","",$nhatro->tienich)}}\"",
                    "giaphong": "\"{{number_format($nhatro->giaphong)}}\"",
                    "dien": "\"{{number_format($nhatro->dien)}}\"",
                    "nuoc": "\"{{number_format($nhatro->nuoc)}}\"",
                    "soluong": "\"{{$nhatro->soluong}}\"",
                    "trangthai": "\"{{$nhatro->trangthai}}\"",
                    "x": "\"{{$nhatro->x}}\"",
                    "y": "\"{{$nhatro->y}}\"",
                    "dienthoai": "\"{{$nhatro->sodienthoai}}\"",
                    "diachi": "\"{{$nhatro->diachi}}\"",
                    "masothue": "\"{{$nhatro->masothue}}\"",
                    "hinhanhgpkd": "\"{{$nhatro->hinhanhgpkd}}\"",
                    "khoangcach": {{ round($nhatro -> distance, 1) }}
                },
                "geometry": {
                    "type": "Point",
                    "coordinates": [
                        {{ $nhatro-> x }},
                        {{ $nhatro -> y }}
                    ]
                }
            },
            @endforeach
        ]
    };
</script>
<script src="./js/geojson2.js"></script>
<script>
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
                        {{ $px['geom']}}
                    ]}
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
<!-- Kết thúc nội dung -->

@endsection