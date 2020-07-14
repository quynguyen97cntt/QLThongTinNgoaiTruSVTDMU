@extends('layouts.master-admin')
@section('title','Quản lý khu trọ')
@section('master-admin')

<!-- Noi dung -->

<div class="row mb-3"></div>
<div class="card">
    <div class="card-header">
        <div class="row float-left" style="font-size: 20px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-primary" href="{{ route('QLDSKhuNhaTro')}}"></a></li>
                    <li class="breadcrumb-item"><a class="text-primary" href="{{ route('QLDSKhuNhaTro')}}">Bản đồ quản lý khu trọ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Danh sách sinh viên tại nhà trọ
                        @foreach ($tenkhutro as $item)
                        {{$item}}
                        @endforeach
                    </li>
                </ol>
            </nav>
        </div>

    </div>

    <!-- <div class="table table-reponsive"> -->
    <div class="card-body">
        <div class="clearfix">
            <div class="row mx-auto mb-2 float-right">
                <a class="btn btn-primary" href="{{ route('xuatdssvtro') }}">Xuất dữ liệu</a>
            </div>
        </div>
        <div class="row table-responsive mx-auto" style="font-size: 16px">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="text-center">Mã sinh viên</th>
                        <th scope="col">Tên sinh viên</th>
                        <th scope="col">Giới tính</th>
                        <th scope="col">Ngày đến</th>
                        <th scope="col">Số phòng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                                    $i=1
                                ?>
                    @foreach ($dsSVOtro as $dssv )
                    <tr>
                        <td scope="row">{{$i++}}</td>
                        <td scope="row" class="text-center">{{$dssv->mssv}}</td>
                        <td scope="row">{{$dssv->ho}} {{$dssv->ten}}</td>
                        <td scope="row">{{$dssv->gioitinh}}</td>
                        <td scope="row">{{$dssv->ngayden}}</td>
                        <td scope="row">{{$dssv->sophong}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-4">
        {{ $dsSVOtro->links() }}

    </div>
    <!-- </div> -->
</div>

@endsection