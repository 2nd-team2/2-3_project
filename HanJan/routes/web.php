<?php

use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/TraditionaLiquor', function () {
//     return view('TraditionaLiquor');
// });

Route::get('/{any}', function() {
    return view('welcome');
})->where('any', '^(?!api).*$');


// ----------------------- 보원 시작 -------------------------
// 장바구니 초기 데이터 불러오기 //  TODO : 로그인 된 유저의 데이터만 들고오기 추가
// Route::middleware('auth')->get('/api/board', [ProductController::class, 'bagsIndex']);
Route::get('/api/bagsProduct', [ProductController::class, 'bagsIndex']);
Route::post('/api/bagsDelete/{ba_id}', [ProductController::class, 'bagsDelete']);



// ----------------------- 보원 끝 ---------------------------

// ----------------------- 성환 시작 -------------------------
Route::post('/api/login', [UserController::class, 'login']);
Route::post('/api/regist', [UserController::class, 'regist']);
Route::middleware('auth')->post('/api/logout', [UserController::class, 'logout']);
// ----------------------- 성환 끝 ---------------------------

// ----------------------- 민서 시작 -------------------------
Route::get('/api/detailed', [ProductController::class, 'value']);
Route::post('/api/detailed', [ProductController::class, 'checksIndex']);
// ----------------------- 민서 끝 ---------------------------

// ----------------------- 호경 시작 -------------------------
// 공지사항 데이터 불러오기
Route::get('/api/noticelist', [NoticeController::class, 'noticeIndex']);
// ----------------------- 호경 끝 ---------------------------
