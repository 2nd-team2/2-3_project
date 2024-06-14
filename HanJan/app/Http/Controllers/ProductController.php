<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\Bag;
use App\Models\Product;
use Illuminate\Http\Request;
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
                        ->where('bags.u_id','=', 1)
                        // ->where('boards.user_id', '=', Auth::id())
                        ->orderBy('bags.ba_id','DESC')
                        ->limit(3)
                        ->get();

        Log::debug($productDate);
    
        $responseData = [
                'code' => '0'
                ,'msg' => '초기 장바구니 상품 획득 완료'
                ,'data' => $productDate->toArray()
        ];
        Log::debug($responseData);
        
        return response()->json($responseData, 200);
    
    
    }



        // ----------------------- 보원 끝 ---------------------------
        // ----------------------- 성환 시작 -------------------------
        // ----------------------- 성환 끝 ---------------------------
        // ----------------------- 민서 시작 -------------------------
        // products(상품)테이블에서
        // 로그인 되어있는 아이디와 일치하는 u_id의 초기 게시글 획득
        public function value() {
            $productData = Product::select('price', 'count')
                            ->where('id', 16) //16은 불려올 게시글 번호
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
        // 수량과 값을 보낸다
        public function checksIndex(Request $request) {
            // 유효성 검사
            $validator = Validator::make(
            $request->only('price', 'count'),
                [
                    'price' => ['required', 'numeric']
                    ,'count' => ['required', 'numeric']
                ]
            );
            // 유효성 검사 실패시 처리
            if($validator->fails()) {
                Log::debug('수량 체크 실패', $validator->errors()->toArray());
                throw new MyValidateException('E01');
            }
            
            // 작성 데이터 생성
            $checkData = $request->all();
    
            // 값 저장
            $price = $request->input('price');
            $count = $request->input('count');
            $checkData['price'] = $price;
            $checkData['count'] = $count;
    
            // 인서트 처리
            $userInfo = Log::create($checkData);
            $responseDate = [
                'code' => '0'
                ,'msg' => '수량,값 확득 완료'
                ,'data' => $userInfo
            ];
    
            return response()->json($responseDate, 200);
        }
        // ----------------------- 민서 끝 ---------------------------
        // ----------------------- 호경 시작 -------------------------
        // ----------------------- 호경 끝 ---------------------------
}
