@if (!session()->has('tendn'))
    echo "<script>window.location='login'</script>";
@endif
@extends('layouts.master')
@section('master')
<div class="container mt-4 mb-4" style="color: #000000;">
    <div class="dashboard-wrapper">
        <div class="dashboard-ecommerce">
            <div class="container-fluid dashboard-content ">
                <div class="card" style="flex-direction: row !important">
                    
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

                        <div class="col-md-5 navbar-nav ml-3">
                            <div id="custom-search" class="top-search-bar">
                                <input class="form-control" name="timkiemcb" id="timkiemcb" onchange="HienThongTin()" type="text" placeholder="Nhập tên giảng viên...">
                            </div>
                        </div>
                        <div id="ttgiangvien">
                            
                        </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-left mt-4">
                
        </div>
    </div>
</div>

<script>

    function HienThongTin(){
        var timkiemcb=$('#timkiemcb').val();
        $.ajax({
         type:'post',
         url:'/sinhvienngoaitru/thong-tin-giang-vien',
         data:{"timkiemcb":timkiemcb,"_token": "{{ csrf_token() }}"},
         success: function(data){
                var res = "";
                res += "<br /><br /><h5>KẾT QUẢ TRA CỨU</h5>"
                res += '<table class="table"><thead>'
                +'<th>Họ tên</th><th>Giới tính</th><th>Điện thoại</th><th>Email</th><th>CT Đào tạo</th></thead><tbody>';
                $.each(data,function(index,value){
                    res +=
                        '<tr>'+
                            '<td>'+value.hoten+'</td>'+
                            '<td>'+value.gioitinh+'</td>'+
                            '<td>'+value.sodienthoai+'</td>'+
                            '<td>'+value.email+'</td>'+
                            '<td>'+value.CTDaoTao+'</td>'+
                    '</tr>';
                });
                res += '</tbody></table>'
                $("#ttgiangvien").html(res);
            }
        });
    }
</script>
@endsection