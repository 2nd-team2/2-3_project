<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    // 공지사항 획득
    public function index() {
        $noticeData = Notice::select('notice.*')
                            ->orderBy('id', 'DESC')
                            ->get();
        
        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $noticeData->toArray()
        ];

        return response()->json($responseData, 200);
    }
}
