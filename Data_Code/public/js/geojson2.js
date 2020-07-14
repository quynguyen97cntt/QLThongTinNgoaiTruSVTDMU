var geojsonSchool = {
    type: "FeatureCollection",
    features: [
        {
            type: "Feature",
            properties: {
                "marker-color": "#ff0000",
                "marker-size": "medium",
                "marker-symbol": "school",
                tentruong: "Đại học Thủ Dầu Một",
                dienthoai: "(0274) 382 2518 | (0274) 383 7150",
                diachi: "Số 06, Trần Văn Ơn, Phú Hòa, Thủ Dầu Một, Bình Dương"
            },
            geometry: {
                type: "Point",
                coordinates: [106.6744565963745, 10.980469775348254]
            }
        }
    ]
};

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
                if (tempLayer2.getLayers().length > 0) {
                    tempLayer2.eachLayer(function (layer2) {
                        layer2.setIcon(IconStyleDefault);
                    });
                }
                tempLayer2.addLayer(layer.setIcon(IconStyleTwo));
                $("#loading").hide();
                tempLayer.clearLayers();
                $("#frmKhuTroBanDo").show();
                $("#frmThemKhuTroBanDo").hide();
                $("#frmKhuTroBanDo").html('<div style="font-weight: bold; font-size: 14px;"><i class="fas fa-chevron-circle-right"></i> ID: <span style="color: green;">' + feature.properties.id.replace(/\"/g, "") + '</span> <br /><i class="fas fa-chevron-circle-right"></i> Tên nhà trọ: <span style="color: green;">' + feature.properties.tennhatro.replace(/\"/g, "") + '</span> <br /> <i class="fas fa-chevron-circle-right"></i> Tên chủ trọ: <span style="color: green;">' + feature.properties.ten.replace(/\"/g, "") + '</span> <br /> <i class="fas fa-chevron-circle-right"></i> Điện thoại: <span style="color: green;">' + feature.properties.dienthoai.replace(/\"/g, "") + '</span> <br />  <i class="fas fa-chevron-circle-right"></i> Cách trường TDMU: <span style="color: green;">' + feature.properties.khoangcach + ' km </span> ' + '</span> <br />  <i class="fas fa-chevron-circle-right"></i> Địa chỉ: <span style="color: green;">' + feature.properties.diachi.replace(/\"/g, "") + '</span> <br /> <i class="fas fa-chevron-circle-right"></i> Sinh viên đang trọ: <span style="color: green;"><b id="cbSoluongSV"></b> <b> sinh viên</b></span> <br /> <i class="fas fa-chevron-circle-right"></i> Mã số thuế: <span style="color: green;">' + feature.properties.masothue.replace(/\"/g, "") + '</span> <br /> <a class="btn btn-outline-default" target="_blank" href="./images/gpkd/' + feature.properties.hinhanhgpkd.replace(/\"/g, "") + '">Xem giấy phép kinh doanh</a> <br /> <a class="btn btn-outline-primary" id="clickDSSV" onClick="xemDSSV()" href="#">DS sinh viên</a> <a class="btn btn-outline-primary" data-placement="right" data-toggle="modal" data-target="#xoakhutro" data-html="true" id="clickXoaKhuTro" href="' + feature.properties.id.replace(/\"/g, "") + '">Xoá</a> <a class="btn btn-outline-primary" target="_blank" href="https://www.google.com/maps/place/' + feature.properties.y.replace(/\"/g, "") + ', ' + feature.properties.x.replace(/\"/g, "") + '?hl=vi-VN">Chỉ đường</a>' + '</div>');
                var href = feature.properties.id.replace(/\"/g, "");

                var tennhatro = feature.properties.tennhatro.replace(/\"/g, "");
                var ten = feature.properties.ten.replace(/\"/g, "");
                var diachi = feature.properties.diachi.replace(/\"/g, "");
                var dienthoai = feature.properties.dienthoai.replace(/\"/g, "");
                var hinhanhgpkd = feature.properties.hinhanhgpkd.replace(/\"/g, "");

                document.getElementById("idChuTro").setAttribute("value", href);

                document.getElementById("idKhutro").setAttribute("value", href);
                document.getElementById("hinhanhGpkd").setAttribute("value", hinhanhgpkd);
                document.getElementById("frmXoaKhuTro").setAttribute("action", "./XoaKhuTroBD");

                document.getElementById("makhutro").setAttribute("value", href);
                document.getElementById("tennhatro").setAttribute("value", tennhatro);
                document.getElementById("ten").setAttribute("value", ten);
                $("#diachi").html(diachi);
                document.getElementById("sodienthoai").setAttribute("value", dienthoai);

                document.getElementById("idKhutroSua").setAttribute("value", href);
                document.getElementById("frmSuaKhuTro").setAttribute("action", "./suaNhatro");

                $.ajax({
                    type: "POST",
                    url: "/sinhvienngoaitru/slsinhvien",
                    data: { id: href },
                    dataType: 'json',
                    success: function (data) {
                        $("#cbSoluongSV").html(data.idNhan);
                    },
                    error: function (xhr, status, error) {
                        alert("Thất bại!");
                    }
                });

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

var truonghoc = L.geoJson(geojsonSchool, {
    pointToLayer: createCustomIcon,
    onEachFeature: function (feature, layer) {
        $("#frmThemKhuTroBanDo").hide();
        layer.bindPopup('<div style="width: 360px; font-weight: bold; font-size: 14px;">Tên trường: ' + feature.properties.tentruong + '<br /> Điện thoại: ' + feature.properties.dienthoai + '<br /> Địa chỉ: ' + feature.properties.diachi + "</div>");
    }
}).addTo(map);

function highlight(layer) {
    layer.setStyle({
        fillOpacity: 0.01,
    });
    if (!L.Browser.ie && !L.Browser.opera) {
        layer.bringToFront();
    }
}

function dehighlight(layer) {
    if (selected === null || selected._leaflet_id !== layer._leaflet_id) {
        layer.setStyle({
            fillOpacity: 0.2,
        });
    }
}

function select(layer) {
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




map.addLayer(tempLayer);

var popup = L.popup();
function onMapClick(e) {
    $("#loading").hide();
    $("#frmKhuTroBanDo").hide();
    $("#frmThemKhuTroBanDo").show();
    if (tempLayer2.getLayers().length > 0) {
        tempLayer2.eachLayer(function (layer2) {
            layer2.setIcon(IconStyleDefault);
        });
    }

    tempLayer.clearLayers();
    document.getElementById("vido").value = e.latlng.lat;
    document.getElementById("kinhdo").value = e.latlng.lng;
    tempLayer.addLayer(L.marker([e.latlng.lat, e.latlng.lng]));

    if (tempLayer.getLayers().length > 0) {
        tempLayer.eachLayer(function (layer) {
            layer.setIcon(IconStyleTwo);
        });
    }
}
map.on('click', onMapClick);

$(document).ready(function () {
    $("#phuongxa").change(function () {
        var selectedCountry = $(this).children("option:selected").val();
        var arr = selectedCountry.split(",");
        map.flyTo([arr[0], arr[1]], 15);
    });
});

function xemDSSV() {
    document.getElementById("frmXemDSSV").setAttribute("action", "./DSSVOTroBanDo");
    document.getElementById("xemDSSV").setAttribute("type", "submit");
    document.getElementById('xemDSSV').dispatchEvent(new MouseEvent("click"));
    document.getElementById("xemDSSV").setAttribute("type", "hidden");
}
function Students() {
    var checkBox = document.getElementById("statusStudents");
    if (checkBox.checked == true) {
        window.location = 'QLDSKhuNhaTro';
    } else {
        document.forms['frmStatusSD'].submit();
    }
}
function validateFileType() {
    var fileName = document.getElementById("gpkd").value;
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile == "jpg" || extFile == "jpeg" || extFile == "png") { }
    else {
        document.getElementById("gpkd").value = "";
        alert("Only jpg/jpeg and png files are allowed!");
    }
}

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);