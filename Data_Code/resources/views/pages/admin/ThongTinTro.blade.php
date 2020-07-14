@extends('layouts.master-admin')
@section('master-admin')

<!-- Noi dung -->

<div class="row mb-3"></div>
<div class="card">
    <div class="card-header">
        <div class="row float-left" style="font-size: 20px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-primary" href="./danhsachSV">Danh sách sinh viên</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$student->ho}} {{$student->ten}} - Quá trình trọ</li>
                </ol>
            </nav>
        </div>



        <!-- End search bar -->

    </div>
    <!-- <div class="table table-reponsive"> -->
    <div class="card-body">
        <div class="row table-responsive mx-auto" style="font-size: 16px">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tên khu trọ</th>
                        <th scope="col">Ngày đến</th>
                        <th scope="col">Ngày đi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1 ?>

                    @foreach ($dsOTro as $item)

                    <tr>
                        <th scope="row">{{$i++ + ($dsOTro->currentPage() -1)* $pageSize }}</th>
                        <td>{{$item->tennhatro}}</td>
                        <td>{{$item->ngayden}}</td>
                        <td>{{$item->ngaydi}}</td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-4">
            {{ $dsOTro->links() }}

        </div>
    </div>
</div>
@endsection