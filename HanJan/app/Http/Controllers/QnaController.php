<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\Qna;
use App\Models\Qnaproduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class QnaController extends Controller
{
    // 상품문의 내역 디테일 획득
    public function qnaProductDetailIndex($id) {
        $qnaProductData = Qnaproduct::select('qnaproducts.*', 'products.*','orderproducts.orp_count','completes.created_at as complete')
                                    ->join('orderproducts','orderproducts.orp_id','=','qnaproducts.orp_id')
                                    ->join('completes','orderproducts.orp_id','=','completes.co_id')
                                    ->join('products','orderproducts.p_id','=','products.id')
                                    ->where('qnaproducts.qnp_id', $id)
                                    ->where('qnaproducts.u_id', '=', Auth::id())
                                    ->first();
        
        $responseData = [
                'code' => '0'
                ,'msg' => '초기 상품문의 값 획득 완료'
                ,'data' => $qnaProductData
        ];
        
        return response()->json($responseData, 200);
    }
    
    // 1 :1 문의 내역 디테일 획득
    public function qnaOnebyOneDetailIndex($id) {
        $qnaOneByOneData = Qna::select('qnas.qn_content', 'qnas.qn_answer')
                                ->join('users','users.id','=','qnas.u_id')
                                ->where('qnas.qn_id', $id)
                                ->where('qnas.u_id', '=', Auth::id())
                                ->first();
        
        $responseData = [
                'code' => '0'
                ,'msg' => '초기 1:1 문의 값 획득 완료'
                ,'data' => $qnaOneByOneData
        ];
        
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
            throw new MyValidateException('E01');
        }

        $qnaProductCreateData = new Qnaproduct();
        $qnaProductCreateData->qnp_content = $request->qnp_content;
        $qnaProductCreateData->orp_id = $request->orp_id;
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
                        ->paginate(3);

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
                        ->paginate(3);

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

    // --------------------------------------------------------------------- 관리자 페이지 -------------------------------------------------------------------------
            // ----------------------- 보원 시작 ---------------------------
            // ----------------------- 보원 끝 ---------------------------

            // ----------------------- 성환 시작 ---------------------------
            // ----------------------- 성환 끝 ---------------------------

            // ----------------------- 민서 시작 ---------------------------
            // ----------------------- 민서 끝 ---------------------------

            // ----------------------- 호경 시작 ---------------------------
            // 관리자 페이지 1:1문의 전체 불러오기
            public function adminOneByOneIndex() {
                // $adminUserData = Qna::select('qnas.*', 'users.name')
                //                     ->join('users','qnas.u_id','=','users.id')
                //                     ->paginate(20);
                $adminOneByOneData = Qna::withTrashed() // Qna 모델에서 소프트 삭제된 레코드를 포함
                                    ->select('qnas.*', 'users.name')
                                    ->join('users','qnas.u_id','=','users.id')
                                    ->paginate(20);

                $responseData = [
                    'code' => '0'
                    ,'msg' => '1:1 문의 전체 획득 완료'
                    ,'data' => $adminOneByOneData->toArray()
                ];

                return response()->json($responseData, 200);
            }
            // 관리자 페이지 상품문의 전체 불러오기
            public function adminProductQnaIndex() {
                $adminProductQnaData = Qnaproduct::withTrashed() // Qna 모델에서 소프트 삭제된 레코드를 포함
                                    ->select('qnaproducts.*', 'users.name')
                                    ->join('users','qnaproducts.u_id','=','users.id')
                                    ->paginate(20);

                $responseData = [
                    'code' => '0'
                    ,'msg' => '1:1 문의 전체 획득 완료'
                    ,'data' => $adminProductQnaData->toArray()
                ];

                return response()->json($responseData, 200);
            }
            // ----------------------- 호경 끝 ---------------------------
}