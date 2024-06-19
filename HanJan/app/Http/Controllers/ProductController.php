<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\Bag;
use App\Models\Complete;
use App\Models\Orderproduct;
use App\Models\Product;
use App\Models\Qna;
use App\Models\Qnaproduct;
use App\Models\Review;
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
    
        $responseData = [
                'code' => '0'
                ,'msg' => '초기 장바구니 상품 획득 완료'
                ,'data' => $productDate->toArray()
        ];
        
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

        // 마이페이지 주문목록
        public function infoData() {
            $infoData = Orderproduct::select('orderproducts.*', 'orderproducts.created_at as orpDate','users.id','products.*','products.id as itemId', 'completes.*', 'completes.created_at as completeOn')
                            ->join('users','orderproducts.or_id','=','users.id')
                            ->leftJoin('completes', 'orderproducts.orp_id', '=', 'completes.orp_id')
                            ->leftJoin('products','orderproducts.p_id','=','products.id')
                            ->where('orderproducts.or_id', '=', Auth::id())
                            ->where('orderproducts.deleted_at', '=', null)
                            ->orderBy('orderproducts.created_at','DESC')
                            ->orderBy('orderproducts.orp_id','DESC')
                            ->distinct()
                            // ->limit(3)
                            ->get();
            
            Log::debug($infoData);


            $responseData = [
                'code' => '0'
                ,'msg' => '주문목록 획득 완료'
                ,'data' => $infoData->toArray()
            ];
        
            return response()->json($responseData, 200);
        }

        // 주문목록 삭제
        public function orderProductDelete($itemId) {

            Orderproduct::destroy($itemId);

            $responseData = [
                'code' => '0'
                ,'msg' => '삭제 완료'
                ,'data' => $itemId
            ];
            
            return response()->json($responseData);
        }

        // 구매확정
        public function complete($id) {
            
            $completeData = [
                'orp_id' => $id
                ,'co_flg' => 1
            ];

            $completeCreate = Complete::create($completeData);

            $responseData = [
                'code' => '0'
                ,'msg' => '구매확정'
                ,'data' => $completeCreate
            ];
        
            return response()->json($responseData, 200);
        }



        // ----------------------- 성환 끝 ---------------------------
        // ----------------------- 민서 시작 -------------------------
        // products(상품)테이블에서
        // users.name AS user_name = 유저이름 별칭
        public function value($id) {
            $productData = Product::select('products.id', 'products.price','products.count','products.img','products.info', 'products.name')
                            ->where('products.id', $id)
                            ->first();
                            // ->get();

            Log::debug($productData); //TODO 나중에 삭제 
        
            $responseData = [
                    'code' => '0'
                    ,'msg' => '초기 상품값 획득 완료'
                    ,'data' => $productData
            ];
            Log::debug($responseData); //TODO 나중에 삭제
            
            return response()->json($responseData, 200);
        }
        // products(상품)테이블에서
        public function listBast($id) {
            $productData = Product::select('products.id', 'products.price','products.count','products.img','products.info', 'products.name',  'products.created_at', 'reviews.re_star')
                            ->JOIN('reviews','reviews.re_id','=', 'products.id')
                            ->where('products.id', $id)
                            ->orderBy('products.created_at', 'DESC')
                            ->limit(5)
                            ->first();
                            // ->get();

            Log::debug($productData); //TODO 나중에 삭제 
        
            $responseData = [
                    'code' => '0'
                    ,'msg' => '초기 상품값 획득 완료'
                    ,'data' => $productData
            ];
            Log::debug($responseData); //TODO 나중에 삭제
            
            return response()->json($responseData, 200);
        }

        // review(리뷰)테이블에서
        // users.name AS user_name = 유저이름 별칭
        public function detailedReview() {
            $productData = Review::select('users.name AS user_name','reviews.re_star','reviews.re_content','reviews.updated_at')
                            ->JOIN('users','reviews.re_id','=', 'users.id')
                            ->limit(5)
                            ->get();

            Log::debug($productData); //TODO 나중에 삭제 
        
            $responseData = [
                    'code' => '0'
                    ,'msg' => '초기 리뷰 획득 완료'
                    ,'data' => $productData
            ];
            Log::debug($responseData); //TODO 나중에 삭제
            
            return response()->json($responseData, 200);
        }

        // products(상품)테이블에서
        // 상세리스트 데이터 불러오기
        public function list() {
            $productData = Product::select('products.price','products.img', 'products.name', 'products.id')
                            ->limit(20)
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

        // 디테일->장바구니 데이터 보내기
            public function detailedToCount(Request $request) {
            // 리퀘스트 데이터 받기
            $requestData = [
                'p_id' => $request->p_id
                ,'ba_count' => $request->ba_count
            ];
            Log::debug('장바구니 리퀘스트 데이터', $request->all());
            // 데이터 유효성 검사
            $validator = Validator::make(
                $requestData
                , [
                    'p_id' => ['required', 'regex:/^[0-9]+$/']
                    ,'ba_count' => ['required', 'regex:/^[0-9]+$/']
                ]
            );

            // 유효성 검사 실패 체크
            if($validator->fails()) {
                Log::debug('유효성 검사 실패', $validator->errors()->toArray());
                throw new MyValidateException('E01');
            }

            // 데이터 생성
            $createData = $request->only('p_id','ba_count');
            
            // 작성 처리
            $createData['u_id'] = Auth::id();
            $createData['ba_id'] = 1;
            $createData['p_id'] = $request->p_id;
            $createData['ba_count'] = $request->ba_count;

            // 작성 처리
            $bagItem = Bag::create($createData);

            // 레스폰스 데이터 생성
            $responseData = [
                'code' => '0'
                ,'msg' => '장바구니 추가 완료'
                ,'data' => $bagItem
            ];

            return response()->json($responseData, 200);
        }
        // ----------------------- 민서 끝 ---------------------------
        // ----------------------- 호경 시작 -------------------------
        // ----------------------- 호경 끝 ---------------------------
}
