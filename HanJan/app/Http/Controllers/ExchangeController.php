<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\Exchange;
use App\Models\Orderproduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ExchangeController extends Controller
{
    public function exchangeProduct($id) {
        
        $exchangeData = Orderproduct::select(
            'orderproducts.orp_id'
            ,'orderproducts.orp_count as orpCount'
            ,'orderproducts.created_at as orpCre'
            ,'completes.created_at as comCre'
            ,'exchanges.created_at as exCre'
            ,'exchanges.ex_flg'
            ,'products.*')
            ->join('exchanges','orderproducts.orp_id', '=', 'exchanges.orp_id')
            ->join('products','orderproducts.p_id','=','products.id')
            ->join('completes', 'orderproducts.orp_id', '=', 'completes.orp_id')
            ->where('orderproducts.orp_id','=', $id)
            ->first();

        $responseData = [
            'code' => '0'
            ,'msg' => '초기 장바구니 상품 획득 완료'
            ,'data' => $exchangeData->toArray()
        ];
        
        return response()->json($responseData, 200);
        
    }

    // 교환 및 반품 신청 처리
    public function exchage(Request $request) {

        // 리퀘스트 데이터 받기
        $requestData = [
            'ex_name' => $request->ex_name
            ,'ex_tel' => $request->ex_tel
            ,'ex_addr' => $request->ex_addr
            ,'ex_det_addr' => $request->ex_det_addr
            ,'ex_post' => $request->ex_post
            ,'ex_reason' => (int)$request->ex_reason
            ,'ex_reason_etc' => $request->ex_reason_etc
        ];

        // 데이터 유효성 검사
        $rules = [
            'ex_name' => ['required'],
            'ex_tel' => ['required'],
            'ex_addr' => ['required'],
            'ex_det_addr' => ['required'],
            'ex_post' => ['required'],
            'ex_reason' => ['required', 'regex:/^[0-4]+$/']
        ];
        // ex_reason이 4인 경우에만 ex_reason_etc를 추가
        if ((int)$request->ex_reason === 4) {
            $rules['ex_reason_etc'] = ['required', 'max:500', 'regex:/^[0-9ㄱ-ㅎㅏ-ㅣ가-힣a-zA-Z\s.,:?!@#$%^&*]+$/u'];
        }

        $validator = Validator::make($requestData, $rules);

        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }

        // 주문 데이터 생성
        $exchangData = $request->only([
            'ex_name',
            'ex_tel',
            'ex_addr',
            'ex_det_addr',
            'ex_post',
            'ex_reason'
        ]);
        // ex_reason이 4인 경우에만 ex_reason_etc를 추가
        if ((int)$request->ex_reason === 4) {
            $exchangData['ex_reason_etc'] = $request->ex_reason_etc;
        } else {
            $exchangData['ex_reason_etc'] = null;
        }
        $exchangData['u_id'] = Auth::id();
        $exchangData['orp_id'] = $request->orp_id;
        $exchangData['ex_flg'] = 1;
        $exchangData['created_at'] = Carbon::now();

        // 작성 저장 처리
        $exchangeCreate = Exchange::updateOrCreate(['orp_id' => $request->orp_id], $exchangData);
    
        // 레스폰스 데이터 생성
        $responseData = [
            'code' => '0',
            'msg' => '주문 완료',
            'data' => $exchangeCreate
        ];

        return response()->json($responseData, 200);

    }

    // --------------------------------------------------------------------- 관리자 페이지 -------------------------------------------------------------------------
    // 관리자 페이지 교환 및 반품 획득
    public function adminExchangeIndex() {
        $ExchangeData = Exchange::withTrashed()
                            ->select('exchanges.*'
                                ,'orderproducts.orp_count'
                                ,'orderproducts.or_id'
                                ,DB::raw("DATE_FORMAT(orderproducts.created_at, '%Y-%m-%d') as orpCre")
                                ,'products.price')
                            ->join('orderproducts', 'orderproducts.orp_id', '=', 'exchanges.orp_id')
                            ->join('products', 'products.id', '=', 'orderproducts.p_id')
                            // ->where('orderproducts.or_id', '=', 'orders.or_id')
                            ->whereNotNull('ex_reason')
                            ->where('ex_flg', '!=', '3')
                            // ->orderBy('ex_flg', 'ASC')
                            ->orderBy('exchanges.created_at', 'DESC')
                            ->paginate(15);
        $responseData = [
            'code' => '0'
            ,'msg' => '교환 및 반품 목록 획득 완료'
            ,'data' => $ExchangeData->toArray()
        ];

        return response()->json($responseData, 200);
    }

    // 접수완료 클릭시 교환 및 반품 진행중으로 변경
    public function takeOver(Request $request) {

        $updateData = Exchange::find($request->ex_id);

        // 수정 처리
        $updateData['ex_flg'] = 1;
        
        // 수정된 데이터 저장
        $updateData->save();

        // 레스폰스 데이터 생성
        $responseData = [
            'code' => '0'
            ,'msg' => '접수 완료'
            ,'data' => $updateData->toArray()
        ];

        return response()->json($responseData, 200);
    }

    // 접수완료 클릭시 교환 및 반품 진행중으로 변경
    public function payCancel(Request $request) {

        $updateData = Exchange::find($request->ex_id);

        // 수정 처리
        $updateData['ex_flg'] = 2;
        
        // 수정된 데이터 저장
        $updateData->save();

        // 레스폰스 데이터 생성
        $responseData = [
            'code' => '0'
            ,'msg' => '결제 취소 완료'
            ,'data' => $updateData->toArray()
        ];

        return response()->json($responseData, 200);
    }

    // 교환 및 반품 디테일 페이지
    public function adminExchangeDetail(Request $request) {

        $ExchangeData = Exchange::select('exchanges.*')
                        ->where('exchanges.ex_id', $request->id)
                        ->first();
    
        $responseData = [
                'code' => '0'
                ,'msg' => '교환 및 반품 데이터 획득 완료'
                ,'data' => $ExchangeData
        ];
        
        return response()->json($responseData, 200);
    }
}
