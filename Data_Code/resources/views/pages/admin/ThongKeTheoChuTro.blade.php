@extends('layouts.master-admin')
@section('title','Thống kê theo chủ trọ')
@section('master-admin')
<!-- Noi dung -->

<div class="card">
    <div class="card-header card-header-primary">
        <h5 style="color: #999999">SƠ ĐỒ THỐNG KÊ SỐ LƯỢNG SINH VIÊN THEO KHU TRỌ</h5>
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
                        name: 'Số lượng sinh viên trọ',
                        type: 'pie',
                        allowPointSelect: true,
                        keys: ['name', 'y', 'selected', 'sliced'],
                        data: [
                            @foreach ($ds2 as $item )
                                [
                                    "\ {{$item->tennhatro}}\ ", 
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
    <h4 class="ml-5">BẢNG THỐNG KÊ SỐ LƯỢNG SINH VIÊN THEO KHU TRỌ</h4>
    <div class="clearfix">
        <div class="row ml-5">
            <h5><a href="{{ route('xuat-tk-theo-khu-tro') }}"><i class="fas fa-circle"></i> In báo cáo thống kê</a></h5>
        </div>
    </div>
    <div class="pr-5 pl-5 pb-5 row table-responsive mx-auto" style="font-size: 16px">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                    <input type="hidden"  name="cotsxnt" id="cotsxnt" value="">
                        <th scope="col">#</th>
                        <th scope="col">Tên nhà trọ</th>
                        <th scope="col">Số lượng sinh viên</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1; ?>
                @foreach ($ds2 as $item)
                <tr>
                        <th scope="row">{{$i++}}</th>
                        <td><b style="color: #007bff">{{$item->tennhatro}}</b></td>
                        <td><b style="color: #007bff">{{$item->sl}}</b></td>
                </tr>
                @endforeach
                </tbody>  
            </table>
    </div>
</div>
@endsection