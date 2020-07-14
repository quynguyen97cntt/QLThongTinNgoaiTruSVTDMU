
var feature_group = new L.featureGroup([]);

var khutro = L.geoJson(geojsonFeature, {
    onEachFeature: function (feature, layer) {
        layer.bindPopup('<div style="width: 400px; font-weight: bold; font-size: 14px;"><i class="fas fa-chevron-circle-right"></i> Tên nhà trọ: ' + feature.properties.tennhatro.replace(/\"/g, "") + '<br /> <i class="fas fa-chevron-circle-right"></i> Tên chủ trọ: ' + feature.properties.ten.replace(/\"/g, "")+ '<br /> <i class="fas fa-chevron-circle-right"></i> Điện thoại: ' + feature.properties.dienthoai.replace(/\"/g, "") + '<br /> <i class="fas fa-chevron-circle-right"></i> Giá phòng: <span style="color: red;">' + ((feature.properties.giaphong.replace(/\"/g, "")==0)?'Thoả thuận':feature.properties.giaphong.replace(/\"/g, "")+ ' vnđ/tháng ')  + ' </span> <br /> <i class="fas fa-chevron-circle-right"></i> Điện: <span style="color: red;">' + (feature.properties.dien.replace(/\"/g, "")==0?'Thoả thuận':feature.properties.dien.replace(/\"/g, "")+ ' vnđ/kWh ')  + ' </span> <br /> <i class="fas fa-chevron-circle-right"></i> Nước: <span style="color: red;">' + (feature.properties.nuoc.replace(/\"/g, "")==0?'Thoả thuận':feature.properties.nuoc.replace(/\"/g, "") + ' vnđ/m3 ') + ' </span> <br /> <i class="fas fa-chevron-circle-right"></i> Số người trong một phòng: ' + (feature.properties.soluong.replace(/\"/g, "")==0?'Thoả thuận':feature.properties.soluong.replace(/\"/g, "") + ' người ' ) + ' <br /> <i class="fas fa-chevron-circle-right"></i> Trạng thái: <span style="color: red;">' + (feature.properties.trangthai.replace(/\"/g, "")==0?'Chưa cập nhật':feature.properties.trangthai.replace(/\"/g, "")) + '</span> <br /> <i class="fas fa-chevron-circle-right"></i> Cách trường TDMU: <span style="color: red;">' + feature.properties.khoangcach+ ' km </span> '+ '</span> <br /> <i class="fas fa-chevron-circle-right"></i> Tiện ích: <span style="color: red;">' + feature.properties.tienich.replace(/\"/g, "") + '</span> ' + '<br /> <i class="fas fa-chevron-circle-right"></i> Ngày cập nhật: ' + feature.properties.ngaycapnhat.replace(/\"/g, "") + ' <br /> <i class="fas fa-chevron-circle-right"></i> Địa chỉ: ' + feature.properties.diachi.replace(/\"/g, "") + '<br /> <a class="btn btn-outline-primary mt-2" style="margin-left: 40%" href="tel:' + feature.properties.dienthoai.replace(/\"/g, "") + '"><i class="fas fa-phone-volume"></i> Liên hệ</a> <a class="btn btn-outline-primary ml-2 mt-2" target="_blank" href="https://www.google.com/maps/place/'+ feature.properties.y.replace(/\"/g, "") + ', '+ feature.properties.x.replace(/\"/g, "") +'?hl=vi-VN"><i class="fas fa-location-arrow"></i> Chỉ đường</a>'  + "</div>");
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

var truonghoc =L.geoJson({
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
},{
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

L.control.locate().addTo(map);

$(document).ready(function(){
  $("#phuongxa").change(function(){

    var selectedCountry = $(this).children("option:selected").val();
    var arr = selectedCountry.split(",");
    map.flyTo([arr[0], arr[1]], 15);
    
  });

  $("#giaphong").change(function(){
    document.getElementById("statusStudentsTC").checked = false;
    document.getElementById("xemtheolop").value = "all";
    var giaphong = document.getElementById("giaphong").value;
    $.ajax({
      url: "./",
      cache: false,
      type: "GET",
      data: {"giaphong": giaphong, "_token": "{{ csrf_token() }}"},
      success: function(response) {
          var s ='';
          s += '<div class="row justify-content-center ">';
          s += '<div id="mapid" style="height: 530px;"></div>';
          s += '</div>';
          s += '<script>';
          s += 'var map = L.map("mapid").setView([10.9805, 106.6745], 13);';
          s += '</script>';
          s += '<script>';
          s += 'var geojsonFeature = {';
          s += '"type": "FeatureCollection",';
          s += '"features": [';
          s += response.geojson;
          s += ']';
          s += '};';
          s += '</script>';
          s += '<script src="./js/geojsondata.js"></script>';
          s +='<script src="./js/geojson.js"></script>';

          s +='<script>';
          s +='L.geoJson({';
          s +='"type": "FeatureCollection",';
          s +='"features": [';
          s += response.geojson2;
          s +=']';
          s +='}, {';
          s +='style: function (feature) {';
          s +='return {';
          s +='weight: 2,';
          s +='color: feature.properties.color,';
          s +='fillColor: feature.properties.fillColor,';
          s +='fillOpacity: 0.2,';
          s +='radius: 500,';
          s +='};';
          s +='},';
          s +='onEachFeature: function (feature, layer) {';
          s +='layer.on({';
          s +='\'mouseover\': function (e) {';
          s +='highlight(e.target);';
          s +='},';
          s +='\'mouseout\': function (e) {';
          s +='dehighlight(e.target);';
          s +='},';
          s +='\'click\': function (e) {';
          s +='select(e.target);';
          s +='}';
          s +='});';
          s +='}';
          s +='}).addTo(map);';
          s +='</script>';
          $('#contentchange').html(s);
      },
      error: function(request, status, error) {
          console.log("An error occurred write log: " + error);
      }
    });

  });

  $("#xemtheolop").change(function(){
    document.getElementById("statusStudentsTC").checked = true;
    document.getElementById("giaphong").value = "all";
    document.getElementById("phuongxa").value = "";
    var lop = document.getElementById("xemtheolop").value;
    $.ajax({
      url: "./xemtheolop",
      cache: false,
      type: "GET",
      data: {"lop": lop, "_token": "{{ csrf_token() }}"},
      success: function(response) {
        var s ='';
        s += '<div class="row justify-content-center ">';
        s += '<div id="mapid" style="height: 530px;"></div>';
        s += '</div>';
        s += '<script>';
        s += 'var map = L.map("mapid").setView([10.9805, 106.6745], 13);';
        s += '</script>';
        s += '<script>';
        s += 'var geojsonFeature = {';
        s += '"type": "FeatureCollection",';
        s += '"features": [';
        s += response.geojson;
        s += ']';
        s += '};';
        s += '</script>';
        s += '<script src="./js/geojsondata.js"></script>';
        s +='<script src="./js/geojson.js"></script>';

        s +='<script>';
        s +='L.geoJson({';
        s +='"type": "FeatureCollection",';
        s +='"features": [';
        s += response.geojson2;
        s +=']';
        s +='}, {';
        s +='style: function (feature) {';
        s +='return {';
        s +='weight: 2,';
        s +='color: feature.properties.color,';
        s +='fillColor: feature.properties.fillColor,';
        s +='fillOpacity: 0.2,';
        s +='radius: 500,';
        s +='};';
        s +='},';
        s +='onEachFeature: function (feature, layer) {';
        s +='layer.on({';
        s +='\'mouseover\': function (e) {';
        s +='highlight(e.target);';
        s +='},';
        s +='\'mouseout\': function (e) {';
        s +='dehighlight(e.target);';
        s +='},';
        s +='\'click\': function (e) {';
        s +='select(e.target);';
        s +='}';
        s +='});';
        s +='}';
        s +='}).addTo(map);';
        s +='</script>';
        $('#contentchange').html(s);
      },
      error: function(request, status, error) {
          console.log("An error occurred write log: " + error);
      }
    });
  });

  $("#statusStudentsTC").change(function(){
    document.getElementById("xemtheolop").value = "all";
    document.getElementById("giaphong").value = "all";
    document.getElementById("phuongxa").value = "";
    var checkBox = document.getElementById("statusStudentsTC");
    if (checkBox.checked == true){
      $.ajax({
        url: "./nhatrocosvtc",
        cache: false,
        type: "GET",
        data: {"_token": "{{ csrf_token() }}"},
        success: function(response) {
          var s ='';
          s += '<div class="row justify-content-center ">';
          s += '<div id="mapid" style="height: 530px;"></div>';
          s += '</div>';
          s += '<script>';
          s += 'var map = L.map("mapid").setView([10.9805, 106.6745], 13);';
          s += '</script>';
          s += '<script>';
          s += 'var geojsonFeature = {';
          s += '"type": "FeatureCollection",';
          s += '"features": [';
          s += response.geojson;
          s += ']';
          s += '};';
          s += '</script>';
          s += '<script src="./js/geojsondata.js"></script>';
          s +='<script src="./js/geojson.js"></script>';
  
          s +='<script>';
          s +='L.geoJson({';
          s +='"type": "FeatureCollection",';
          s +='"features": [';
          s += response.geojson2;
          s +=']';
          s +='}, {';
          s +='style: function (feature) {';
          s +='return {';
          s +='weight: 2,';
          s +='color: feature.properties.color,';
          s +='fillColor: feature.properties.fillColor,';
          s +='fillOpacity: 0.2,';
          s +='radius: 500,';
          s +='};';
          s +='},';
          s +='onEachFeature: function (feature, layer) {';
          s +='layer.on({';
          s +='\'mouseover\': function (e) {';
          s +='highlight(e.target);';
          s +='},';
          s +='\'mouseout\': function (e) {';
          s +='dehighlight(e.target);';
          s +='},';
          s +='\'click\': function (e) {';
          s +='select(e.target);';
          s +='}';
          s +='});';
          s +='}';
          s +='}).addTo(map);';
          s +='</script>';
          $('#contentchange').html(s);
        },
        error: function(request, status, error) {
            console.log("An error occurred write log: " + error);
        }
      });
    } 
    else {
      $.ajax({
        url: "./",
        cache: false,
        type: "GET",
        data: {"giaphong": "all","_token": "{{ csrf_token() }}"},
        success: function(response) {
          var s ='';
          s += '<div class="row justify-content-center ">';
          s += '<div id="mapid" style="height: 530px;"></div>';
          s += '</div>';
          s += '<script>';
          s += 'var map = L.map("mapid").setView([10.9805, 106.6745], 13);';
          s += '</script>';
          s += '<script>';
          s += 'var geojsonFeature = {';
          s += '"type": "FeatureCollection",';
          s += '"features": [';
          s += response.geojson;
          s += ']';
          s += '};';
          s += '</script>';
          s += '<script src="./js/geojsondata.js"></script>';
          s +='<script src="./js/geojson.js"></script>';
  
          s +='<script>';
          s +='L.geoJson({';
          s +='"type": "FeatureCollection",';
          s +='"features": [';
          s += response.geojson2;
          s +=']';
          s +='}, {';
          s +='style: function (feature) {';
          s +='return {';
          s +='weight: 2,';
          s +='color: feature.properties.color,';
          s +='fillColor: feature.properties.fillColor,';
          s +='fillOpacity: 0.2,';
          s +='radius: 500,';
          s +='};';
          s +='},';
          s +='onEachFeature: function (feature, layer) {';
          s +='layer.on({';
          s +='\'mouseover\': function (e) {';
          s +='highlight(e.target);';
          s +='},';
          s +='\'mouseout\': function (e) {';
          s +='dehighlight(e.target);';
          s +='},';
          s +='\'click\': function (e) {';
          s +='select(e.target);';
          s +='}';
          s +='});';
          s +='}';
          s +='}).addTo(map);';
          s +='</script>';
          $('#contentchange').html(s);
        },
        error: function(request, status, error) {
            console.log("An error occurred write log: " + error);
        }
      });
    }
  });
});

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);