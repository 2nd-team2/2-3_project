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
use Illuminate\Support\Str;

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
                            ,'reviews.re_id'
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
                            ->leftJoin('reviews', 'orderproducts.orp_id', '=', 'reviews.orp_id')
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
        
        // $productData = Product::select('products.id', 'products.price', 'products.count', 'products.img', 'products.info', 'products.name', DB::raw('COUNT(reviews.re_id) as total_star'), DB::raw('ROUND(AVG(reviews.re_star),1) as star_avg'))
        //                 ->leftJoin('orderproducts','products.id','=', 'orderproducts.p_id')
        //                 ->leftJoin('reviews','reviews.orp_id','=', 'orderproducts.orp_id')
        //                 ->where('products.id', $id)
        //                 ->groupBy('products.id', 'products.price', 'products.count', 'products.img', 'products.info', 'products.name')
        //                 ->distinct()
        //                 ->first();

        $subQuery = Orderproduct::select('orderproducts.p_id', DB::raw('COUNT(reviews.re_id) total_star'), DB::raw('ROUND(AVG(reviews.re_star), 1) star_avg'))
                                ->join('reviews', 'orderproducts.orp_id', '=', 'reviews.orp_id')
                                ->where('orderproducts.p_id', $id)
                                ->whereNull('reviews.deleted_at')
                                ->groupBy('orderproducts.p_id');

        $productData = Product::select('products.*', 'avg_rev.total_star', 'avg_rev.star_avg')
                            ->leftJoinSub($subQuery, 'avg_rev', function($query) {
                                $query->on('avg_rev.p_id', '=', 'products.id');
                            })
                            ->where('products.id', $id)
                            ->first();

        $responseData = [
                'code' => '0'
                ,'msg' => '초기 상품값 획득 완료'
                ,'data' => $productData
        ];
        
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
                        ->join('users','reviews.u_id','=', 'users.id')
                        ->join('orderproducts','reviews.orp_id','=', 'orderproducts.orp_id')
                        ->join('products','products.id','=', 'orderproducts.p_id')
                        ->where('products.id', $id) // 상품 아이디 가져와 리뷰 출력
                        ->orderBy('reviews.re_star', 'DESC')
                        ->orderBy('reviews.created_at', 'DESC')
                        ->limit(5)
                        ->get();

        $responseData = [
                'code' => '0'
                ,'msg' => '초기 리뷰 획득 완료'
                ,'data' => $productData
        ];
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
        $responseData = [
                'code' => '0'
                ,'msg' => '초기 상품값 획득 완료'
                ,'data' => $productData
        ];
        // Log::debug($responseData);
        
        return response()->json($responseData, 200);
    }

    // products(상품)테이블에서
    // 검색한 상세리스트 데이터 불러오기
    public function listck(Request $request) {
        $query = $request->search;
        Log::debug('상품검색 req', $request->all());
        $productQuery = Product::select('products.price','products.img', 'products.name', 'products.id', 'products.type')
                        ->where('products.name','like', "%{$query}%")
                        ->orderBy('products.created_at', 'DESC');
                        // ->paginate(20);

        if($request->type != '99') {
            $productQuery->where('products.type', $request->type);
        }
        
        // $productData = $productQuery->dd(); 화면에 출력해서 코드 확인용
        $productData = $productQuery->paginate(20);

        
        Log::debug('상품검색 완', $productData->toArray());
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
        // $productData = Product::select('products.*', 'rev.star_avg', 'rev.star_avg_round')
        //                     ->join(DB::raw('(SELECT orp_id, AVG(re_star) as star_avg, ROUND(AVG(re_star), 0) as star_avg_round
        //                                     FROM reviews
        //                                     GROUP BY orp_id) as rev'), 'rev.orp_id', '=', 'products.id')
        //                     ->orderByDesc('rev.star_avg')
        //                     ->orderByDesc('products.created_at')
        //                     ->limit(5)
        //                     ->get();
        // $productData = Product::select('products.id', 'products.price', 'products.img', 'products.name', 'rev.star_avg', 'rev.star_avg_round')
        //                     ->join(DB::raw('(SELECT orp_id, AVG(re_star) AS star_avg, ROUND(AVG(re_star), 0) AS star_avg_round
        //                                     FROM reviews
        //                                     GROUP BY orp_id) AS rev'))
        //                             ->join('orderproducts','rev.orp_id', '=', 'orderproducts.orp_id')
        //                     ->join('orderproducts', 'products.id', '=', 'orderproducts.p_id')
        //                     ->whereColumn('products.id', '=', 'orderproducts.p_id')
        //                     ->groupBy('products.id')
        //                     ->orderByDesc('rev.star_avg')
        //                     ->orderByDesc('products.created_at')
        //                     ->limit(5)
        //                     ->get();

        $subQuery = Review::select('orderproducts.p_id', DB::raw('ROUND(AVG(reviews.re_star),1) AS avg_star'))
                            ->join('orderproducts', 'reviews.orp_id', '=', 'orderproducts.orp_id')
                            ->groupBy('orderproducts.p_id');

        $productData = Product::select('products.*', 'avt.avg_star')
                                ->joinSub($subQuery, 'avt', function($query) {
                                    $query->on('products.id', '=', 'avt.p_id');
                                })
                                // ->join(DB::raw('(SELECT orderproducts.p_id, ROUND(AVG(reviews.re_star)) AS avg_star
                                //                 FROM reviews
                                //                 JOIN orderproducts ON reviews.orp_id = orderproducts.orp_id
                                //                 GROUP BY orderproducts.p_id) AS avt'), 'products.id', '=', 'avt.p_id')
                                ->orderByDesc('avt.avg_star')
                                ->orderByDesc('products.created_at')
                                ->get();
        // $productData = DB::table('reviews')
        //             ->join('orderproducts', 'reviews.orp_id', '=', 'orderproducts.orp_id')
        //             ->select('orderproducts.p_id', DB::raw('ROUND(AVG(reviews.re_star)) AS avg_star'))
        //             ->whereNull('reviews.deleted_at')
        //             ->groupBy('orderproducts.p_id')
        //             ->get();

        $responseData = [
                'code' => '0'
                ,'msg' => '초기 상품값 획득 완료'
                ,'data' => $productData
        ];
        
        return response()->json($responseData, 200);
    }


    // 디테일->장바구니 데이터 보내기
        public function detailedToCount(Request $request) {
        // 리퀘스트 데이터 받기
        $requestData = [
            'p_id' => $request->p_id
            ,'ba_count' => $request->ba_count
        ];
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
        // $createData = $request->only('p_id','ba_count');
        
        // // 작성 처리
        // $createData['u_id'] = Auth::id();
        // $createData['ba_id'] = $request->ba_id;
        // $createData['p_id'] = $request->p_id;
        // $createData['ba_count'] = $request->ba_count;

        // // $bagItem = Bag::create($createData); // 한개씩만 저장이 된다
        // // 받은 데이터로 유저아이디랑 상품아이디가 같을때 ba_count랑 기존 저장된 count랑 합쳐서 저장 처리
        // $bagItem_user = ['key' => 'p_id'];
        // $bagItem = ['ba_count' => 'p_id'];
        // $bagItem_data = Bag::updateOrCreate($bagItem_user, $bagItem);
        // 유저 ID 가져오기
        $userId = Auth::id();
        // 동일한 p_id와 u_id를 가진 항목이 이미 존재하는지 확인
        $existingItem = Bag::where('p_id', $request->p_id) 
                            ->where('u_id', $userId) 
                            ->first();

        if ($existingItem) { 
            // 기존 항목이 있으면 수량 업데이트
            $existingItem->ba_count += $request->ba_count; 
            $existingItem->save(); 
            $bagItem = $existingItem;
        } else { 
            // 데이터 생성
            $createData = $request->only('p_id', 'ba_count'); 
            $createData['u_id'] = $userId; 
            // 작성 처리
            $bagItem = Bag::create($createData);
        }

        // 레스폰스 데이터 생성
        $responseData = [
            'code' => '0'
            ,'msg' => '장바구니 추가 완료'
            ,'data' => $bagItem
        ];

        return response()->json($responseData, 200);
    }

    // 키워드 데이터
    public function typelistchk(Request $request) {
        $productQuery = Product::select('products.name', 'products.id')
                        ->join('orderproducts', 'products.id', '=', 'orderproducts.p_id')
                        ->groupBy('products.id', 'products.name')
                        ->orderByDesc('orderproducts.orp_count')
                        // ->limit(5);
                        ->get();

        // if($request->type != '99') {
        //     $productQuery->where('products.type', $request->type);
        // }
        
        // $productData = $productQuery->dd(); // 화면에 출력해서 코드 확인용
        // $productData = $productQuery->paginate(5);

        $responseData = [
                'code' => '0'
                ,'msg' => '초기 상품값 획득 완료'
                ,'data' => $productQuery
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

    // 타이틀 변경 함수
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

    // --------------------------------------------------------------------- 관리자 페이지 -------------------------------------------------------------------------
    // ----------------------- 보원 시작 ---------------------------
    // ----------------------- 보원 끝 ---------------------------

    // ----------------------- 성환 시작 ---------------------------
    // ----------------------- 성환 끝 ---------------------------

    // ----------------------- 민서 시작 ---------------------------
    // ----------------------- 민서 끝 ---------------------------

    // ----------------------- 호경 시작 ---------------------------
    // 관리자 페이지 상품 전체 불러오기
    public function adminProductIndex() {
        $adminProductData = Product::withTrashed()
                            ->select('products.*')
                            ->orderBy('products.deleted_at', 'ASC')
                            ->orderBy('products.created_at', 'DESC')
                            ->paginate(15);
        
        $responseData = [
            'code' => '0'
            ,'msg' => '상품 전체 획득 완료'
            ,'data' => $adminProductData->toArray()
        ];

        return response()->json($responseData, 200);
    }

    // 상품 추가
    public function productCreate(Request $request) {
        $requestData = $request->all();
        $validator = Validator::make(
            $requestData,
                [
                    // 'name' => ['required', 'regex:/^[가-힣0-9%()[]\s]+$/'],
                    'name' => ['required', 'regex:/^[가-힣0-9%\s]+$/'],
                    'price' => ['required', 'regex:/^[0-9]+$/'],
                    'count' => ['required', 'regex:/^[0-9]+$/'],
                    'ml' => ['required', 'regex:/^[0-9]+$/'],
                    'img' => ['required', 'mimes:jpeg,png,jpg,gif,svg'],
                    'info' => ['required', 'mimes:jpeg,png,gif'],
                    'type' => ['required', 'regex:/^[0-9]+$/'],
                    'season' => ['required', 'regex:/^[0-9]+$/'],
                ] 
        );
        // 유효성 검사 실패 체크
        if($validator->fails()) {
            throw new MyValidateException('E01');
        }

        // 작성 데이터 생성
        $insertData = $request->all();

        // 새로운 파일 이름 생성 (UUID 사용)
        $imgName = Str::uuid().'.'.$request->file('img')->getClientOriginalExtension();
        $infoName = Str::uuid().'.'.$request->file('info')->getClientOriginalExtension();

        // 파일 저장 경로 설정
        $imgPath = 'img/DB_img/' . $imgName;
        $infoPath = 'img/DB_img/' . $infoName;

        // 파일 이동 및 저장
        $request->file('img')->move(public_path('/img/DB_img'), $imgName);
        $request->file('info')->move(public_path('/img/DB_img'), $infoName);

        // 데이터 준비 및 삽입
        $insertData['img'] ='/' . $imgPath;
        $insertData['info'] = '/' . $infoPath;

        // 인서트 처리
        $productInfo = Product::create($insertData);

        // 레스폰스 처리
        $responseData = [
            'code' => '0'
            ,'msg' => '상품 작성 완료'
            ,'data' => $productInfo->toArray()
        ];
        return response()->json($responseData, 200);
    }

    // 상품 삭제처리
    public function adminProductDeleted($id) {

        Product::destroy($id);

        $responseData = [
            'code' => '0'
            ,'msg' => '삭제 완료'
            ,'data' => $id
        ];
        return response()->json($responseData);
    }

    // 상품 수정
    // 상품 수정 페이지에서 버튼 눌렀을때 상품 테이블에서 데이터 수정
    public function productUpdateSubmit(Request $request) {

        // 리퀘스트 데이터 받기
        $requestData = $request->all();
        
        // 데이터 유효성 검사
        $validator = Validator::make(
            $requestData
            , [
                'name' => ['required', 'regex:/^[가-힣0-9%\s]+$/'],
                'price' => ['required', 'regex:/^[0-9]+$/'],
                'count' => ['required', 'regex:/^[0-9]+$/'],
                'ml' => ['required', 'regex:/^[0-9]+$/'],
                'img' => ['required', 'mimes:jpeg,png,jpg,gif,svg'],
                'info' => ['required', 'mimes:jpeg,png,gif'],
                'type' => ['required', 'regex:/^[0-9]+$/'],
                'season' => ['required', 'regex:/^[0-9]+$/'],
            ]
        );

        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }
        
        // 데이터 생성
        $updateData = Product::find($request->id);

        // 새로운 파일 이름 생성 (UUID 사용)
        $imgName = Str::uuid().'.'.$request->file('img')->getClientOriginalExtension();
        $infoName = Str::uuid().'.'.$request->file('info')->getClientOriginalExtension();

        // 파일 저장 경로 설정
        $imgPath = 'img/DB_img/' . $imgName;
        $infoPath = 'img/DB_img/' . $infoName;

        // 파일 이동 및 저장
        $request->file('img')->move(public_path('/img/DB_img'), $imgName);
        $request->file('info')->move(public_path('/img/DB_img'), $infoName);

        // 데이터 준비 및 삽입
        $updateData['img'] ='/' . $imgPath;
        $updateData['info'] = '/' . $infoPath;

        // 수정 처리
        $updateData->name = $request->name;
        $updateData->price = $request->price;
        $updateData->count = $request->count;
        $updateData->ml = $request->ml;
        $updateData->type = $request->type;
        $updateData->season = $request->season;
        
        // 수정된 데이터 저장
        $updateData->save();

        // 레스폰스 데이터 생성
        $responseData = [
            'code' => '0'
            ,'msg' => '상품 수정 완료'
            ,'data' => $updateData->toArray()
        ];

        return response()->json($responseData, 200);
    }

    // ----------------------- 호경 끝 ---------------------------
}
