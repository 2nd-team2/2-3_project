<?php

use App\Http\Controllers\BagController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QnaController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TraditionalLiquorController;
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
Route::middleware('auth')->get('/api/bagsProduct', [BagController::class, 'bagsIndex']);
// 장바구니 수량 감소한 데이터 저장
Route::middleware('auth')->post('/api/bagsCountMinus/{ba_id}', [BagController::class, 'bagsCountMinus']);
// 장바구니 수량 증가한 데이터 저장
Route::middleware('auth')->post('/api/bagsCountPlus/{ba_id}', [BagController::class, 'bagsCountPlus']);
// 장바구니 수량 입력한 데이터 저장
Route::middleware('auth')->post('/api/bagsCountChange/{ba_id}', [BagController::class, 'bagsCountChange']);

// 장바구니 데이터 삭제
Route::middleware('auth')->delete('/api/bagsDelete/{ba_id}', [BagController::class, 'bagsDelete']);
// 장바구니 데이터 선택 삭제
Route::middleware('auth')->post('/api/bagsSelectDelete', [BagController::class, 'bagsSelectDelete']);
// 장바구니 데이터 > 주문 페이지로 넘기기
Route::middleware('auth')->post('/api/bagsToOrder', [BagController::class, 'bagsToOrder']);

// 결제하기 처리 및 데이터 저장 - (주문, 주문상품, 교환 및 반품 테이블 생성, 장바구니삭제)
Route::middleware('auth')->post('/api/orderTrans', [OrderController::class, 'orderTrans']);
// // 결제하기 데이터 저장(주문, 주문상품, 장바구니삭제)
// Route::middleware('auth')->post('/api/orderComplete', [OrderController::class, 'orderComplete']);
// Route::middleware('auth')->post('/api/orderProductComlete/{or_id}', [OrderController::class, 'orderProductComlete']);
// Route::middleware('auth')->post('/api/bagsCompleteDelete', [OrderController::class, 'bagsCompleteDelete']);
// // 결제하기 데이터 저장(구매확정, 교환 및 반품 테이블 생성)
// Route::middleware('auth')->post('/api/orderComEx/{orp_id}', [OrderController::class, 'orderComEx']);

// 리뷰 초기 데이터 불러오기
Route::middleware('auth')->get('/api/review', [ReviewController::class, 'reviewIndex']);
// 리뷰 데이터 작성
Route::middleware('auth')->post('/api/reviewCreateSubmit', [ReviewController::class, 'reviewCreateSubmit']);
// 리뷰 데이터 수정
Route::middleware('auth')->post('/api/reviewUpdateSubmit', [ReviewController::class, 'reviewUpdateSubmit']);
// 리뷰 데이터 삭제
Route::middleware('auth')->delete('/api/reviewDelete/{re_id}', [ReviewController::class, 'reviewDelete']);

// 교환 및 반품 초기 데이터 불러오기
Route::middleware('auth')->get('/api/exchangeProduct/{id}', [ExchangeController::class, 'exchangeProduct']);
Route::middleware('auth')->post('/api/exchage', [ExchangeController::class, 'exchage']);


// ----------------------- 보원 끝 ---------------------------

// ----------------------- 성환 시작 -------------------------

// 로그인 처리
Route::post('/api/login', [UserController::class, 'login']);
// 회원가입 처리
Route::post('/api/regist', [UserController::class, 'regist']);
// 회원정보 수정 처리
Route::middleware('auth')->post('/api/userUpdate', [UserController::class, 'userUpdate']);
// 회원 탈퇴
Route::middleware('auth')->delete('/api/userDelete', [UserController::class, 'userDelete']);
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
// 주문목록 삭제
Route::middleware('auth')->delete('/api/orderProductDelete/{itemId}', [ProductController::class, 'orderProductDelete']);
// 상품목록 삭제
Route::middleware('auth')->delete('/api/productAskDelete/{qnp_id}', [QnaController::class, 'productAskDelete']);
// 1대1 문의 삭제
Route::middleware('auth')->delete('/api/askDelete/{qn_id}', [QnaController::class, 'askDelete']);

// ----------------------- 성환 끝 ---------------------------

// ----------------------- 민서 시작 -------------------------
// 상세페이지 데이터 불러오기
Route::get('/api/detailed/{id}', [ProductController::class, 'value']);
// 상세페이지 데이터 불러오기
Route::get('/api/listbast', [ProductController::class, 'listBast']);
// 리뷰 데이터 불러오기
Route::get('/api/reviewdetailed/{id}', [ProductController::class, 'detailedReview']);
// 수량 데이터 보내기(디테일->장바구니)
Route::middleware('auth')->post('/api/detailedtocount', [ProductController::class, 'detailedToCount']);
// 상세리스트 데이터 불러오기
Route::get('/api/list', [ProductController::class, 'list']);
// ----------------------- 민서 끝 ---------------------------


// ----------------------- 호경 시작 -------------------------
// 메인페이지 리뷰 불러오기
Route::get('/api/reviewlist',[ReviewController::class, 'reviewMainIndex']);
// 메인페이지 계절 별 추천 불러오기
Route::get('/api/season',[ProductController::class, 'seasonSelect']);
// 공지사항 데이터 불러오기
Route::get('/api/noticelist', [NoticeController::class, 'noticeIndex']);
// 공지사항 디테일 데이터 불러오기
Route::get('/api/notice', [NoticeController::class, 'detailNotice']);
// 상품문의내역 데이터 불러오기
Route::middleware('auth')->get('/api/qnaproductdetail/{id}', [QnaController::class, 'qnaProductDetailIndex']);
// 상품문의 작성하기
Route::middleware('auth')->post('/api/qnaproductcreate', [QnaController::class, 'qnaProductCreate']);
// 상품문의내역 데이터 불러오기
Route::middleware('auth')->get('/api/qnaonebyonedetail/{id}', [QnaController::class, 'qnaOnebyOneDetailIndex']);
// 1:1문의 작성하기
Route::middleware('auth')->post('/api/qnaonebyonecreate', [QnaController::class, 'qnaOnebyOneCreate']);
// 전통주 설명 불러오기
Route::get('/api/traditionalliquor', [TraditionalLiquorController::class, 'traditionalLiquorIndex']);
// ----------------------- 호경 끝 ---------------------------
