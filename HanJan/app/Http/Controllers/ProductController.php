<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\Bag;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

// ************************************************

// 재사용할 수도 있으므로 기능 설명 꼭 주석처리 해두기

// ************************************************

class ProductController extends Controller
{
    // ----------------------- 보원 시작 -------------------------

    // Bags(장바구니)테이블에서
    // 로그인 되어있는 아이디와 일치하는 u_id의 초기 게시글 획득
    public function bagsIndex () {
        $productDate = Bag::select('bags.*', 'products.*', 'users.id')
                        ->join('users','bags.u_id','=','users.id')
                        ->join('products','bags.p_id','=','products.id')
                        ->where('bags.u_id', '=', Auth::id())
                        ->where('bags.deleted_at', '=', null)
                        ->orderBy('bags.created_at','DESC')
                        ->orderBy('bags.ba_id','DESC')
                        // ->limit(3)
                        ->get();

        Log::debug($productDate); // TODO
    
        $responseData = [
                'code' => '0'
                ,'msg' => '초기 장바구니 상품 획득 완료'
                ,'data' => $productDate->toArray()
        ];
        Log::debug($responseData); // TODO
        
        return response()->json($responseData, 200);
    }

    // Bags(장바구니)테이블에서 휴지통 버튼 눌렀을때 삭제 처리
    public function bagsDelete($ba_id) {

        Bag::destroy($ba_id);
        
        $responseData = [
            'code' => '0'
            ,'msg' => '장바구니 상품 삭제 완료'
            ,'data' => $ba_id
        ];

        return response()->json($responseData);
    }



        // ----------------------- 보원 끝 ---------------------------
        // ----------------------- 성환 시작 -------------------------
        // ----------------------- 성환 끝 ---------------------------
        // ----------------------- 민서 시작 -------------------------
        // products(상품)테이블에서
        // users.name AS user_name = 유저이름 별칭
        public function value() {
            $productData = Product::select('products.price','products.count','products.img','products.info', 'products.name','users.name AS user_name','reviews.re_star','reviews.re_content','reviews.updated_at')
                            ->JOIN('reviews','products.id','=','reviews.re_id')
                            ->JOIN('users','reviews.re_id','=', 'users.id')
                            // ->limit(10)
                            ->first();

            Log::debug($productData);
        
            $responseData = [
                    'code' => '0'
                    ,'msg' => '초기 상품값 획득 완료'
                    ,'data' => $productData
            ];
            Log::debug($responseData);
            
            return response()->json($responseData, 200);
        }
        // products(상품)테이블에서
        // users.name AS user_name = 유저이름 별칭
        public function list() {
            $productData = Product::select('products.price','products.img', 'products.name', 'products.id')
                            ->where('products.id', 2) //16은 불려올 게시글 번호
                            ->limit(10)
                            ->get();

            Log::debug($productData);
        
            $responseData = [
                    'code' => '0'
                    ,'msg' => '초기 상품값 획득 완료'
                    ,'data' => $productData
            ];
            Log::debug($responseData);
            
            return response()->json($responseData, 200);
        }

        // products(상품)테이블에서
        // 수량과 값을 보낸다
        public function checksIndex(Request $request) {
            // 유효성 검사
            $validator = Validator::make(
            $request->only('price', 'count', 'img'),
                [
                    'price' => ['required', 'numeric']
                    ,'count' => ['required', 'numeric']
                    ,'img' => ['required', 'image']
                ]
            );
            // 유효성 검사 실패시 처리
            if($validator->fails()) {
                Log::debug('상품정보 전달 실패', $validator->errors()->toArray());
                throw new MyValidateException('E01');
            }
        }
        // ----------------------- 민서 끝 ---------------------------
        // ----------------------- 호경 시작 -------------------------
        // ----------------------- 호경 끝 ---------------------------
}
