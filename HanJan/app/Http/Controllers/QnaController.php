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
    // 상품문의내역 획득
    public function qnaProductListIndex() {
        $qnaProductListData = Qnaproduct::select('qnaproducts.qnp_content', 'qnaproducts.qnp_answer')
                            ->where('qnaproducts.u_id', '=', Auth::id())
                            ->orderby('created_at', 'DESC')
                            ->limit(1)
                            ->get();
        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $qnaProductListData->toArray()
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
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }

        $qnaProductCreateData = new Qnaproduct();
        $qnaProductCreateData->qnp_content = $request->qnp_content;
        $qnaProductCreateData->p_id = 1; // TODO 추후 p_id가지고 와야함
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
    public function qnaOnebyOneListIndex() {
        $qnaOneByOneListData = Qna::select('qnas.qn_content', 'qnas.qn_answer')
                            ->where('qnas.u_id', '=', Auth::id())
                            ->orderby('created_at', 'DESC')
                            ->limit(1)
                            ->get();
        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $qnaOneByOneListData->toArray()
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
}
