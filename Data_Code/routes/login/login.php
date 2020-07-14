
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
Route::get('login', function () {
    return view('login');
});
Route::post('login','QLtaikhoan@login');
Route::get('thoat','QLtaikhoan@thoat');
Route::get('trang-chu','QLkhutro@trangchu');
Route::get('thoatadmin','QLtaikhoan@thoatadmin');