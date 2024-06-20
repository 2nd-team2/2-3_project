<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function orderComplete(Request $request) {

        Log::debug($request); // TODO : 삭제
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
        Log::debug($orderData); // TODO : 삭제
        
        // 작성 처리
        $orderData['u_id'] = Auth::id();
        $orderData['or_buy_name'] = $request->or_buy_name;
        $orderData['or_buy_tel'] = $request->or_buy_tel; 
        $orderData['or_get_name'] = $request->or_get_name;
        $orderData['or_get_tel'] = $request->or_get_tel;
        $orderData['or_get_addr'] = $request->or_get_addr;
        $orderData['or_get_post'] = $request->or_get_post;
        $orderData['or_get_det_addr'] = $request->or_get_det_addr;
        $orderData['or_sum'] = $request->or_sum;


        // 작성 처리
        // $orderCreate = Order::create($orderData);

        // 레스폰스 데이터 생성
        // $responseData = [
        //     'code' => '0'
        //     ,'msg' => '주문 완료'
        //     ,'data' => $orderCreate
        // ];

        // return response()->json($responseData, 200);
    }
}
