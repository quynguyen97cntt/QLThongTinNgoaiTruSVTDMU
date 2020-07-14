<?php

Route::get('/', 'QLkhutro@TrangChinh')->name('/');
Route::get('trang-chu', 'QLkhutro@TrangChinh')->name('trang-chu');
Route::get('xemtheolop', 'QLkhutro@XemTheoLopTC')->name('xemtheolop');
Route::get('nhatrocosvtc', 'QLkhutro@NhaTroCoSVTC')->name('nhatrocosvtc');
Route::get('timkiemkhunhatro', 'QLkhutro@TrangChinhTimKiem')->name('timkiemkhunhatro');
Route::get('timkiemsvdangtro', 'QLOTro@TimKiemSVTro')->name('timkiemsvdangtro');

Route::get('welcome', function () {
    return view('trangchu');
})->name('welcome');

Route::get('lien-he', function () {
    return view('pages.user.contact');
})->name('lien-he');

Route::get('thongbao', 'QLThongBao@ThongBao')->name('thongbao');
Route::get('chitietthongbao', 'QLThongBao@ChiTietThongBao')->name('chitietthongbao');
Route::get('chitietbaiviet', 'QLBaiViet@ChiTietBaiViet')->name('chitietbaiviet');
Route::get('capnhatngoaitru', 'QLNgoaiTru@capnhatngoaitru')->name('capnhatngoaitru');
Route::post('capnhatTTNgoaitruSV/{mssv}', 'QLNgoaiTru@capnhatTTNgoaitruSV')->name('capnhatTTNgoaitruSV');

Route::get('capnhatthongtinsv', 'QLOTro@capnhatthongtinsv')->name('capnhatthongtinsv');
Route::post('capnhatTTSV/{mssv}', 'QLOTro@capnhatTTSV')->name('capnhatTTSV');

Route::post('ThemDSSVTro', 'QLOTro@ThemDSSVTro')->name('ThemDSSVTro');
Route::post('SuaDSSVTro/{id}', 'QLOTro@SuaDSSVTro')->name('SuaDSSVTro');
Route::post('XoaDSSVTro/{id}', 'QLOTro@XoaDSSVTro')->name('XoaDSSVTro');

Route::post('SuaTTChuTro/{gid}', 'QLOTro@SuaTTChuTro')->name('SuaTTChuTro');
Route::post('SuaTTSinhVien/{mssv}', 'QLOTro@SuaTTSinhVien')->name('SuaTTSinhVien');


Route::post('ThemBaiViet', 'QLBaiViet@ThemBaiViet')->name('ThemBaiViet');
Route::post('SuaBaiViet/{id}', 'QLBaiViet@SuaBaiViet')->name('SuaBaiViet');
Route::post('XoaBaiViet/{id}', 'QLBaiViet@XoaBaiViet')->name('XoaBaiViet');
Route::get('danh-sach-tro', 'QLOTro@SinhVienTro')->name('danh-sach-tro');
Route::get('thong-tin-chu-tro', 'QLOTro@ThongTinChuTro')->name('thong-tin-chu-tro');
Route::get('danh-sach-bai-viet', 'QLBaiViet@BaiVietChuTro')->name('danh-sach-bai-viet');
Route::get('trang-tin', 'QLBaiViet@BaiViet')->name('trang-tin');

Route::get('doi-mat-khau','QLtaikhoan@TrangDoiMatKhau')->name('doi-mat-khau');
Route::post('doi-mat-khau','QLtaikhoan@DoiMatKhau')->name('doi-mat-khau');

Route::get('send-email', 'ContactController@sendEmail');

Route::get('/projects.index', 'QLBaiViet@index')->name('projects.index');
Route::post('projects/media', 'QLBaiViet@storeMedia')->name('projects.storeMedia');
Route::post('projects.store', 'QLBaiViet@store')->name('projects.store');
Route::post('projects.deletefile', 'QLBaiViet@destroy')->name('projects.deletefile');

Route::get('datatest', 'DataTest@index')->name('datatest');
Route::post('apitest', 'DataTest@apitest')->name('apitest');
Route::get('apitest', 'DataTest@apitest')->name('apitest');

Route::get('signup', 'QLkhutro@SignUp')->name('signup');
Route::post('signup','QLkhutro@SignUpPost')->name('signup');

Route::get('activeAccount', 'QLkhutro@ActiveAccount')->name('activeAccount');

Route::get('thong-tin-giang-vien', 'QLCanBo@TTGiangVien')->name('thong-tin-giang-vien');
Route::post('thong-tin-giang-vien', 'QLCanBo@TraCuuTTGiangVien')->name('thong-tin-giang-vien');

Route::post('checkLocation','QLkhutro@CheckLocation')->name('checkLocation');
Route::get('lay-tt-khu-tro','QLNgoaiTru@getTTChutro')->name('lay-tt-khu-tro');
