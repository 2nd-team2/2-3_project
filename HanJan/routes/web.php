<?php

use App\Http\Controllers\ProductController;
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



// ----------------------- 보원 끝 ---------------------------

// ----------------------- 성환 시작 -------------------------
// ----------------------- 성환 끝 ---------------------------

// ----------------------- 민서 시작 -------------------------
// ----------------------- 민서 끝 ---------------------------

// ----------------------- 호경 시작 -------------------------
// ----------------------- 호경 끝 ---------------------------