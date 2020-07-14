@if (!session()->has('tendn'))
    echo "<script>window.location='login'</script>";
@endif
@extends('layouts.master')
@section('master')
<div class="container mt-4 mb-4" style="color: #000000;">
    <div class="dashboard-wrapper">
        <div class="dashboard-ecommerce">
            <div class="container-fluid dashboard-content ">
                <div class="card">
                    
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
                            <h4>
                                <a href="{{ route('chitietthongbao',['id' => $item->id])}}" style="text-decoration: none">{{$item->tieude}}</a>
                            </h4>
                            <small>ĐĂNG VÀO: {{date('d/m/Y', strtotime($item->ngaydang))}}</small>
                            <p>
                            <?php
                                $str = $item->noidung;
                                $str = strip_tags($str);
                                if(strlen($str)>245) 
                                {
                                    $strCut = substr($str, 0, 245);
                                    $str = substr($strCut, 0, strrpos($strCut, ' ')).'...';
                                    echo $str;
                                }
                                else 
                                {
                                    echo $str;
                                }
                            ?>
                            </p>
                        </div>
                        @endforeach
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            {{ $DSThongBao->links() }}

        </div>
    </div>
</div>
@endsection