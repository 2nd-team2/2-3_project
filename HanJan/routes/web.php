<?php

use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QnaController;
use App\Http\Controllers\ReviewController;
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
// 장바구니 초기 데이터 불러오기
Route::middleware('auth')->get('/api/bagsProduct', [ProductController::class, 'bagsIndex']);
// 장바구니 데이터 삭제
Route::middleware('auth')->delete('/api/bagsDelete/{ba_id}', [ProductController::class, 'bagsDelete']);
// 리뷰 초기 데이터 불러오기
Route::middleware('auth')->get('/api/review', [ReviewController::class, 'reviewIndex']);
// 리뷰 데이터 작성
// Route::middleware('auth')->post('/api/reviewCreate', [ReviewController::class, 'reviewCreate']);
// 리뷰 데이터 수정
Route::middleware('auth')->post('/api/reviewUpdateSubmit', [ReviewController::class, 'reviewUpdateSubmit']);
// 리뷰 데이터 삭제
Route::middleware('auth')->delete('/api/reviewDelete/{re_id}', [ReviewController::class, 'reviewDelete']);


// ----------------------- 보원 끝 ---------------------------

// ----------------------- 성환 시작 -------------------------
Route::post('/api/login', [UserController::class, 'login']);
Route::post('/api/regist', [UserController::class, 'regist']);
Route::post('/api/update', [UserController::class, 'update']);
Route::post('/api/userUpdate', [UserController::class, 'userUpdate']);
Route::delete('/api/userDelete', [UserController::class, 'userDelete']);
Route::get('/api/regist/{emailText}', [UserController::class, 'registEmailChk']);
Route::post('/api/confirm', [UserController::class, 'confirm']);
Route::middleware('auth')->post('/api/logout', [UserController::class, 'logout']);
Route::middleware('auth')->get('/api/info', [UserController::class, 'infoData']);
Route::middleware('auth')->get('/api/ask', [UserController::class, 'askData']);
// ----------------------- 성환 끝 ---------------------------

// ----------------------- 민서 시작 -------------------------
// 상세페이지 데이터 불러오기
Route::get('/api/detailed', [ProductController::class, 'value']);
// 상세리스트 데이터 불러오기
Route::get('/api/list', [ProductController::class, 'list']);
// ----------------------- 민서 끝 ---------------------------

// ----------------------- 호경 시작 -------------------------
// 공지사항 데이터 불러오기
Route::get('/api/noticelist', [NoticeController::class, 'noticeIndex']);
// 상품문의내역 데이터 불러오기
Route::middleware('auth')->get('/api/qnaproductlist', [QnaController::class, 'qnaProductListIndex']);
// 상품문의 작성하기
Route::middleware('auth')->post('/api/qnaproduct', [QnaController::class, 'qnaProductCreate']);
// 상품문의내역 데이터 불러오기
Route::middleware('auth')->get('/api/qnaonebyonelist', [QnaController::class, 'qnaOnebyOneListIndex']);
// 1:1문의 작성하기
Route::middleware('auth')->post('/api/qnaonebyone', [QnaController::class, 'qnaOnebyOneCreate']);
// ----------------------- 호경 끝 ---------------------------
