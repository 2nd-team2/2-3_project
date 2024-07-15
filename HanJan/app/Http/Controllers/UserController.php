<?php

namespace App\Http\Controllers;

use App\Exceptions\MyAuthException;
use App\Exceptions\MyValidateException;
use App\Mail\VerificationEmail;
use App\Mail\SendEmail;
use App\Models\Exchange;
use App\Models\Order;
use App\Models\Qna;
use App\Models\Qnaproduct;
use App\Models\Review;
use App\Models\User;
use App\Models\VerificationToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

// ************************************************

// 재사용할 수도 있으므로 기능 설명 꼭 주석처리 해두기

// ************************************************

class UserController extends Controller
{
        // ----------------------- 보원 시작 -------------------------
        // 카카오 로그인
        public function redirectToKakao()
        {
            // 카카오 로그인 할때 마다 카카오에서 제공하는 로그인창 출력하기
            return Socialite::driver('kakao')->with(['prompt' => 'select_account'])->redirect();
            // return Socialite::driver('kakao')->redirect();
        }
        // 소셜 로그인 후 콜백 처리
        public function handleKakaoCallback()
        {
            try {
                $kakaoUser = Socialite::driver('kakao')->user();
                // 사용자 데이터 확인
                // Log::debug('Kakao User Data: ', (array) $kakaoUser);
            Log::debug('Kakao User Data: ', (array) $kakaoUser);

                // 카카오에서 받아온 email을 통해 사용자 정보가 있는지 확인
                $user = User::where('email', $kakaoUser->getEmail())->first();


                if (isset($user)) {
                    // 사용자가 있으면 로그인 처리
                    Auth::login($user);
    
                    $responseData = [
                        'code' => '1',
                        'msg' => '카카오 로그인 완료',
                        'data' => $user->toArray() // 사용자 데이터를 배열로 변환
                    ];
                } else {
                    // 없을 경우 카카오에서 가져온 email 넘겨주기

                    $responseData = [
                        'code' => '0',
                        'msg' => '카카오 첫 로그인 완료',
                        'data' => ['email' => $kakaoUser->getEmail()]
                    ];
                }

                // 레스폰스 데이터 가공처리
                $encodedResponseData = urlencode(json_encode($responseData));

                // 로그인 처리중 페이지로 이동
                return redirect("/login/kakao/callback?data=$encodedResponseData");

            } catch (\Exception $e) {
                Log::debug($e);
                return redirect('/login')->with('error', '카카오 로그인 실패: ' . $e->getMessage());
            }

        }

