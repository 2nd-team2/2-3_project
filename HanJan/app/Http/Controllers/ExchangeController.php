<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\Exchange;
use App\Models\Orderproduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ExchangeController extends Controller
{
    public function exchangeProduct($id) {

        $exchangeData = Orderproduct::select(
                        'orderproducts.orp_id as orpId'
                        ,'orderproducts.orp_count as orpCount'
                        ,'orderproducts.created_at as orpCre'
                        ,'completes.created_at as comCre'
                        ,'products.*')
                        ->join('products','orderproducts.p_id','=','products.id')
                        ->join('completes', 'orderproducts.orp_id', '=', 'completes.orp_id')
                        ->where('products.id','=', $id)
                        ->first();

        $responseData = [
            'code' => '0'
            ,'msg' => '초기 장바구니 상품 획득 완료'
            ,'data' => $exchangeData->toArray()
        ];
        
        return response()->json($responseData, 200);
        
    }

    public function exchage(Request $request) {

        // 리퀘스트 데이터 받기
        $requestData = [
            'ex_addr' => $request->ex_addr
            ,'ex_det_addr' => $request->ex_det_addr
            ,'ex_post' => $request->or_get_tel
            ,'ex_reason' => (int)$request->ex_reason
        ];

        // 데이터 유효성 검사
        $validator = Validator::make(
            $requestData
            , [
                'ex_addr' => ['required']
                ,'ex_det_addr' => ['required']
                ,'ex_post' => ['required']
                ,'ex_reason' => ['required']
            ]
        );

        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }

        // 주문 데이터 생성
        $exchangData = $request->all();
        
        // 작성 데이터 입력 처리
        $exchangData['u_id'] = Auth::id();
        $exchangData['orp_id'] = $request->orpId;
        $exchangData['ex_addr'] = $request->ex_addr; 
        $exchangData['ex_det_addr'] = $request->ex_det_addr;
        $exchangData['ex_post'] = $request->ex_post;
        $exchangData['ex_reason'] = (int)$request->ex_reason;
        $exchangData['ex_flg'] = '1';


        // 작성 저장 처리
        $exchangeCreate = Exchange::create($exchangData);

        // 레스폰스 데이터 생성
        $responseData = [
            'code' => '0'
            ,'msg' => '주문 완료'
            ,'data' => $exchangeCreate
        ];

        return response()->json($responseData, 200);

    }
}
