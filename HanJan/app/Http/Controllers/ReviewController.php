<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function reviewIndex() {
    // reviews(리뷰)테이블에서
    // 로그인 되어있는 아이디와 일치하는 u_id의 초기 게시글 획득
        // $reviewData = Review::select('reviews.*','user.id','products.*','orderproducts.orp_count')
        $reviewData = Review::select('reviews.*','users.id','products.*')
                        ->join('users','reviews.u_id','=','users.id')
                        ->join('products','reviews.p_id','=','products.id')

                        // ->join('orderproducts','products.id','=','orderproducts.p_id')

                        ->where('reviews.u_id', '=', Auth::id())
                        ->where('reviews.deleted_at', '=', null)
                        ->orderBy('reviews.created_at','DESC')
                        ->orderBy('reviews.re_id','DESC')
                        ->limit(3)
                        ->get();

        $responseData = [
            'code' => '0'
            ,'msg' => '초기 리뷰 획득 완료'
            ,'data' => $reviewData->toArray()
        ];
    
        return response()->json($responseData, 200);

    }

    // 리뷰 삭제
    // 리뷰관리 페이지에서 휴지통 버튼 눌렀을때 reviews(리뷰) 테이블에서 삭제 처리
    public function reviewDelete($re_id) {

        Review::destroy($re_id);
        
        $responseData = [
            'code' => '0'
            ,'msg' => '리뷰 삭제 완료'
            ,'data' => $re_id
        ];

        return response()->json($responseData);
    }

    // 리뷰 작성
    // 리뷰작성 페이지에서 버튼 눌렀을 때 reviews(리뷰) 테이블에서 데이터 저장
    public function reviewCreateSubmit(Request $request) {

        // 리퀘스트 데이터 받기
        $requestData = [
            're_id' => $request->re_id
            ,'re_content' => $request->re_content
            ,'re_star' => $request->re_star
        ];

        // 데이터 유효성 검사
        $validator = Validator::make(
            $requestData
            , [
                're_star' => ['required', 'regex:/^[1-5]{1}$/']
                ,'re_content' => ['nullable', 'max: 200','regex:/^[0-9ㄱ-ㅎㅏ-ㅣ가-힣a-zA-Z\s.,:?!@#$%^&*]+$/u']
            ]
        );

        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }

        // 데이터 생성
        $createData = $request->only('re_content','re_star');

        
        // 작성 처리
        $createData['u_id'] = Auth::id();
        $createData['p_id'] = 1; // $request->p_id; store에서 넘겨 받은 p_id 작성하기 
        $createData['re_content'] = $request->re_content;
        $createData['re_star'] = $request->re_star;


        // 작성 처리
        $reviewCreate = Review::create($createData);

        // 레스폰스 데이터 생성
        $responseData = [
            'code' => '0'
            ,'msg' => '리뷰 작성 완료'
            ,'data' => $reviewCreate
        ];

        return response()->json($responseData, 200);
    }

    // 리뷰 수정
    // 리뷰수정 페이지에서 버튼 눌렀을때 reviews(리뷰) 테이블에서 데이터 수정
    public function reviewUpdateSubmit(Request $request) {

        // 리퀘스트 데이터 받기
        $requestData = $request->all();
        
        // 데이터 유효성 검사
        $validator = Validator::make(
            $requestData
            , [
                're_star' => ['required', 'regex:/^[1-5]{1}$/']
                ,'re_content' => ['nullable', 'max: 200','regex: /^[0-9ㄱ-ㅎㅏ-ㅣ가-힣a-zA-Z\s.,:?!@#$%^&*]+$/u']
            ]
        );

        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }
        
        // 데이터 생성
        $updateData = Review::find($request->re_id);

        // 수정 처리
        $updateData->re_content = $request->re_content;
        $updateData->re_star = $request->re_star;
        // 수정된 데이터 저장
        $updateData->save();

        // 출력될 데이터 가공
        $updateArrayData = $updateData->toArray();
        $addUpdateData = [
            'ml' => $request->ml,
            'name' => $request->name,
            'img' => $request->img
        ];

        // 레스폰스 데이터 생성
        $responseData = [
            'code' => '0'
            ,'msg' => '리뷰 수정 완료'
            ,'data' => array_merge($updateArrayData, $addUpdateData)
        ];

        return response()->json($responseData, 200);
    }

    // 메인 페이지에서 리뷰 출력
    public function reviewMainIndex() {
        $noticeData = Review::select('reviews.*', 'products.*')
                            ->join('products','reviews.p_id','=','products.id')
                            ->orderBy('reviews.re_star', 'DESC')
                            ->orderBy('reviews.created_at', 'DESC')
                            ->limit(4)
                            ->get();
        $responseData = [
            'code' => '0'
            ,'msg' => '리뷰 획득 완료'
            ,'data' => $noticeData->toArray()
        ];

        return response()->json($responseData, 200);
    }

}