        // 카카오 로그인
        public function kakaoLogin(Request $request) {
            
            Log::debug('백처리 : 로그인 했을때 가져오는 request 값 확인');
            Log::debug($request);
            
            $userInfo = User::select('users.*')
                        ->where('email', $request->email)
                        ->first();
            
            //유저 정보 없음
            if(!isset($userInfo)) {
                // 유저 없음
                throw new MyAuthException('E20');
            }
            
            Log::debug('백처리 : 로그인 했을때 가져오는 userInfo 값 확인');
            Log::debug($userInfo);

            // 로그인 처리
            Auth::login($userInfo);

            if (Auth::check()) {
                Log::debug('사용자 로그인 성공');
            } else {
                Log::debug('사용자 로그인 실패');
            }
    
            // 레스폰스 데이터 생성
            $responseData = [
                'code' => '0',
                'msg' => '로그인 성공',
                'data' => $userInfo
            ];
            return response()->json($responseData, 200)->cookie('auth', '1', 600, null, null, false, false);
        }

        
        // 이메일 중복 체크 후 인증 메일 발송
        public function sendVerificationEmail(Request $request) {
            // 유저가 작성한 이메일 정보 획득
            $email = $request->input('email');
            Log::debug('인증메일 발송할 유저의 이메일- 본인이 작성한 이메일');
            Log::debug($email);

            // 이메일 형식 유효성 검사
            $validator = Validator::make(
                ['email' => $email],
                ['email' => 'required|email']
            );
            if ($validator->fails()) {
                Log::debug('유효하지 않은 이메일 형식');
                return response()->json(['code' => '1', 'msg' => '유효하지 않은 이메일입니다.']);
            }

            // 이메일 중복 체크
            $user = User::where('email', $email)->first();
            if ($user) {
                Log::debug('이미 사용 중인 이메일');
                return response()->json(['code' => '2', 'msg' => '이미 사용 중인 이메일입니다.']);
            }


            // 이메일 검증 중복 발송체크 (예: 5분 이내에 전송된 경우)
            $verificationToken = VerificationToken::where('email', $email)->first();
            
            // if ($verificationToken && $verificationToken->updated_at->gt(Carbon::now()->subMinutes(5))) {
            //     return response()->json(['code'=>'4', 'msg' => '이메일이 이미 전송되었습니다. 잠시 후 다시 시도해주세요.'], 429);
            // }

            // 임시 코드 생성 및 저장
            $token = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            
            VerificationToken::updateOrCreate(
                ['email' => $email],
                ['token' => $token]
            );

            // 인증 메일 발송
            Log::debug('인증 메일 발송 시작');
            try {
                Mail::to($email)->send(new VerificationEmail($token));
                Log::debug('인증 메일 발송 완료');
                return response()->json(['email' => $email, 'message' => '인증 메일이 발송되었습니다.']);
            } catch (\Exception $e) {
                Log::error('인증 메일 발송 중 오류 발생: ' . $e->getMessage());
                return response()->json(['code' => '3', 'msg' => '인증 메일 발송 중 오류가 발생했습니다.']);
            }
        
        }

        // 이메일 검증 코드 확인
        public function codeChk(Request $request) {
            
            $inputData = $request->verifyCode;

            $verification = VerificationToken::where('token', $inputData)->first();

            if ($verification) {

                VerificationToken::updateOrCreate(
                    ['token' => $inputData],
                    ['ver_flg' => 1]
                );

                return response()->json(['code' => 1, 'msg' => '코드 인증 성공']);
            } else {
                return response()->json(['code' => 2, 'msg' => '코드 인증 실패']);
            }

        }


        // ----------------------- 보원 끝 ---------------------------
        // ----------------------- 성환 시작 -------------------------

