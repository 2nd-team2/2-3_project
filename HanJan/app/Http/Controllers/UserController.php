<?php

namespace App\Http\Controllers;

use App\Exceptions\MyAuthException;
use App\Exceptions\MyValidateException;
use App\Models\Orderproduct;
use App\Models\Qna;
use App\Models\Qnaproduct;
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

        // 로그인 
        public function login(Request $request) {
            // 유효성 검사
            $validator = Validator::make(
                $request->only('email', 'password')
                ,[
                    // 'email' => ['required', 'min:1', 'max:30', 'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/'], 
                    'email' => ['required', 'min:1', 'max:30'], 
                    // 'name' => ['required', 'min:10', 'max:30','unique:users', 'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/'], // TODO: 배포
                    'password' => ['required', 'min:1', 'max:20'], 
                    // 'password' => ['required', 'min:9', 'max:20', 'regex:/^[a-zA-Z0-9!@#$%^&*]+$/u'], // TODO: 배포
                ]
            );

            // 유효성 검사 실패시 처리
            if($validator->fails()) {
                Log::debug('유효성 검사 실패', ['errors' => $validator->errors()->toArray(), 'input' => $request->all()]);
                throw new MyValidateException('E01');
            }
    
            // 유저정보 획득
            $userInfo = User::select('users.*')
                                ->selectSub(function($query) {
                                    $query->select(DB::raw('count(*)'))
                                            ->from('users')
                                            ->where('users.email');
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
        public function regist(Request $request) {
            // 리퀘스트 데이터 획득
            $requestData = $request->all();
            Log::debug($requestData);
            // 유효성 검사
            $validator = Validator::make(
                $requestData,
                [
                    'email' => ['required', 'min:1', 'max:30','unique:users', 'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/'], // TODO : 개발할때
                    // 'email' => ['required', 'min:10', 'max:30','unique:users', 'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/'], // TODO : 배포
                    'password' => ['required', 'min:1', 'max:20'], // TODO : 개발할때
                    // 'password' => ['required', 'min:9', 'max:20', 'regex:/^[a-zA-Z0-9!@#$%^&*]+$/u'], // TODO : 배포
                    'password_chk' => ['same:password'],
                    'tel' => ['required', 'min:10','max:11', 'regex:/^[0-9]+$/'],
                    'addr' => ['required'],
                    'name' => ['required'],
                    'post' => ['required'],
                    'det_addr' => ['required'],
                    'birth' => ['required'],
                ] 
            );

            // 유효성 검사 실패 체크
            if($validator->fails()) {
                throw new MyValidateException('E01');
            }

            // 작성 데이터 생성
            $insertData = $request->all();

            // 비밀번호 설정
            $insertData['password'] = Hash::make($request->password);

            // 인서트 처리
            $userInfo = User::create($insertData);

            $responseData = [
                'code' => '0',
                'msg' => '회원 가입 완료',
                'data' => $userInfo
            ];

            return response()->json($responseData, 200);

        }

        // 이메일 중복체크
        public function registEmailChk($emailText)
        {
            $responseData = [
                'code' => '0',
                'msg' => '중복체크',
                'exists' => false
            ];

            $userInfo = User::where('email', $emailText)->first();

            if($userInfo) {
                $responseData['exists'] = true;
            }
            
            return response()->json($responseData, 200);
        }

        // 유저 정보 수정
        public function userUpdate(Request $request) {
            
            // 유저정보 획득
            $userInfo = Auth::user();

            // 비밀번호와 비밀번호 확인이 일치하는지 확인
            if ($request->password !== $request->password_chk) {
                throw new MyAuthException('E21');
            }

            // 업데이트 할 리퀘스트 데이터 셋팅
            $userInfo->password = Hash::make($request->password); 
            $userInfo->name = $request->name;
            $userInfo->tel = $request->tel;
            $userInfo->addr = $request->addr;
            $userInfo->det_addr = $request->det_addr;
            $userInfo->post = $request->post;

            // 유저정보 갱신
            $userInfo->save();
            $response = [
                'code' => 0,
                'msg' => '회원 정보 수정 완료',
                'data' => $userInfo
            ];
            return response()->json($response, 200);
        }

        // 유저 탈퇴
        public function userDelete(Request $request) {

            // 유저정보 획득
            $userInfo = Auth::user();

            // 사용자 삭제
            $deleted = User::destroy($userInfo->id);
    
            if ($deleted) {
                // 로그아웃 처리
                Auth::logout(Auth::user());
                return response()->json(['msg' => '회원 탈퇴 완료'], 200);
            } else {
                return response()->json(['error' => '사용자 삭제 실패'], 500);
            }
        }

        // 수정 전 비밀번호 재확인
        public function confirm(Request $request) 
            {
                $password = $request->input('password');

                $userInfo = Auth::user();

                $responseData = [
                    'code' => '0',
                    'msg' => '비밀번호 체크',
                    'exists' => false
                ];

                if($userInfo && Hash::check($password, $userInfo->password)) {
                    $responseData['exists'] = true;
                }

                return response()->json($responseData, 200);
            }
        
        // 마이페이지 주문목록
        public function infoData() {
                $infoData = Orderproduct::select('orderproducts.*','users.id','products.*')
                                ->join('users','orderproducts.or_id','=','users.id')
                                ->join('products','orderproducts.p_id','=','products.id')
                                ->where('orderproducts.or_id', '=', Auth::id())
                                ->where('orderproducts.deleted_at', '=', null)
                                ->orderBy('orderproducts.created_at','DESC')
                                ->orderBy('orderproducts.orp_id','DESC')
                                ->distinct()
                                ->limit(3)
                                ->get();
                
                $responseData = [
                    'code' => '0'
                    ,'msg' => '주문목록 획득 완료'
                    ,'data' => $infoData->toArray()
                ];
            
                return response()->json($responseData, 200);
            }

        

        // 마이페이지 상품 문의목록
        public function productAsk() {
                $askData = Qnaproduct::select('users.id','qnaproducts.*')
                                ->join('users','qnaproducts.u_id','=','users.id')
                                ->where('qnaproducts.u_id', '=', Auth::id())
                                ->where('qnaproducts.deleted_at', '=', null)
                                ->orderBy('qnaproducts.created_at','DESC')
                                ->orderBy('qnaproducts.qnp_id','DESC')
                                ->limit(3)
                                ->get();

                // Log::debug($askData);

                $responseData = [
                    'code' => '0'
                    ,'msg' => '문의목록 획득 완료'
                    ,'data' => $askData->toArray()
                ];
            
                return response()->json($responseData, 200);
            }
        
        // 문의목록 삭제처리
        public function productAskDelete($qnp_id) {

            Qnaproduct::destroy($qnp_id);
            
            $responseData = [
                'code' => '0'
                ,'msg' => '삭제 완료'
                ,'data' => $qnp_id
            ];
            Log::debug($responseData);
            return response()->json($responseData);
        }

        // 마이페이지 1:1문의목록
        public function askData() {
            $askData = Qna::select('users.id','qnas.*')
                            ->join('users','qnas.u_id','=','users.id')
                            ->where('qnas.u_id', '=', Auth::id())
                            ->where('qnas.deleted_at', '=', null)
                            ->orderBy('qnas.created_at','DESC')
                            ->orderBy('qnas.qn_id','DESC')
                            ->limit(3)
                            ->get();

            $responseData = [
                'code' => '0'
                ,'msg' => '1:1 문의목록 획득 완료'
                ,'data' => $askData->toArray()
            ];
        
            return response()->json($responseData, 200);
        }

        // 문의목록 삭제처리
        public function askDelete($qn_id) {

            Qnaproduct::destroy($qn_id);
            
            $responseData = [
                'code' => '0'
                ,'msg' => '삭제 완료'
                ,'data' => $qn_id
            ];
            Log::debug($responseData);
            return response()->json($responseData);
        }

        // ----------------------- 성환 끝 ---------------------------
        // ----------------------- 민서 시작 -------------------------
        // ----------------------- 민서 끝 ---------------------------
        // ----------------------- 호경 시작 -------------------------
        // ----------------------- 호경 끝 ---------------------------
}
