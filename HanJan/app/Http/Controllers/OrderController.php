<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\Bag;
use App\Models\Complete;
use App\Models\Exchange;
use App\Models\Order;
use App\Models\Orderproduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    // 트랜잭션으로 아래 함수를 병합 > 일관성을 유지하기 위해서
    // orderComplete, orderProductComlete, orderComEx, bagsCompleteDelete

    public function orderTrans(Request $request) {
        // JSON 데이터를 배열 또는 객체로 변환
        $data = $request->json()->all();
        
        // 트랜잭션 처리
        DB::beginTransaction();

        try {

            // ************************************************
            // 1. orderComplete 처리
            // 주문 데이터는 하나만 저장해도 되기 때문에 먼저 실행
            $orderItem = $data['data'][0];
            
            
            // 리퀘스트 데이터 받기
            $requestData = [
                'or_buy_name' => $orderItem['or_buy_name'],
                'or_buy_tel' => $orderItem['or_buy_tel'],
                'or_get_name' => $orderItem['or_get_name'],
                'or_get_tel' => $orderItem['or_get_tel'],
                'or_get_addr' => $orderItem['or_get_addr'],
                'or_get_post' => $orderItem['or_get_post'],
                'or_get_det_addr' => $orderItem['or_get_det_addr'],
                'or_sum' => $orderItem['or_sum']
            ];

            // 데이터 유효성 검사
            $validator = Validator::make(
                $requestData
                , [
                    'or_buy_name' => ['required', 'regex:/^[a-zA-Z가-힣]+$/u']
                    ,'or_buy_tel' => ['required', 'min:10','max:11', 'regex:/^[0-9]+$/']
                    ,'or_get_name' => ['required', 'regex:/^[a-zA-Z가-힣]+$/u']
                    ,'or_get_tel' => ['required', 'min:10','max:11', 'regex:/^[0-9]+$/']
                    ,'or_get_addr' => ['required']
                    ,'or_get_post' => ['required']
                    ,'or_get_det_addr' => ['required']
                    ,'or_sum' => ['required', 'regex:/^[0-9]+$/']
                ]
            );        

            // 유효성 검사 실패 체크
            if($validator->fails()) {
                Log::debug('유효성 검사 실패', $validator->errors()->toArray());
                throw new MyValidateException('E01');
            }    

            // 주문 데이터 생성
            $orderData = $orderItem;
            
            // 작성 데이터 입력 처리
            $orderData['u_id'] = Auth::id();
            $orderData['or_buy_name'] = $orderItem['or_buy_name'];
            $orderData['or_buy_tel'] = $orderItem['or_buy_tel']; 
            $orderData['or_get_name'] = $orderItem['or_get_name'];
            $orderData['or_get_tel'] = $orderItem['or_get_tel'];
            $orderData['or_get_addr'] = $orderItem['or_get_addr'];
            $orderData['or_get_post'] = $orderItem['or_get_post'];
            $orderData['or_get_det_addr'] = $orderItem['or_get_det_addr'];
            $orderData['or_sum'] = $orderItem['or_sum'];

            // 작성 저장 처리
            $orderCreate = Order::create($orderData);        
            

            // *******************************************************
            // 이외 데이터는 여러개 저장해야되므로 모든 데이터 다 들고 오기

            $orderItems = $data['data'];
            $savedOrderProducts = [];
            $saveOrderComExs = [];
            $deletedBags = [];

            foreach($orderItems as $item) {
                // ****************************
                // 2. orderProductComlete 처리

                $orderProductData = [
                    // 'u_id' => Auth::id(),
                    'or_id' => $orderCreate->or_id
                    ,'p_id' => $item['p_id']
                    ,'orp_count' => $item['ba_count']
                ];

                // 작성처리
                $orderProductCreate = Orderproduct::create($orderProductData);
                // 작성한 데이터 배열로 만들기
                $savedOrderProducts[] = $orderProductCreate;

                // *****************************************************
                // 3. orderComEx 처리 (구매확정, 교환 및 반품 데이터 생성)
                
                // 구매확정 데이터 입력
                $completeData = [
                    'orp_id' => $orderProductCreate->orp_id
                    ,'co_flg' => '0'
                ];
                // 작성처리
                $completeCreateData = Complete::create($completeData);
                
                // 교환 및 반품 데이터 입력
                $exchangeData = [
                    'orp_id' => $orderProductCreate->orp_id
                    ,'u_id' => Auth::id()
                    ,'ex_flg' => '0'
                ];
                // 작성처리
                $exchangeCreateData = Exchange::create($exchangeData);
                
                // 작성한 데이터 배열로 만들기
                $saveOrderComExs[] = [
                    'complete' => $completeCreateData,
                    'exchange' => $exchangeCreateData
                ];
                
                // *****************************************************
                // 4. bagsCompleteDelete 처리 (장바구니에서 온 데이터만 삭제)
                if ($item['buy_type'] === 'bags') {

                    $ba_id = $item['ba_id'];
                    $p_id = $item['p_id'];
                    $ba_count = $item['ba_count'];


                    $bag = Bag::find($ba_id);
                    if ($bag) {
                        $bag->delete(); // 소프트 삭제
                        $deletedBags[] = $ba_id;
                    }
            
                    // Products 테이블에서 ba_count 빼기
                    $product = Product::find($p_id);
                    if ($product) {
                        // 현재 ba_count를 가져온 후 빼고 저장
                        $currentCount = $product->count;
                        $product->count = $currentCount - $ba_count;
                        $product->save();
                    }
                }
                else {
                    Log::debug($item['buy_type']);
                }
            
            }


            DB::commit();
 
            // 레스폰스 데이터 생성
            $responseData = [
                'code' => '0'
                ,'msg' => '주문 완료'
                ,'orderData' => $orderCreate
                ,'orderProductData' => $savedOrderProducts
                ,'orderComExData' => $saveOrderComExs
                ,'orderDeleteData' => $deletedBags
            ];

            Log::debug($responseData);

            return response()->json($responseData, 200);


        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('결제 처리 오류: ' . $th->getMessage());
    
            return response()->json(['success' => false, 'message' => '결제 처리 중 오류가 발생했습니다.'], 500);
        }


  
    }