        // 로그인 
        public function login(Request $request) {
            // 유효성 검사
            $validator = Validator::make(
                $request->only('email', 'password')
                ,[
                    'email' => ['required', 'min:5', 'max:30', 'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/'], 
                    'password' => ['required', 'min:1', 'max:100'], 
                    // 'password' => ['required', 'min:8', 'max:20', 'regex:/^[a-zA-Z0-9!@#$%^&*]+$/u'],
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
            return response()->json($responseData, 200)->cookie('auth', '1', 600, null, null, false, false);
        }

        // 로그아웃
        public function logout() {
            Auth::logout(Auth::user());
            Session::invalidate(); // 기본 세션 파기하고 새로운 세션 생성
            Session::regenerateToken(); // CSRF 토큰 재발급
    
            $responseData = [
                'code' => '0',
                'msg' => '로그아웃완료'
            ];
            return response()->json($responseData, 200)
                            ->cookie('auth', '1', -1, null, null, false, false);
            // return response()->json($responseData, 200) ->withCookie(cookie()->forget('auth'));
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
                    'email' => ['required', 'min:5', 'max:30', 'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/'],
                    'password' => ['required', 'min:1', 'max:20', 'regex:/^[a-zA-Z0-9!@]+$/u'], 
                    'password_chk' => ['same:password'],
                    'tel' => ['required', 'min:10','max:11', 'regex:/^[0-9]+$/'],
                    'addr' => ['required'],
                    'name' => ['required', 'regex:/^[a-zA-Z가-힣]+$/u'],
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

        // // 이메일 중복체크
        // public function registEmailChk($emailText)
        // {
        //     // 이메일 중복 확인
        //     $userInfo = User::withTrashed()->where('email', $emailText)->first();

        //     // 기본 응답 데이터
        //     $responseData = [
        //         'code' => '0',
        //         'msg' => '중복체크',
        //     ];

        //     // 이메일이 유효하지 않은 형식일 경우
        //     if (!filter_var($emailText, FILTER_VALIDATE_EMAIL)) {
        //         $responseData['code'] = '1';
        //     } else if($userInfo) {
        //         $responseData['code'] = '2';
        //         Mail::to($userInfo->email)->send(new SendEmail($userInfo));
        //         Log::debug($userInfo->email);
        //     } else {
        //         $responseData['code'] = '3';
        //     }

        //     return response()->json($responseData, 200);
        // }

        // 유저 정보 수정
        public function userUpdate(Request $request) {
            
            $userInfo = Auth::user();

            // 비밀번호와 비밀번호 확인이 일치하는지 확인
            if ($request->password !== $request->password_chk) {
                throw new MyAuthException('E21');
            }

            // 업데이트 할 리퀘스트 데이터 셋팅
            $userInfo->password = Hash::make($request->password); 
            $userInfo->tel = $request->tel;
            $userInfo->addr = $request->addr;
            $userInfo->det_addr = $request->det_addr;
            $userInfo->post = $request->post;

            // 유저정보 갱신
            $userInfo->save();
            $responseData = [
                'code' => 0,
                'msg' => '회원 정보 수정 완료',
                'data' => $userInfo
            ];
            return response()->json($responseData, 200);
        }

        // 유저 탈퇴
        public function userDelete() {

            // 유저정보 획득
            $userInfo = Auth::user();

            // 사용자 삭제
            $deleted = Review::where('u_id', '=', $userInfo->id)->delete(); 
            $deleted = Exchange::where('u_id', '=', $userInfo->id)->delete(); 
            $deleted = Qna::where('u_id', '=', $userInfo->id)->delete(); 
            $deleted = Qnaproduct::where('u_id', '=', $userInfo->id)->delete(); 
            $deleted = User::destroy($userInfo->id);
            
            if ($deleted) {
                // 로그아웃 처리
                Auth::logout(Auth::user());
                return response()->json(['msg' => '회원 탈퇴 완료'], 200)
                ->cookie('auth', '1', -1, null, null, false, false);
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
        
        // ----------------------- 성환 끝 ---------------------------
        // ----------------------- 민서 시작 -------------------------
        // ----------------------- 민서 끝 ---------------------------
        // ----------------------- 호경 시작 -------------------------
        // ----------------------- 호경 끝 ---------------------------

        // --------------------------------------------------------------------- 관리자 페이지 -------------------------------------------------------------------------
        // ----------------------- 보원 시작 ---------------------------
        // ----------------------- 보원 끝 ---------------------------

        // ----------------------- 성환 시작 ---------------------------
        // ----------------------- 성환 끝 ---------------------------

        // ----------------------- 민서 시작 ---------------------------
        // ----------------------- 민서 끝 ---------------------------

        // ----------------------- 호경 시작 ---------------------------
        // 관리자 페이지 유저 전체 불러오기
        public function adminUserIndex() {
            $adminUserData = User::withTrashed()
                                ->select('users.*')
                                ->orderBy('users.created_at', 'DESC')
                                ->paginate(20);
            
            $responseData = [
                'code' => '0'
                ,'msg' => '유저 전체 획득 완료'
                ,'data' => $adminUserData->toArray()
            ];

            return response()->json($responseData, 200);
        }
        
        // 관리자 페이지에서 유저 정보 수정
        public function adminUserUpdate(Request $request, $id) {
            
            $userInfo = User::find($id);

            if (!$userInfo) {
                return response()->json([
                    'code' => 1,
                    'msg' => '해당 사용자를 찾을 수 없습니다.'
                ], 500);
            }

            // 비밀번호와 비밀번호 확인이 일치하는지 확인
            if ($request->password !== $request->password_chk) {
                throw new MyAuthException('E21');
            }

            // // 이메일 중복 체크
            // $existingUser = User::where('email', $request->email)->where('id', '!=', $userInfo->id)->first();
            // if ($existingUser) {
            //     return response()->json([
            //         'code' => 1,
            //         'msg' => '해당 이메일은 이미 사용 중입니다.'
            //     ], 400);
            // }

            // 업데이트 할 리퀘스트 데이터 셋팅
            $userInfo->name = $request->name;
            $userInfo->email = $request->email;
            $userInfo->tel = $request->tel;
            $userInfo->addr = $request->addr;
            $userInfo->det_addr = $request->det_addr;
            $userInfo->post = $request->post;
            $userInfo->birth = $request->birth;

            // 유저정보 갱신
            $userInfo->save();
            $responseData = [
                'code' => 0,
                'msg' => '회원 정보 수정 완료',
                'data' => $userInfo
            ];
            return response()->json($responseData, 200);
        }

        // 관리자 페이지 월별 유저 통계 불러오기
        public function adminUseTatistics() {
            $adminUserTatisticsData = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") AS month')
                                    ->selectRaw('COUNT(*) AS new_users')
                                    ->selectRaw('SUM(CASE WHEN deleted_at IS NOT NULL THEN 1 ELSE 0 END) AS withdraw_users')
                                    ->withTrashed() // Soft Deleted 항목도 포함
                                    ->groupBy('month')
                                    ->orderBy('month')
                                    ->get();
            $responseData = [
                'code' => '0'
                ,'msg' => '신규 가입자 획득 완료'
                ,'data' => $adminUserTatisticsData->toArray()
            ];

            return response()->json($responseData, 200);
        }

        // 관리자 페이지 유저 연령대 통계 불러오기
        public function adminAgeRange() {
            $adminUserAgeRangeData = User::selectRaw('CASE
                                                WHEN TIMESTAMPDIFF(YEAR, birth, CURDATE()) BETWEEN 20 AND 29 THEN "20대"
                                                WHEN TIMESTAMPDIFF(YEAR, birth, CURDATE()) BETWEEN 30 AND 39 THEN "30대"
                                                WHEN TIMESTAMPDIFF(YEAR, birth, CURDATE()) BETWEEN 40 AND 49 THEN "40대"
                                                WHEN TIMESTAMPDIFF(YEAR, birth, CURDATE()) BETWEEN 50 AND 59 THEN "50대"
                                                WHEN TIMESTAMPDIFF(YEAR, birth, CURDATE()) >= 60 THEN "60대 이상"
                                                END AS age_group,
                                                COUNT(*) AS user_count')
                                        ->whereRaw('TIMESTAMPDIFF(YEAR, birth, CURDATE()) >= 20')
                                        ->groupBy(DB::raw('age_group'))
                                        ->orderBy(DB::raw('FIELD(age_group, "20대", "30대", "40대", "50대", "60대 이상")'))
                                        ->get();
            $responseData = [
                'code' => '0'
                ,'msg' => '신규 가입자 획득 완료'
                ,'data' => $adminUserAgeRangeData->toArray()
            ];

            return response()->json($responseData, 200);
        }

        // 이메일 중복체크
        public function registEmailChk($emailText){
            // 이메일 중복 확인
            $userInfo = User::withTrashed()->where('email', $emailText)->first();
            // 기본 응답 데이터
            $responseData = [
                'code' => '0',
                'msg' => '중복체크',
            ];

            // 이메일이 유효하지 않은 형식일 경우
            if (!filter_var($emailText, FILTER_VALIDATE_EMAIL)) {
                $responseData['code'] = '1';
            } else if($userInfo) {
                $responseData['code'] = '2';
            } else {
                $responseData['code'] = '3';
            }

            return response()->json($responseData, 200);
        }
        // ----------------------- 호경 끝 ---------------------------
}
