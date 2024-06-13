<?php

namespace App\Http\Controllers;

use App\Exceptions\MyAuthException;
use App\Exceptions\MyValidateException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

// ************************************************

// 재사용할 수도 있으므로 기능 설명 꼭 주석처리 해두기

// ************************************************

class UserController extends Controller
{
        // ----------------------- 보원 시작 -------------------------
        // ----------------------- 보원 끝 ---------------------------
        // ----------------------- 성환 시작 -------------------------

        public function login(Request $request) {
                // 유효성 검사
                $validator = Validator::make(
                    $request->only('email', 'password')
                    ,[
                        'email' => ['required', 'min:1', 'max:30','unique:users', 'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/'], 
                        // 'name' => ['required', 'min:10', 'max:30','unique:users', 'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/'], // TODO: 배포
                        'password' => ['required', 'min:1', 'max:20', 'regex:/^[a-zA-Z0-9!@#$%^&*]+$/u'], 
                        // 'password' => ['required', 'min:9', 'max:20', 'regex:/^[a-zA-Z0-9!@#$%^&*]+$/u'], // TODO: 배포
                    ]
                );
                Log::debug($validator);
                // 유효성 검사 실패시 처리
                if($validator->fails()) {
                    Log::debug('유효성 검사 실패', $validator->errors()->toArray());
                    throw new MyValidateException('E01');
                }
        
                // 유저정보 획득
                $userInfo = User::select('users.*')
                                    ->selectSub(function($query) {
                                        $query->select(DB::raw('count(*)'))
                                                ->from('users')
                                                ->whereColumn('users.email');
                                    }, 'boards_count')
                                    ->where('email', $request->email)
                                    ->first();
        
                //유저 정보 없음
                if(!isset($userInfo)) {
                    // 유저 없음
                    throw new MyAuthException('E20');
                } else if(!(Hash::check($request->password, $userInfo->password))) {
                    //비밀번호 오류
                    throw new MyAuthException('E21');
                }
        
                // 로그인 처리
                Auth::login($userInfo);
        
                // 레스폰스 데이터 생성
                $responseData = [
                    'code' => '0',
                    'msg' => '로그인 성공',
                    'data' => $userInfo
                ];
                return response()->json($responseData, 200)->cookie('auth', '1', 120, null, null, false, false);
            }
            public function logout() {
                // 로그아웃
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
                // 회원가입
                public function registration(Request $request) {
                    // 리퀘스트 데이터 획득
                    $requestData = $request->all();
        
                    // 유효성 검사
                    $validator = Validator::make(
                        $requestData,
                        [
                            // 'email' => ['required', 'min:1', 'max:30','unique:users', 'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/'], // TODO : 개발할때
                            'email' => ['required', 'min:10', 'max:30','unique:users', 'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/'],
                            // 'password' => ['required', 'min:1', 'max:20', 'regex:/^[a-zA-Z0-9!@#$%^&*]+$/u'], // TODO : 개발할때
                            'password' => ['required', 'min:9', 'max:20', 'regex:/^[a-zA-Z0-9!@#$%^&*]+$/u'],
                            'password_chk' => ['same:password'],
                            'tel' => ['required', 'min:9','max:12','regex:/^\d{10,11}$/'],
                            'addr' => ['required'],
                            'det_addr' => ['required'],
                            'birth' => ['required', 'integer', 'min:19'],
                        ] 
                    );
        
                    // 유효성 검사 실패 체크
                    if($validator->fails()) {
                        Log::debug('유효성 검사 실패', $validator->errors()->toArray());
                        throw new MyValidateException('E01');
                    }
        
                    // 작성 데이터 생성
                    $insertData = $request->all();
        
                    // 파일저장
                    $insertData['name'] = $request->file('name')->store('name');
        
                    // 비밀번호 설정
                    $insertData['password'] = Hash::make($request->password);
        
                    // 인서트 처리
                    $userInfo = User::create($insertData);
        
                    $responseData = [
                        'code' => '0',
                        'msg' => '로그아웃완료',
                        'data' => $userInfo
                    ];
        
                    return response()->json($responseData, 200);
        
                }

        // ----------------------- 성환 끝 ---------------------------
        // ----------------------- 민서 시작 -------------------------
        // ----------------------- 민서 끝 ---------------------------
        // ----------------------- 호경 시작 -------------------------
        // ----------------------- 호경 끝 ---------------------------
}
