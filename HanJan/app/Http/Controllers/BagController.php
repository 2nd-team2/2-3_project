<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BagController extends Controller
{
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
                        // ->limit(3)
                        ->get();
    
        $responseData = [
                'code' => '0'
                ,'msg' => '초기 장바구니 상품 획득 완료'
                ,'data' => $productDate->toArray()
        ];
        
        return response()->json($responseData, 200);
    }

    // Bags(장바구니)테이블에서 휴지통 버튼 눌렀을때 삭제 처리
    public function bagsDelete($ba_id) {

        Bag::destroy($ba_id);
        
        $responseData = [
            'code' => '0'
            ,'msg' => '장바구니 상품 삭제 완료'
            ,'data' => $ba_id
        ];

        return response()->json($responseData);
    }

    // 장바구니 수량 감소한 데이터 저장
    public function bagsCountminus($ba_id) {

        Log::debug($ba_id);

        $productDate = Bag::select('bags.*')
                        ->where('ba_id','=', $ba_id)
                        ->get();

        Log::debug($productDate);

        $productDate['ba_count'] = 

        // TODO : update_at 생성하면주석해제하기
        // $productDate['updated_at'] =

        $responseData = [
            'code' => '0'
            ,'msg' => '장바구니 상품 삭제 완료'
            ,'data' => $ba_id
        ];

        return response()->json($responseData);

    }


    // Bags(장바구니)테이블에서 전체삭제 버튼 눌렀을때 삭제 처리

    // Bags(장바구니)테이블에서 선택삭제 버튼 눌렀을때 삭제 처리
}