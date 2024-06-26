<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\Bag;
use App\Models\Complete;
use App\Models\Orderproduct;
use App\Models\Product;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

// ************************************************

// 재사용할 수도 있으므로 기능 설명 꼭 주석처리 해두기

// ************************************************

class ProductController extends Controller
{
    // ----------------------- 보원 시작 -------------------------

    // ----------------------- 보원 끝 ---------------------------
    // ----------------------- 성환 시작 -------------------------

        // 마이페이지 주문목록
        public function infoData() {
            $infoData = Orderproduct::select(
                            'orderproducts.*'
                            ,'orderproducts.created_at as orpDate'
                            ,'products.*'
                            ,'completes.*'
                            ,'completes.created_at as completeOn'
                            ,'exchanges.ex_flg'
                            ,'orders.*')
                            ->join('orders','orderproducts.or_id','=','orders.or_id')
                            ->join('products','orderproducts.p_id','=','products.id')
                            ->leftJoin('exchanges','orderproducts.orp_id','=','exchanges.orp_id')
                            ->leftJoin('completes', 'orderproducts.orp_id', '=', 'completes.orp_id')
                            ->where('orders.u_id', '=', Auth::id())
                            ->orderBy('orderproducts.created_at','DESC')
                            ->orderBy('orderproducts.orp_id','DESC')
                            ->distinct()
                            ->paginate(3);

        $responseData = [
            'code' => '0'
            ,'msg' => '주문목록 획득 완료'
            ,'data' => $infoData->toArray()
        ];
    
        return response()->json($responseData, 200);
    }

    // 주문목록 삭제
    public function orderProductDelete($orp_id) {

        $result = Orderproduct::destroy($orp_id);

        $responseData = [
            'code' => '0'
            ,'msg' => '삭제 완료'
            ,'data' => $result
        ];
        
        return response()->json($responseData);
    }

    // 구매확정
    public function complete($orp_id) {
        $completeCreate = Complete::updateOrCreate(['orp_id' => $orp_id], ['co_flg' => '1', 'created_at' => Carbon::now()]);
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
        // $productData = Product::select('products.id', 'products.price','products.count','products.img','products.info', 'products.name', 'SUM(reviews.re_star)')
        //                 ->join('reviews','reviews.p_id','=', 'products.id')
        //                 ->where('products.id', $id)
        //                 ->first();
                        // ->get();
                        // 
        $productData = Product::select('products.id', 'products.price', 'products.count', 'products.img', 'products.info', 'products.name', DB::raw('COUNT(reviews.re_id) as total_star'), DB::raw('ROUND(AVG(reviews.re_star),1) as star_avg'))
        ->leftJoin('reviews', 'products.id', '=', 'reviews.orp_id')
        ->where('products.id', $id)
        ->groupBy('products.id', 'products.price', 'products.count', 'products.img', 'products.info', 'products.name')
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

    // review(리뷰)테이블에서
    // users.name AS user_name = 유저이름 별칭
    // 리뷰 최신순으로 가져오기
    public function detailedReview($id) {
        // $productData = Review::select('users.name AS user_name','products.id' ,'reviews.re_star','reviews.re_content','reviews.updated_at')
        //                 ->JOIN('products','reviews.orp_id','=', 'products.id')
        //                 ->JOIN('users','reviews.u_id','=', 'users.id')
        //                 ->where('products.id', $id) // 상품 아이디 가져와 리뷰 출력
        //                 ->orderBy('reviews.re_star', 'DESC')
        //                 ->orderBy('reviews.created_at', 'DESC')
        //                 ->limit(5)
        //                 ->get();
        $productData = Review::select('users.name AS user_name','products.id' ,'reviews.re_star','reviews.re_content','reviews.updated_at')
                        ->JOIN('users','reviews.u_id','=', 'users.id')
                        ->JOIN('orderproducts','reviews.orp_id','=', 'orderproducts.orp_id')
                        ->JOIN('products','products.id','=', 'orderproducts.p_id')
                        ->where('products.id', $id) // 상품 아이디 가져와 리뷰 출력
                        ->orderBy('reviews.re_star', 'DESC')
                        ->orderBy('reviews.created_at', 'DESC')
                        ->limit(5)
                        ->get();

        Log::debug($productData);
    
        $responseData = [
                'code' => '0'
                ,'msg' => '초기 리뷰 획득 완료'
                ,'data' => $productData
        ];
        Log::debug($responseData);
        
        return response()->json($responseData, 200);
    }

    // products(상품)테이블에서
    // 상세리스트 데이터 불러오기
    public function list(Request $request) {
        $productQuery = Product::select('products.price','products.img', 'products.name', 'products.id')
                        ->orderBy('products.created_at', 'DESC');
                        // ->paginate(20);

        if($request->type != '99') {
            $productQuery->where('products.type', $request->type);
        }
        
        $productData = $productQuery->paginate(20);

        Log::debug('리퀘스트 data', $request->all());
        Log::debug('결과', $productData->toArray());
        
        $responseData = [
                'code' => '0'
                ,'msg' => '초기 상품값 획득 완료'
                ,'data' => $productData
        ];
        // Log::debug($responseData);
        
        return response()->json($responseData, 200);
    }

    // products(상품)테이블에서
    // 베스트 상품 출력
    public function listBast() {
        $productData = Product::select('products.*', 'rev.star_avg', 'rev.star_avg_round')
                            ->join(DB::raw('(SELECT orp_id, AVG(re_star) as star_avg, ROUND(AVG(re_star), 0) as star_avg_round
                                            FROM reviews
                                            GROUP BY orp_id) as rev'), 'rev.orp_id', '=', 'products.id')
                            ->orderByDesc('rev.star_avg')
                            ->orderByDesc('products.created_at')
                            ->limit(5)
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
        $createData['ba_id'] = $request->ba_id;
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
    // 메인 페이지에서 계절별 추천 출력
    public function seasonSelect() {
        // 테스트 날짜 설정
            // $nowMonth = 1;

            // // Carbon을 사용하여 날짜 계산
            // Carbon::setTestNow(Carbon::create(2023, 9, 15));
            // $nowMonth = date('n', strtotime(now())); 

            // // 인자가 없으면 현재 날짜 사용
            // $nowMonth = $testMonth ?? date('n', strtotime(now())); 
            // $this->seasonSelect(1);

        // 현재 날짜 설정 함수
        $nowMonth = date('n', strtotime(now()));
        $season = '';
        if ($nowMonth == 12 || $nowMonth == 1 || $nowMonth == 2 ) {
            // 겨울
            $season = '3'; 
        } else if($nowMonth <= 5) {
            // 봄
            $season = '0';
        } else if($nowMonth <= 8) {
            // 여름
            $season = '1';
        } else {
            // 가을
            $season = '2';
        }
        $noticeData = Product::select('products.*')
                            ->where('products.season', '=', $season)
                            ->orderby('products.created_at', 'DESC')
                            ->limit(8)
                            ->get();
        $responseData = [
            'code' => '0'
            ,'msg' => '리뷰 획득 완료'
            ,'data' => $noticeData->toArray()
            ,'season' => $this->getSeasonKorean($season)
        ];

        return response()->json($responseData, 200);
    }

    public function getSeasonKorean($value) {
        if ($value == '0') {
            return '향긋한 봄';
        } else if($value == '1') {
            return '시원한 여름';
        } else if($value == '2') {
            return '선선한 가을';
        } else {
            return '포근한 겨울';
        }
    }
    // ----------------------- 호경 끝 ---------------------------
}
