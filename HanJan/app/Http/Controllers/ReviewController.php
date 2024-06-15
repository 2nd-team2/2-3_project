<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    // Bags(장바구니)테이블에서 휴지통 버튼 눌렀을때 삭제 처리
    public function reviewDelete($re_id) {

        Review::destroy($re_id);
        
        $responseData = [
            'code' => '0'
            ,'msg' => '리뷰 삭제 완료'
            ,'data' => $re_id
        ];

        return response()->json($responseData);
    }
}
