@if (!session()->has('tendn'))
    echo "<script>window.location='login'</script>";
@endif
@extends('layouts.master')
@section('master')
<div class="container mt-4 mb-4" style="color: #000000;">
    <div class="dashboard-wrapper">
        <div class="dashboard-ecommerce">
            <div class="container-fluid dashboard-content ">
                <div class="card" style="display: block !important;">
                    <div class="card-header text-left">
                        <h2 style="color: #007bff">{{ $DSThongBao[0]->tieude }}</h2>
                    </div>
                    <div class="card-body mx-auto">
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

                        @foreach($DSThongBao as $item)
                        <div>
                            {!! $item->noidung !!}
                            <small>ĐĂNG VÀO: {{date('d/m/Y', strtotime($item->ngaydang))}}</small>
                        </div>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection