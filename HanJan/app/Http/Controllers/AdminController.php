<?php

namespace App\Http\Controllers;

use App\Exceptions\MyAuthException;
use App\Exceptions\MyValidateException;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // 로그인 
    public function adminLogin(Request $request) {
        // 유효성 검사
        $validator = Validator::make(
            $request->only('account', 'password')
            ,[
                'account' => ['required', 'min:5', 'max:30'], 
                'password' => ['required', 'min:1', 'max:20'], 
            ]
        );

        // 유효성 검사 실패시 처리
        if($validator->fails()) {
            // Log::debug('유효성 검사 실패', ['errors' => $validator->errors()->toArray(), 'input' => $request->all()]);
            throw new MyValidateException('E01');
        }

        // 유저정보 획득
        $AdminInfo = admin::select('admins.*')
                            ->selectSub(function($query) {
                                $query->select(DB::raw('count(*)'))
                                        ->from('admins')
                                        ->where('admins.account');
                            }, 'boards_count')
                            ->where('account', $request->account)
                            ->first();

        //유저 정보 없음
        if(!isset($AdminInfo)) {
            // 유저 없음
            throw new MyAuthException('E20');
        } else if(!(Hash::check($request->password, $AdminInfo->password))) {
            //비밀번호 오류
            throw new MyAuthException('E21');
        }

        // 로그인 처리
        Auth::login($AdminInfo);

        // 레스폰스 데이터 생성
        $responseData = [
            'code' => '0',
            'msg' => '로그인 성공',
            'data' => $AdminInfo
        ];
        return response()->json($responseData, 200)->cookie('auth', '1', 600, null, null, false, false);
    }

    // 관리자 로그아웃
    public function adminLogout() {
        Auth::logout(Auth::user());
        Session::invalidate(); // 기본 세션 파기하고 새로운 세션 생성
        Session::regenerateToken(); // CSRF 토큰 재발급

        $responseData = [
            'code' => '0',
            'msg' => '로그아웃완료'
        ];
        return response()->json($responseData, 200)
                        ->cookie('auth', '1', -1, null, null, false, false);

    }
}
