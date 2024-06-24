<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\Bag;
use App\Models\Order;
use App\Models\Orderproduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function orderComplete(Request $request) {

        // 리퀘스트 데이터 받기
        $requestData = [
            'or_buy_name' => $request->or_buy_name
            ,'or_buy_tel' => $request->or_buy_tel
            ,'or_get_name' => $request->or_get_name
            ,'or_get_tel' => $request->or_get_tel
            ,'or_get_addr' => $request->or_get_addr
            ,'or_get_post' => $request->or_get_post
            ,'or_get_det_addr' => $request->or_get_det_addr
            ,'or_sum' => $request->or_sum
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
        $orderData = $request->all();
        
        // 작성 데이터 입력 처리
        $orderData['u_id'] = Auth::id();
        $orderData['or_buy_name'] = $request->or_buy_name;
        $orderData['or_buy_tel'] = $request->or_buy_tel; 
        $orderData['or_get_name'] = $request->or_get_name;
        $orderData['or_get_tel'] = $request->or_get_tel;
        $orderData['or_get_addr'] = $request->or_get_addr;
        $orderData['or_get_post'] = $request->or_get_post;
        $orderData['or_get_det_addr'] = $request->or_get_det_addr;
        $orderData['or_sum'] = $request->or_sum;

        // 작성 저장 처리
        $orderCreate = Order::create($orderData);

        // 레스폰스 데이터 생성
        $responseData = [
            'code' => '0'
            ,'msg' => '주문 완료'
            ,'data' => $orderCreate
        ];

        return response()->json($responseData, 200);
    }


    // 주문 상품 테이블 작성
    public function orderProductComlete($or_id, Request $request){

        $orderProducts = $request->all();
        $savedOrderProducts = [];

        // 작성 데이터 입력 처리
        foreach ($orderProducts as $orderProduct) {
            $orderProductData = [
                'u_id' => Auth::id()
                ,'or_id' => $or_id
                ,'p_id' => $orderProduct['p_id']
                ,'orp_count' => $orderProduct['ba_count']
            ];
            // 작성처리
            $orderProductData = Orderproduct::create($orderProductData);

            $savedOrderProducts[] = $savedOrderProducts;
        }

        // 레스폰스 데이터 생성
        $responseData = [
            'code' => '0'
            ,'msg' => '주문 완료'
            ,'data' => $savedOrderProducts
        ];

        return response()->json($responseData, 200);

        
    }
    
    // 장바구니 테이블 삭제
    public function bagsCompleteDelete(Request $request){

        $orderDeleteProducts = $request->all();
        $deletedBags = [];
        
        foreach ( $orderDeleteProducts as $bagProductData) {

            $ba_id = $bagProductData['ba_id'];

            Bag::destroy($ba_id);
            $deletedBags[] = $ba_id;

        }

        $responseData = [
            'code' => '0'
            ,'msg' => '주문 완료 장바구니 삭제 완료'
            ,'data' => $deletedBags
        ];

        return response()->json($responseData);
    }
    
}
