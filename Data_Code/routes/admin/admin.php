<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    Route::get('trang-quan-tri','QLkhutro@QLDSKhuNhaTro')->name('trang-quan-tri');

    Route::get('import','QLkhutro@import')->name('import');
    Route::get('export','QLkhutro@export')->name('export');

    Route::get('xuatdssvtro','QLkhutro@xuatdssvtro')->name('xuatdssvtro');

    Route::get('xuatdssv', 'QLSinhVien@export')->name('xuatdssv');
    Route::post('nhapdssv', 'QLSinhVien@import')->name('nhapdssv');

    Route::get('xuatnhatro', 'QLkhutro@export2')->name('xuatnhatro');
    Route::post('nhapnhatro', 'QLkhutro@import2')->name('nhapnhatro');

    Route::get('quan-ly-thong-tin-sv', function () {
        return view('pages.admin.QLThongTinSV');
    });

    Route::get('quan-ly-khu-tro', function () {
        return view('pages.admin.QLKhuTro');
    });

    Route::get('quan-ly-bai-viet', function () {
        return view('pages.admin.QLBaiViet');
    });

    Route::get('thong-ke-theo-phuong', function () {
        return view('pages.admin.ThongKeTheoPhuong');
    });

    Route::get('thong-ke-theo-chu-tro', function () {
        return view('pages.admin.ThongKeTheoChuTro');
    });


    Route::get('test', function(){
        $user = App\sinhvien::all()->toArray();
        var_dump($user);
    });

        Route::get('danhsachCB', 'QLCanBo@DanhsachCB')->name('danhsachCB');
        Route::get('danhsachSV', 'QLSinhVien@DanhsachSV')->name('danhsachSV');
        Route::post('themSV', 'QLSinhVien@ThemSV')->name('themSV');
        Route::post('suaSV/{mssv}', 'QLSinhVien@SuaSV')->name('suaSV');
        Route::post('xoaSV/{mssv}', 'QLSinhVien@XoaSV')->name('xoaSV');

        Route::get('quan-ly-khu-tro','QLkhutro@DsKhuTro')->name('quan-ly-khu-tro');
        Route::post('themNhatro','QLkhutro@ThemKhuTro')->name('themNT');
        Route::post('suaNhatro/{gid}','QLkhutro@SuaNhaTro')->name('SuaNT');
        Route::post('suaNhatro','QLkhutro@SuaNhaTroBanDo')->name('suaNhatro');
        Route::post('xoaNhatro/{gid}','QLkhutro@XoaNhaTro')->name('XoaNT');
        Route::post('XoaKhuTroBD','QLkhutro@XoaNhaTroBanDo')->name('XoaKhuTroBD');

        Route::post('danhsachsvotro','QLkhutro@DsSinhVienOtro')->name('DSSVotro');
        Route::post('DSSVOTroBanDo','QLkhutro@DSSVOtroBanDo')->name('DSSVOTroBanDo');
        Route::post('slsinhvien','QLkhutro@SoLuongSinhVien')->name('slsinhvien');

        Route::get('QLDSKhuNhaTro','QLkhutro@QLDSKhuNhaTro')->name('QLDSKhuNhaTro');
        Route::post('themNhakhutro','QLkhutro@ThemKhuTroBanDo')->name('themNhakhutro');
        Route::post('DangKyKhuTro','QLkhutro@DangKyKhuTro')->name('DangKyKhuTro');

        Route::get('thong-tin-tro', function () {
            return view('pages.admin.ThongTinTro');
        })->name('view-thong-tin-tro');
        Route::post('thong-tin-tro','QLOTro@DsOtro')->name('thong-tin-tro');
        Route::post('themOTro','QLkhutro@ThemOTro')->name('themOTro');

        Route::get('quan-ly-bai-viet', 'QLBaiViet@DsBaiViet')->name('quan-ly-bai-viet');
        Route::post('sua-trang-thai/{id}', 'QLBaiViet@SuaTrangThai')->name('sua-trang-thai');
        Route::post('xoaBV/{id}', 'QLBaiViet@XoaBV')->name('xoaBV');

        Route::get('thong-ke-theo-phuong', 'ThongKe@ThongKeTheoPhuong')->name('thong-ke-theo-phuong');

        Route::get('quan-ly-tai-khoan', 'QLtaikhoan@DanhsachTK')->name('quan-ly-tai-khoan');
        Route::post('themTK', 'QLtaikhoan@ThemTK')->name('themTK');
        Route::post('suaTK/{id}', 'QLtaikhoan@SuaTK')->name('suaTK');
        Route::post('xoaTK/{id}', 'QLtaikhoan@XoaTK')->name('xoaTK');
        Route::post('suaQuyenTK/{id}/{tendangnhap}', 'QLtaikhoan@SuaQuyenTK')->name('suaQuyenTK');
        Route::post('kichhoatTK/{id}/{tendangnhap}', 'QLtaikhoan@KichHoatTK')->name('kichhoatTK');
        Route::post('khoaTK/{id}/{tendangnhap}', 'QLtaikhoan@KhoaTK')->name('khoaTK');

        Route::get('thong-ke-sinh-vien-phuong', 'ThongKe@ThongKeSinhVienPhuong')->name('thong-ke-sinh-vien-phuong');
        Route::get('thong-ke-theo-chu-tro', 'ThongKe@ThongKeTheoTro')->name('thong-ke-theo-chu-tro');
        Route::get('bieu-do-thong-ke-phuong', 'ThongKe@ChartTheoPhuong')->name('bieu-do-thong-ke-phuong');

        Route::get('tim-kiem-sinh-vien', 'QLSinhVien@search')->name('tim-kiem-sinh-vien');
        Route::get('tim-kiem-khu-tro', 'QLkhutro@search')->name('tim-kiem-khu-tro');
        Route::get('tim-kiem-tai-khoan', 'QLtaikhoan@search')->name('tim-kiem-tai-khoan');
        Route::get('tim-kiem-ngoai-tru', 'QLNgoaiTru@search')->name('tim-kiem-ngoai-tru');
        Route::get('tim-kiem-can-bo', 'QLCanBo@search')->name('tim-kiem-can-bo');

        Route::get('doimatkhauadmin', function () {
            return view('pages.admin.doimatkhauadmin');
        })->name('doimatkhauadmin');
        Route::post('doimatkhauadmin','QLtaikhoan@DoiMatKhauAdmin')->name('doimatkhauadmin');

        Route::post('xoasinhvienlop','QLSinhVien@xoasinhvientheolop')->name('xoasinhvienlop');
        Route::get('xoatatcasinhvien','QLSinhVien@xoatatcasinhvien')->name('xoatatcasinhvien');

        Route::get('quanlyngoaitru','QLNgoaiTru@QuanLyNgoaiTru')->name('quanlyngoaitru');
        Route::post('thietlapTG','QLNgoaiTru@thietlapTG')->name('thietlapTG');
        Route::get('sap-xep-ngoai-tru','QLNgoaiTru@sapxepngoaitru')->name('sap-xep-ngoai-tru');
        Route::get('xem-ds-ngoai-tru','QLNgoaiTru@XemDSNgoaiTru')->name('xem-ds-ngoai-tru');
        Route::post('xem-ds-ngoai-tru','QLNgoaiTru@XemDSNgoaiTru')->name('xem-ds-ngoai-tru');

        Route::post('xuatdsSVDKNgoaiTru','QLNgoaiTru@xuatdkngoaitru')->name('xuatdsSVDKNgoaiTru');
        Route::post('xuatdsSVChuaDKNgoaiTru','QLNgoaiTru@xuatchuadkngoaitru')->name('xuatdsSVChuaDKNgoaiTru');

        Route::get('quan-ly-thong-bao','QLThongBao@QuanLyThongBao')->name('quan-ly-thong-bao');
        Route::post('themTB','QLThongBao@ThemThongBao')->name('themTB');
        Route::post('xoaTB','QLThongBao@XoaThongBao')->name('xoaTB');
        Route::post('suaTB','QLThongBao@SuaThongBao')->name('suaTB');
        Route::get('timkiembando', 'QLkhutro@TrangAdminTimKiem')->name('timkiembando');

        Route::post('xoaCB','QLCanBo@XoaCanBo')->name('xoaCB');
        Route::post('suaTTCB','QLCanBo@SuaTTCanBo')->name('suaTTCB');
        Route::post('themTTCB','QLCanBo@ThemCanBo')->name('themTTCB');

        Route::post('trangthaiSV','QLkhutro@QLDSKhuNhaTroKhongCoSV')->name('trangthaiSV');

        Route::get('xuat-tk-theo-phuong','ThongKe@xuattktheophuong')->name('xuat-tk-theo-phuong');
        Route::get('xuat-tk-theo-khu-tro','ThongKe@xuattktheokhutro')->name('xuat-tk-theo-khu-tro');
        Route::get('xuat-tk-sv-phuong','ThongKe@xuattksvphuong')->name('xuat-tk-sv-phuong');

        Route::post('duyet-khu-tro','QLkhutro@DuyetKhuTro')->name('duyet-khu-tro');
        Route::post('tu-choi-duyet','QLkhutro@TuChoiDuyet')->name('tu-choi-duyet');

        Route::post('getanhbaiviet','QLBaiViet@GetAnhBaiViet')->name('getanhbaiviet');
