@extends('layouts.master')
@section('master')
<div class="card mt-4 mb-4 container">
    <div class="pl-5 pr-5 pt-3 pb-3">
        <form action="send-email" method="get">
        @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="ten" class="font-weight-bold">Tên</label>
                    <input type="text" class="form-control" name="ten" id="ten" placeholder="Tên...">
                </div>
                <div class="form-group col-md-6">
                    <label for="sdt" class="font-weight-bold">Số điện thoại</label>
                    <input type="number" class="form-control" name="sdt" id="sdt" placeholder="Số điện thoại...">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tieude" class="font-weight-bold">Chủ đề <i class="text-danger">(*)</i></label>
                    <input type="text" class="form-control" required name="tieude" id="tieude" placeholder="Chủ đề...">
                </div>
                <div class="form-group col-md-6">
                    <label for="email" class="font-weight-bold">Email <i class="text-danger">(*)</i></label>
                    <input type="email" required class="form-control" name="email" id="email" placeholder="Email...">
                </div>
            </div>
            <div class="form-group">
                <label for="noidung" class="font-weight-bold">Nội dung <i class="text-danger">(*)</i></label>
                <textarea class="form-control" required rows="6" style="resize: none" name="noidung"
                    id="noidung"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Gửi</button>
        </form>
    </div>
</div>
@endsection