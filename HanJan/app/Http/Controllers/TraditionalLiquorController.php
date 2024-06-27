<?php

namespace App\Http\Controllers;

use App\Models\TraditionalLiquor;
use Illuminate\Http\Request;

class TraditionalLiquorController extends Controller
{
    // 공지사항 획득
    public function traditionalLiquorIndex() {
        $traditionalLiquorData = TraditionalLiquor::select('traditional_liquors.tl_id', 'traditional_liquors.tl_title', 'traditional_liquors.tl_content', 'traditional_liquors.tl_img')
                                ->get();
        $responseData = [
            'code' => '0'
            ,'msg' => '전통주 설명 획득 완료'
            ,'data' => $traditionalLiquorData->toArray()
        ];

        return response()->json($responseData, 200);
    }
}
