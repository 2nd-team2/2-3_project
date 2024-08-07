<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use Carbon\Carbon;
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
                        ->get();
    
        $responseData = [
                'code' => '0'
                ,'msg' => '초기 장바구니 상품 획득 완료'
                ,'data' => $productDate->toArray()
        ];
        
        return response()->json($responseData, 200);
    }

    // 장바구니 sold Out 저장 처리
    public function bagsSoldOut(Request $request) {
        $soldOutData = Bag::where('ba_id','=', $request->ba_id)->first();

        $soldOutData->ba_count = $request->count;
        $soldOutData->save();
            
        $responseData = [
            'code' => '0'
            ,'msg' => 'Sold Out 처리 완료'
            ,'data' => $soldOutData
        ];

        return response()->json($responseData);
    }

    // 장바구니 수량 감소한 데이터 저장
    public function bagsCountMinus($ba_id) {

        $productDate = Bag::where('ba_id','=', $ba_id)->first();
        
        // 조회된 데이터가 있는지 확인
        if($productDate) {
            $productDate->ba_count -= 1;
            
            $productDate->save();
            
            $responseData = [
                'code' => '0'
                ,'msg' => '장바구니 수량 감소 완료'
                ,'data' => $ba_id
            ];

        } else {
            $responseData = [
                'code' => '0'
                ,'msg' => '장바구니 상품을 찾을 수 없습니다.'
                ,'data' => $ba_id
            ];
        }
        
        return response()->json($responseData);
    }
    // 장바구니 수량 증가한 데이터 저장
    public function bagsCountPlus($ba_id) {

        $productDate = Bag::where('ba_id','=', $ba_id)->first();

        // 조회된 데이터가 있는지 확인
        if($productDate) {
            
            $productDate->ba_count += 1;
            
            $productDate->save();
            
            $responseData = [
                'code' => '0'
                ,'msg' => '장바구니 수량 증가 완료'
                ,'data' => $ba_id
            ];

        } else {
            $responseData = [
                'code' => '0'
                ,'msg' => '장바구니 상품을 찾을 수 없습니다.'
                ,'data' => $ba_id
            ];
        }

        return response()->json($responseData);
    }
    // 장바구니 수량 입력한 데이터 저장
    public function bagsCountChange($ba_id, Request $request) {
        
        $productDate = Bag::where('ba_id','=', $ba_id)->first();
        $baCountData = $request->ba_count;
        
        // 조회된 데이터가 있는지 확인
        if($productDate) {
            
            $productDate->ba_count = $baCountData;

            $productDate->save();
            
            $responseData = [
                'code' => '0'
                ,'msg' => '장바구니 수량 입력 완료'
                ,'data' => $ba_id
            ];

        } else {
            $responseData = [
                'code' => '0'
                ,'msg' => '장바구니 상품을 찾을 수 없습니다.'
                ,'data' => $ba_id
            ];
        }

        return response()->json($responseData);
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


    // Bags(장바구니 테이블에서) 체크된 상품 삭제 처리
    public function bagsSelectDelete(Request $request) {

        $baIds = $request->input('ba_id');
        // $baCounts = $request->input('ba_count');

        // Log::debug($request);

        foreach($baIds as $ba_id) {
            
            Bag::destroy($ba_id);

        };

        $responseData = [
            'code' => '0'
            ,'msg' => '장바구니 상품 선택 삭제 완료'
            ,'data' => $ba_id
        ];

        return response()->json($responseData);
    }

    // // 장바구니 데이터 > 주문 페이지로 전달 처리
    // public function bagsToOrder(Request $request) {

    //     $baIds = $request->input('ba_id');
    //     // $baCounts = $request->input('ba_count');
    //     // $pIDs = $request->input('p_id');

    //     foreach($baIds as $ba_id) {
    //         // 장바구니에서 정보 가져오기
    //         $requestData =  Bag::select('bags.*','products.*')
    //                                 ->join('products', 'bags.p_id', '=','products.id')
    //                                 ->where('bags.u_id', '=', Auth::id())
    //                                 ->get();
    //     };


    //     $responseData = [
    //         'code' => '0'
    //         ,'msg' => '장바구니 상품 주문 페이지로 전달 완료'
    //         ,'data' => $request
    //     ];

    //     return response()->json($responseData);
    // }
    

}