// *******************아래 트랜잭션으로 진행하기 위해 주석처리****************************

    // public function orderComplete(Request $request) {

    //     // 리퀘스트 데이터 받기
    //     $requestData = [
    //         'or_buy_name' => $request->or_buy_name
    //         ,'or_buy_tel' => $request->or_buy_tel
    //         ,'or_get_name' => $request->or_get_name
    //         ,'or_get_tel' => $request->or_get_tel
    //         ,'or_get_addr' => $request->or_get_addr
    //         ,'or_get_post' => $request->or_get_post
    //         ,'or_get_det_addr' => $request->or_get_det_addr
    //         ,'or_sum' => $request->or_sum
    //     ];

    //     // 데이터 유효성 검사
    //     $validator = Validator::make(
    //         $requestData
    //         , [
    //             'or_buy_name' => ['required', 'regex:/^[a-zA-Z가-힣]+$/u']
    //             ,'or_buy_tel' => ['required', 'min:10','max:11', 'regex:/^[0-9]+$/']
    //             ,'or_get_name' => ['required', 'regex:/^[a-zA-Z가-힣]+$/u']
    //             ,'or_get_tel' => ['required', 'min:10','max:11', 'regex:/^[0-9]+$/']
    //             ,'or_get_addr' => ['required']
    //             ,'or_get_post' => ['required']
    //             ,'or_get_det_addr' => ['required']
    //             ,'or_sum' => ['required', 'regex:/^[0-9]+$/']
    //         ]
    //     );

    //     // 유효성 검사 실패 체크
    //     if($validator->fails()) {
    //         Log::debug('유효성 검사 실패', $validator->errors()->toArray());
    //         throw new MyValidateException('E01');
    //     }

    //     // 주문 데이터 생성
    //     $orderData = $request->all();
        
    //     // 작성 데이터 입력 처리
    //     $orderData['u_id'] = Auth::id();
    //     $orderData['or_buy_name'] = $request->or_buy_name;
    //     $orderData['or_buy_tel'] = $request->or_buy_tel; 
    //     $orderData['or_get_name'] = $request->or_get_name;
    //     $orderData['or_get_tel'] = $request->or_get_tel;
    //     $orderData['or_get_addr'] = $request->or_get_addr;
    //     $orderData['or_get_post'] = $request->or_get_post;
    //     $orderData['or_get_det_addr'] = $request->or_get_det_addr;
    //     $orderData['or_sum'] = $request->or_sum;

    //     // 작성 저장 처리
    //     $orderCreate = Order::create($orderData);

    //     // 레스폰스 데이터 생성
    //     $responseData = [
    //         'code' => '0'
    //         ,'msg' => '주문 완료'
    //         ,'data' => $orderCreate
    //     ];

    //     return response()->json($responseData, 200);
    // }


    // // 주문 상품 테이블 작성
    // public function orderProductComlete($or_id, Request $request){

    //     $orderProducts = $request->all();
    //     $savedOrderProducts = [];

    //     // 작성 데이터 입력 처리
    //     foreach ($orderProducts as $orderProduct) {
    //         $orderProductData = [
    //             // 'u_id' => Auth::id(),
    //             'or_id' => $or_id
    //             ,'p_id' => $orderProduct['p_id']
    //             ,'orp_count' => $orderProduct['ba_count']
    //         ];
    //         // 작성처리
    //         $savedOrderCreate = Orderproduct::create($orderProductData);

    //         $savedOrderProducts[] = $savedOrderCreate;

    //     }

    //     // 레스폰스 데이터 생성
    //     $responseData = [
    //         'code' => '0'
    //         ,'msg' => '주문 완료'
    //         ,'data' => $savedOrderProducts
    //     ];

    //     return response()->json($responseData, 200);
        
    // }

    // // 구매확정, 교환 및 반품 테이블 작성
    // public function orderComEx($orp_id) {

    //     $saveOrderComExs = [];

    //     // 구매확정 데이터 입력
    //     $completeData = [
    //         'orp_id' => $orp_id
    //         ,'co_flg' => '0'
    //     ];
    //     // 작성처리
    //     $completeCreateData = Complete::create($completeData);
        
    //     // 교환 및 반품 데이터 입력
    //     $exchangeData = [
    //         'orp_id' => $orp_id
    //         ,'u_id' => Auth::id()
    //         ,'ex_flg' => '0'
    //     ];
    //     // 작성처리
    //     $exchangeCreateData = Exchange::create($exchangeData);

    //     // 배열 만들기
    //     $saveOrderComExs[] = [
    //         'complete' => $completeCreateData,
    //         'exchange' => $exchangeCreateData
    //     ];

    //     // 레스폰스 데이터 생성
    //     $responseData = [
    //         'code' => '0'
    //         ,'msg' => '주문 완료'
    //         ,'data' => $saveOrderComExs
    //     ];

    //     return response()->json($responseData, 200);
    // }


    
    // // 장바구니 테이블 삭제
    // public function bagsCompleteDelete(Request $request){

    //     $orderDeleteProducts = $request->all();
    //     $deletedBags = [];
        
    //     foreach ( $orderDeleteProducts as $bagProductData) {

    //         $ba_id = $bagProductData['ba_id'];
    //         $p_id = $bagProductData['p_id'];
    //         $ba_count = $bagProductData['ba_count'];


    //         $bag = Bag::find($ba_id);
    //         if ($bag) {
    //             $bag->delete(); // 소프트 삭제
    //             $deletedBags[] = $ba_id;
    //         }
    
    //         // Products 테이블에서 ba_count 빼기
    //         $product = Product::find($p_id);
    //         if ($product) {
    //             // 현재 ba_count를 가져온 후 빼고 저장
    //             $currentCount = $product->count;
    //             $product->count = $currentCount - $ba_count;
    //             $product->save();
    //         }

    //     }

    //     $responseData = [
    //         'code' => '0'
    //         ,'msg' => '주문 완료 장바구니 삭제 완료'
    //         ,'data' => $deletedBags
    //     ];

    //     return response()->json($responseData);
    // }
    
    // --------------------------------------------------------------------- 관리자 페이지 -------------------------------------------------------------------------
    // 관리자 페이지 주문목록 획득
    public function adminOrderIndex() {
        $orderData = Order::withTrashed()
                            ->select('orders.*', 'users.name', 'users.tel')
                            ->join('users','orders.u_id','=','users.id')
                            ->orderBy('orders.created_at', 'DESC')
                            ->paginate(15);
        $responseData = [
            'code' => '0'
            ,'msg' => '주문목록 획득 완료'
            ,'data' => $orderData->toArray()
        ];

        return response()->json($responseData, 200);
    }

    // 관리자 페이지 매출 통계 획득
    public function salesStatistics() {
        $dailySalesData = DB::table('orders')
                            ->select(
                                DB::raw('CAST(created_at AS DATE) as daily'),
                                DB::raw('SUM(or_sum) as daily_sales')
                            )
                            ->groupBy(DB::raw('CAST(created_at AS DATE)'))
                            ->havingRaw('SUM(or_sum) > 0')
                            ->orderBy(DB::raw('CAST(created_at AS DATE)'), 'ASC')
                            ->get();

        $weeklySalesData = DB::table('orders')
                            ->select(
                                DB::raw('YEAR(created_at) as year'),
                                DB::raw('WEEK(created_at) as weekly'),
                                DB::raw('SUM(or_sum) as weekly_sales')
                            )
                            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('WEEK(created_at)'))
                            ->havingRaw('SUM(or_sum) > 0')
                            ->orderBy(DB::raw('YEAR(created_at)'), 'asc')
                            ->orderBy(DB::raw('WEEK(created_at)'), 'asc')
                            ->get();

        $monthSalesData = DB::table('orders')
                            ->select(
                                DB::raw('YEAR(created_at) as year'),
                                DB::raw('MONTH(created_at) as month'),
                                DB::raw('SUM(or_sum) as monthly_sales')
                            )
                            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                            ->havingRaw('SUM(or_sum) > 0')
                            ->orderBy(DB::raw('YEAR(created_at)'), 'asc')
                            ->orderBy(DB::raw('MONTH(created_at)'), 'asc')
                            ->get();

        $yearSalesData = DB::table('orders')
                            ->select(
                                DB::raw('YEAR(created_at) as year'),
                                DB::raw('SUM(or_sum) as yearly_sales')
                            )
                            ->groupBy(DB::raw('YEAR(created_at)'))
                            ->havingRaw('SUM(or_sum) > 0')
                            ->orderBy(DB::raw('YEAR(created_at)'), 'ASC')
                            ->get();

        $responseData = [
            'code' => '0'
            ,'msg' => '주문목록 획득 완료'
            ,'data' => [
                'daily' =>$dailySalesData->toArray() 
                ,'weekly' =>$weeklySalesData->toArray() 
                ,'month' =>$monthSalesData->toArray() 
                ,'year' =>$yearSalesData->toArray() 
            ]
        ];

        return response()->json($responseData, 200);
    }


}
