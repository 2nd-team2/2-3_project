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
Route::middleware('auth')->post('/api/reviewCreateSubmit', [ReviewController::class, 'reviewCreateSubmit']);
// 리뷰 데이터 수정
Route::middleware('auth')->post('/api/reviewUpdateSubmit', [ReviewController::class, 'reviewUpdateSubmit']);
// 리뷰 데이터 삭제
Route::middleware('auth')->delete('/api/reviewDelete/{re_id}', [ReviewController::class, 'reviewDelete']);


// ----------------------- 보원 끝 ---------------------------

// ----------------------- 성환 시작 -------------------------

// 로그인 처리
Route::post('/api/login', [UserController::class, 'login']);
// 회원가입 처리
Route::post('/api/regist', [UserController::class, 'regist']);
// 회원정보 수정 처리
Route::post('/api/userUpdate', [UserController::class, 'userUpdate']);
// 회원 탈퇴
Route::delete('/api/userDelete', [UserController::class, 'userDelete']);
// 이메일 중복체크
Route::get('/api/regist/{emailText}', [UserController::class, 'registEmailChk']);
// 비밀번호 재확인
Route::post('/api/confirm', [UserController::class, 'confirm']);
// 로그아웃 처리
Route::middleware('auth')->post('/api/logout', [UserController::class, 'logout']);
// 구매확정 처리
Route::middleware('auth')->post('/api/complete/{id}', [ProductController::class, 'complete']);
// 주문목록 불러오기
Route::middleware('auth')->get('/api/info', [ProductController::class, 'infoData']);
// 상품목록 불러오기
Route::middleware('auth')->get('/api/productAsk', [QnaController::class, 'productAsk']);
// 1대1 문의 불러오기
Route::middleware('auth')->get('/api/askData', [QnaController::class, 'askData']);
// 상품목록 삭제
Route::middleware('auth')->delete('/api/productAskDelete/{qnp_id}', [QnaController::class, 'productAskDelete']);
// 1대1 문의 삭제
Route::middleware('auth')->delete('/api/askDelete/{qn_id}', [QnaController::class, 'askDelete']);

// ----------------------- 성환 끝 ---------------------------

// ----------------------- 민서 시작 -------------------------
// 상세페이지 데이터 불러오기
Route::get('/api/detailed/{id}', [ProductController::class, 'value']);
// 상세페이지 데이터 불러오기
Route::get('/api/listBast', [ProductController::class, 'listBast']);
// 리뷰 데이터 불러오기
Route::get('/api/detailed', [ProductController::class, 'detailedReview']);
// 수량 데이터 보내기(디테일->장바구니)
Route::post('/api/detailedToCount', [ProductController::class, 'detailedToCount']);
// 상세리스트 데이터 불러오기
Route::get('/api/list', [ProductController::class, 'list']);
// ----------------------- 민서 끝 ---------------------------

// ----------------------- 호경 시작 -------------------------
// 메인페이지 리뷰 불러오기
Route::get('/api/reviewlist',[ReviewController::class, 'reviewMainIndex']);
// 공지사항 데이터 불러오기
Route::get('/api/noticelist', [NoticeController::class, 'noticeIndex']);
// 공지사항 데이터 불러오기
Route::get('/api/notice', [NoticeController::class, 'detailNotice']);
// 상품문의내역 데이터 불러오기
Route::middleware('auth')->get('/api/qnaproductlist', [QnaController::class, 'qnaProductListIndex']);
// 상품문의 작성하기
Route::middleware('auth')->post('/api/qnaproduct', [QnaController::class, 'qnaProductCreate']);
// 상품문의내역 데이터 불러오기
Route::middleware('auth')->get('/api/qnaonebyonelist', [QnaController::class, 'qnaOnebyOneListIndex']);
// 1:1문의 작성하기
Route::middleware('auth')->post('/api/qnaonebyone', [QnaController::class, 'qnaOnebyOneCreate']);
// ----------------------- 호경 끝 ---------------------------
