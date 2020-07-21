@extends('layouts.master-admin')
@section('title','Thống kê sinh viên theo phường')
@section('master-admin')
<!-- Noi dung -->

<div class="card">
    <div class="card-header card-header-primary">
        <h5 style="color: #999999">SƠ ĐỒ THỐNG KÊ SỐ LƯỢNG SINH VIÊN THEO PHƯỜNG</h5>
    </div>
    
    <div class="mt-3">
        <div id="container"></div>


		<script type="text/javascript">
                Highcharts.chart('container', {

                    chart: {
                        styledMode: true
                    },

                    title: {
                        text: ''
                    },

                    xAxis: {
                        categories: []
                    },

                    series: [{
                        name: 'Số lượng sinh viên',
                        type: 'pie',
                        allowPointSelect: true,
                        keys: ['name', 'y', 'selected', 'sliced'],
                        data: [
                            @foreach ($ds as $item )
                                [
                                    "\ {{$item->tenphuong}}\ ", 
                                    {{$item->sl}}
                                ],
                            @endforeach
                        ],
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y:.0f}'
                        },
                        showInLegend: true
                    }]
                });
		</script>
    </div>
    <h4 class="ml-5">BẢNG THỐNG KÊ SỐ LƯỢNG SINH VIÊN THEO PHƯỜNG</h4>
    <div class="clearfix">
        <div class="row ml-5">
            <h5><a href="{{ route('xuat-tk-sv-phuong') }}"><i class="fas fa-circle"></i> In báo cáo thống kê</a></h5>
        </div>
    </div>
    <div class="pr-5 pl-5 pb-5 row table-responsive mx-auto" style="font-size: 16px">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                    <input type="hidden"  name="cotsxnt" id="cotsxnt" value="">
                        <th scope="col">#</th>
                        <th scope="col">Tên phường</th>
                        <th scope="col">Số lượng sinh viên</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1; ?>
                @foreach ($ds as $item)
                <tr>
                        <th scope="row">{{$i++}}</th>
                        <td><b style="color: #007bff">{{$item->tenphuong}}</b></td>
                        <td><b style="color: #007bff">{{$item->sl}}</b></td>
                </tr>
                @endforeach
                </tbody>  
            </table>
            <div><h6>Ngày thống kê: <?php date_default_timezone_set('Asia/Ho_Chi_Minh'); echo date("d-m-Y"); ?></h6></div>
    </div>
</div>
@endsection