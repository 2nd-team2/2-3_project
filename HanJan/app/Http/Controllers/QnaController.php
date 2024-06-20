<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\Orderproduct;
use App\Models\Qna;
use App\Models\Qnaproduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class QnaController extends Controller
{
    // 상품문의내역 획득
    // public function qnaProductListIndex() {
    //     $qnaProductListData = Qnaproduct::select('qnaproducts.qnp_content', 'qnaproducts.qnp_answer')
    //                         ->where('qnaproducts.u_id', '=', Auth::id())
    //                         ->orderby('created_at', 'DESC')
    //                         ->limit(1)
    //                         ->get();
    //     $responseData = [
    //         'code' => '0'
    //         ,'msg' => '게시글 획득 완료'
    //         ,'data' => $qnaProductListData->toArray()
    //     ];

    //     return response()->json($responseData, 200);
    // }
    
    // 상품문의 내역 디테일 획득
    public function qnaProductListIndex($id) {
        
        $qnaProductData = Qnaproduct::select('qnaproducts.*', 'products.*','orderproducts.orp_count','completes.created_at as complete')
                                    ->join('orderproducts','orderproducts.orp_id','=','qnaproducts.orp_id')
                                    ->join('completes','orderproducts.orp_id','=','completes.co_id')
                                    ->join('products','orderproducts.p_id','=','products.id')
                                    ->where('qnaproducts.qnp_id', $id)
                                    ->first();
        
        Log::debug('상품문의내역 pk : ' . $id);
        Log::debug('공지사항 데이터:', $qnaProductData->toArray());
    
        $responseData = [
                'code' => '0'
                ,'msg' => '초기 상품문의 값 획득 완료'
                ,'data' => $qnaProductData
        ];
        Log::debug($responseData);
        
        return response()->json($responseData, 200);
    }
    

    // 상품문의 작성
    public function qnaProductCreate(Request $request) {
        $validator = Validator::make(
            $request->only('qnp_content')
            ,[
                'qnp_content'=> ['required']
            ]
        );
        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }

        $qnaProductCreateData = new Qnaproduct();
        $qnaProductCreateData->qnp_content = $request->qnp_content;
        $qnaProductCreateData->orp_id = 1; // TODO 추후 p_id가지고 와야함
        $qnaProductCreateData->u_id = Auth::id();
        $qnaProductCreateData->save();

        // 레스폰스 처리
        $responseData = [
            'code' => '0'
            ,'msg' => '글 작성 완료'
            ,'data' => $qnaProductCreateData->toArray()
        ];
        return response()->json($responseData, 200);
    }

    // 1 :1 문의내역 획득
    // public function qnaOnebyOneListIndex() {
    //     $qnaOneByOneListData = Qna::select('qnas.qn_content', 'qnas.qn_answer')
    //                         ->where('qnas.u_id', '=', Auth::id())
    //                         ->orderby('created_at', 'DESC')
    //                         ->limit(1)
    //                         ->get();
    //     $responseData = [
    //         'code' => '0'
    //         ,'msg' => '게시글 획득 완료'
    //         ,'data' => $qnaOneByOneListData->toArray()
    //     ];

    //     return response()->json($responseData, 200);
    // }

    // 1 :1 문의 내역 디테일 획득
    public function qnaOnebyOneListIndex($id) {
        
        $qnaOnByeOneData = Qna::select('qnas.qn_content', 'qnas.qn_answer')
                                ->where('qnas.u_id', '=', Auth::id())
                                ->orderby('created_at', 'DESC')
                                ->get();
        
        Log::debug('1:1 문의 내역 pk : ' . $id);
        Log::debug('공지사항 데이터:', $qnaOnByeOneData->toArray());
    
        $responseData = [
                'code' => '0'
                ,'msg' => '초기 1:1 문의 값 획득 완료'
                ,'data' => $qnaOnByeOneData
        ];
        Log::debug($responseData);
        
        return response()->json($responseData, 200);
    }

    // 1:1문의 작성
    public function qnaOnebyOneCreate(Request $request) {
        $validator = Validator::make(
            $request->only('qn_content')
            ,[
                'qn_content'=> ['required']
            ]
        );
        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }

        $qnaOneByOneCreateData = new Qna();
        $qnaOneByOneCreateData->qn_content = $request->qn_content;
        $qnaOneByOneCreateData->u_id = Auth::id();
        $qnaOneByOneCreateData->save();

        // 레스폰스 처리
        $responseData = [
            'code' => '0'
            ,'msg' => '글 작성 완료'
            ,'data' => $qnaOneByOneCreateData->toArray()
        ];
        return response()->json($responseData, 200);
    }


// ------------------------------------------------------

    // 마이페이지 상품 문의목록
    public function productAsk() {
        $askData = Qnaproduct::select('users.id','qnaproducts.*')
                        ->join('users','qnaproducts.u_id','=','users.id')
                        ->where('qnaproducts.u_id', '=', Auth::id())
                        ->where('qnaproducts.deleted_at', '=', null)
                        ->orderBy('qnaproducts.created_at','DESC')
                        ->orderBy('qnaproducts.qnp_id','DESC')
                        ->limit(3)
                        ->get();

        $responseData = [
            'code' => '0'
            ,'msg' => '문의목록 획득 완료'
            ,'data' => $askData->toArray()
        ];

        return response()->json($responseData, 200);
    }

    // 상품 문의목록 삭제처리
    public function productAskDelete($qnp_id) {

        Qnaproduct::destroy($qnp_id);

        $responseData = [
            'code' => '0'
            ,'msg' => '삭제 완료'
            ,'data' => $qnp_id
        ];
        
        return response()->json($responseData);
    }

    // 마이페이지 1:1문의목록
    public function askData() {
        $askData = Qna::select('users.id','qnas.*')
                        ->join('users','qnas.u_id','=','users.id')
                        ->where('qnas.u_id', '=', Auth::id())
                        ->where('qnas.deleted_at', '=', null)
                        ->orderBy('qnas.created_at','DESC')
                        ->orderBy('qnas.qn_id','DESC')
                        ->limit(3)
                        ->get();

        $responseData = [
            'code' => '0'
            ,'msg' => '1:1 문의목록 획득 완료'
            ,'data' => $askData->toArray()
        ];

        return response()->json($responseData, 200);
    }

    // 1:1 문의목록 삭제처리
    public function askDelete($qn_id) {

        Qna::destroy($qn_id);

        $responseData = [
            'code' => '0'
            ,'msg' => '삭제 완료'
            ,'data' => $qn_id
        ];
        return response()->json($responseData);
    }
}