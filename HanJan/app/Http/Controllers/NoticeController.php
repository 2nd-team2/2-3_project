<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NoticeController extends Controller
{
    // 공지사항 획득
    public function noticeIndex() {
        $noticeData = Notice::select('notices.*')
                            ->orderBy('created_at', 'DESC')
                            ->paginate(6);
        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $noticeData->toArray()
        ];

        return response()->json($responseData, 200);
    }

    // 공지사항 디테일 페이지
    public function detailNotice(Request $request) {

        $productData = Notice::select('notices.*')
                        ->where('notices.no_id', $request->id)
                        ->first();
    
        $responseData = [
                'code' => '0'
                ,'msg' => '초기 상품값 획득 완료'
                ,'data' => $productData
        ];
        
        return response()->json($responseData, 200);
    }
    
    // --------------------------------------------------------------------- 관리자 페이지 -------------------------------------------------------------------------

    // 관리자 페이지 공지사항 획득
    public function adminNoticeIndex() {
        $noticeData = Notice::withTrashed()
                            ->select('notices.*', 'admins.account')
                            ->join('admins','notices.a_id','=','admins.id')
                            ->orderBy('notices.deleted_at', 'ASC')
                            ->orderBy('notices.created_at', 'DESC')
                            ->paginate(15);
        $responseData = [
            'code' => '0'
            ,'msg' => '공지사항 획득 완료'
            ,'data' => $noticeData->toArray()
        ];

        return response()->json($responseData, 200);
    }

    // 공지사항 작성
    public function noticeCreate(Request $request) {
        $validator = Validator::make(
            $request->only('no_title', 'no_content')
            ,[
                'no_title'=> ['required', 'max:50', 'regex: /^[0-9가-힣a-zA-Z\s.,:?!@#$%^&*]+$/u'],
                'no_content'=> ['required', 'max:1000', 'regex: /^[0-9가-힣a-zA-Z\s.,:?!@#$%^&*]+$/u']
            ]
        );
        // 유효성 검사 실패 체크
        if($validator->fails()) {
            throw new MyValidateException('E01');
        }

        $noticeCreateData = new Notice();
        $noticeCreateData->no_title = $request->no_title;
        $noticeCreateData->no_content = $request->no_content;
        $noticeCreateData->a_id = Auth::id();
        $noticeCreateData->save();

        // 레스폰스 처리
        $responseData = [
            'code' => '0'
            ,'msg' => '글 작성 완료'
            ,'data' => $noticeCreateData->toArray()
        ];
        return response()->json($responseData, 200);
    }

    // 공지사항 삭제처리
    public function adminNoticeDeleted($no_id) {

        Notice::destroy($no_id);

        $responseData = [
            'code' => '0'
            ,'msg' => '삭제 완료'
            ,'data' => $no_id
        ];
        return response()->json($responseData);
    }

    // 공지사항 수정
    // 공지사항 수정 페이지에서 버튼 눌렀을때 공지사항 테이블에서 데이터 수정
    public function noticeUpdateSubmit(Request $request) {

        // 리퀘스트 데이터 받기
        $requestData = $request->all();
        
        // 데이터 유효성 검사
        $validator = Validator::make(
            $requestData
            , [
                'no_title' => ['required', 'max:50', 'regex: /^[0-9ㄱ-ㅎㅏ-ㅣ가-힣a-zA-Z\s.,:?!@#$%^&*]+$/u']
                ,'no_content' => ['required', 'max:1000', 'regex: /^[0-9ㄱ-ㅎㅏ-ㅣ가-힣a-zA-Z\s.,:?!@#$%^&*]+$/u']
            ]
        );

        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }
        
        // 데이터 생성
        $updateData = Notice::find($request->no_id);

        // 수정 처리
        $updateData->no_title = $request->no_title;
        $updateData->no_content = $request->no_content;
        
        // 수정된 데이터 저장
        $updateData->save();

        // 레스폰스 데이터 생성
        $responseData = [
            'code' => '0'
            ,'msg' => '공지사항 수정 완료'
            ,'data' => $updateData->toArray()
        ];

        return response()->json($responseData, 200);
    }
}
