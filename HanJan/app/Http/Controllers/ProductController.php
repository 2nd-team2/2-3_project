<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

// ************************************************

// 재사용할 수도 있으므로 기능 설명 꼭 주석처리 해두기

// ************************************************

class ProductController extends Controller
{
    // ----------------------- 보원 시작 -------------------------

    // Bags(장바구니)테이블에서
    // 로그인 되어있는 아이디와 일치하는 u_id의 초기 게시글 획득
    public function bagsIndex () {
        $productDate = Bag::select('bags.*', 'products.*', 'users.id')
                        ->join('users','bags.u_id','=','users.id')
                        ->join('products','bags.p_id','=','products.id')
                        ->where('bags.u_id', '=', Auth::id())
                        ->where('bags.deleted_at', '=', null)
                        ->orderBy('bags.created_at','DESC')
                        ->orderBy('bags.ba_id','DESC')
                        ->limit(3)
                        ->get();

        Log::debug($productDate); // TODO
    
        $responseData = [
                'code' => '0'
                ,'msg' => '초기 장바구니 상품 획득 완료'
                ,'data' => $productDate->toArray()
        ];
        Log::debug($responseData); // TODO
        
        return response()->json($responseData, 200);
    
    
    }

    // Bags(장바구니)테이블에서 휴지통 버튼 눌렀을때 삭제 처리
    public function bagsDelete($ba_id) {

        Bag::destroy($ba_id);
        
        $responseData = [
            'code' => '0'
            ,'msg' => '글 삭제 완료'
            ,'data' => $ba_id
        ];

        return response()->json($responseData);
    }



        // ----------------------- 보원 끝 ---------------------------
        // ----------------------- 성환 시작 -------------------------
        // ----------------------- 성환 끝 ---------------------------
        // ----------------------- 민서 시작 -------------------------
        // ----------------------- 민서 끝 ---------------------------
        // ----------------------- 호경 시작 -------------------------
        // ----------------------- 호경 끝 ---------------------------
}
