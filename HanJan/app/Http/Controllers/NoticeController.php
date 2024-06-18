<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
}
