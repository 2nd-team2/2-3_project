<template>
    <!-- 모달 -->
    <div class="modal no_scroll">
        <div class="modal_img_box"></div>
        <button @click="openAlert" class="btn_no">NO</button>
        <button @click="closeModal" class="btn_yes">YES</button>
    </div>
    <!-- header -->
    <header>
        <div class="header_container">
            <div class="header_content">
                <div @click="logoclick" class="logo"><img src="/img/logo.png" class="logo"></div>
                <div @click="openNavMini" class="hamburger" id="hamburger"><img src="/img/hamburger.png" class="hamburger_img"></div>
                <div @click="closeNavMini" class="cancel" id="cancel"><img src="/img/cancel.png" class="cancel_img"></div>
                <ul class="nav" id="nav">
                    <li class="nav_box nav_item1">
                        <router-link to="/list?type=99&page=1" @mouseover="openMiniNav" @mouseleave="closeMiniNav" class="nav_font">
                            전체 메뉴 <span class="plus"> + </span>
                            <div class="nav_mini display_none" id="nav_mini">
                                <ul class="nav_mini_title">
                                    <li class="nav_mini_item1">
                                        <router-link to="/list?type=0&page=1" class="nav_mini_font" @click="closeNavMini">탁주</router-link>
                                    </li>
                                    <li class="nav_mini_item2">
                                        <router-link to="/list?type=1&page=1" class="nav_mini_font" @click="closeNavMini">과실주</router-link>
                                    </li>
                                    <li class="nav_mini_item3">
                                        <router-link to="/list?type=2&page=1" class="nav_mini_font" @click="closeNavMini">증류주</router-link>
                                    </li>
                                </ul>
                            </div>
                        </router-link>
                    </li>
                    <li class="nav_box nav_item2">
                        <router-link to="/traditionalLiquor" class="nav_font" @click="closeNavMini">전통주 이야기</router-link>
                    </li>
                    <li class="nav_box nav_item4">
                        <router-link to="/noticelist" class="nav_font" @click="closeNavMini">공지사항</router-link>
                    </li>
                    <li class="nav_item5">
                        <div @mouseover="openIconLogin" @mouseleave="closeIconLogin" @click="closeNavMini" class="nav_font">
                            <div v-if="!$store.state.authFlg" @click="$router.push('/login')" class="nav_user_box">
                                <img src="/img/login.png" class="nav_icon_login" id="b_iconuser">
                                <img src="/img/goldlogin.png" class="nav_icon_hover nav_icon_login_hover" id="g_iconuser">
                                <div class="nav_user">로그인</div>
                            </div>
                            <div v-else class="nav_user_box" @click="$store.dispatch('logout')">
                                <img src="/img/logout.png" class="nav_icon_logout" id="b_iconuser">
                                <img src="/img/goldlogout.png" class="nav_icon_hover nav_icon_logout_hover" id="g_iconuser">
                                <div class="nav_user">로그아웃</div>
                            </div>
                        </div>
                    </li>
                    <div class="nav_user_line"></div>
                    <li class="nav_item6">
                        <div @mouseover="openIconRegist" @mouseleave="closeIconRegist" @click="closeNavMini" class="nav_font">
                            <div v-if="!$store.state.authFlg" @click="$router.push('/agree')" class="nav_user_box">
                                <img src="/img/regist.png" class="nav_icon_regist" id="b_iconregist">
                                <img src="/img/goldregist.png" class="nav_icon_hover nav_icon_regist_hover" id="g_iconregist">
                                <div class="nav_user">회원가입</div>
                            </div>
                            <router-link to="/info" v-else class="nav_user_box">
                                <img src="/img/profile.png" class="nav_icon_my" id="b_iconregist">
                                <img src="/img/goldprofile.png" class="nav_icon_hover nav_icon_my_hover" id="g_iconregist">
                                <div class="nav_user">내 술잔</div>
                            </router-link>
                        </div>
                    </li>
                    <div class="nav_user_line"></div>
                    <li class="nav_item7">
                        <router-link to="/bag" @mouseover="openIconBag" @mouseleave="closeIconBag" @click="closeNavMini" class="nav_font">
                            <div class="nav_user_box">
                                <img src="/img/bag.png" class="nav_icon_bag" id="b_iconbag">
                                <img src="/img/goldbag.png" class="nav_icon_hover nav_icon_bag_hover" id="g_iconbag">
                                <div class="nav_user">장바구니</div>
                            </div>
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    
    <router-view></router-view>

    <!-- footer -->
     <footer>
        <div class="footer_team">
            <div class="footer_team_member">
                <p class="team_member_name">권성환</p>
                <p>#감사합니다</p>
            </div>
            <div class="footer_team_member">
                <p class="team_member_name">서보원</p>
                <p>#하..분명 됐었는데..?</p>
            </div>
            <div class="footer_team_member">
                <p class="team_member_name">유호경</p>
                <p>#될때_까지 #않이 #외않되</p>
            </div>
            <div class="footer_team_member">
                <p class="team_member_name">권민서</p>
                <p>#수고많으셨습니다</p>
            </div>
        </div>
        <div class="footer_line"></div>
        <div class="footer_info">
            <p class="footer_info1 footer_info_font">아카데미 정보</p>
            <p class="footer_info2 footer_info_font">그린컴퓨터아트학원 대구</p>
            <p class="footer_info3 footer_info_font">대구광역시 중구 중앙대로 394 제일빌딩 5F</p>
            <p class="footer_info4 footer_info_font">053.572.1005</p>
            <p class="footer_info5 footer_info_font">기업요구를 반영한 PHP풀스택(프론트앤드 + 백앤드) 개발자 양성 과정</p>
            <div class="footer_site footer_info_font">
                참고한 사이트
                <br>
                <br>
                <img src="/img/logo02.png">
                <img src="/img/logo03.gif">
                <img src="/img/logo04.png">
            </div>
        </div>
    </footer>
    
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Cookies from 'js-cookie';
    const showModal = ref(true);
    function closeModal() {
        // 쿠키에 자정까지 유효시간 부여
        const now = new Date();
        const midnight = new Date();
        midnight.setHours(24, 0, 0, 0); // 자정 설정
        const expires = (midnight.getTime() - now.getTime()) / (1000 * 60 * 60 * 24); // 자정까지 남은 시간(일 단위)

        Cookies.set('modalClosed', 'true', { expires });

        // 모달창 닫기
        const modal = document.querySelector('.modal');
        modal.style.display = 'none';

        // 스크롤 움직임 제어 css
        document.body.style.overflowY = 'scroll';
        document.body.style.height = '';

        showModal.value = false;
    }

    // alert 띄우기
    function openAlert() {
        alert('본 페이지는 만 19세 이상만 이용이 가능합니다.');
    }

    // 아이콘 호버시 색 변환
    function openIconLogin() {
        const g_iconuser = document.querySelector('#g_iconuser');
        const b_iconuser = document.querySelector('#b_iconuser');

        g_iconuser.classList.remove('nav_icon_hover');
        b_iconuser.style.display = 'none';
    }
    function closeIconLogin() {
        const g_iconuser = document.querySelector('#g_iconuser');
        const b_iconuser = document.querySelector('#b_iconuser');

        g_iconuser.classList.add('nav_icon_hover');
        b_iconuser.style.display = 'block';
    }
    function openIconRegist() {
        const g_iconregist = document.querySelector('#g_iconregist');
        const b_iconregist = document.querySelector('#b_iconregist');

        g_iconregist.classList.remove('nav_icon_hover');
        b_iconregist.style.display = 'none';
    }
    function closeIconRegist() {
        const g_iconregist = document.querySelector('#g_iconregist');
        const b_iconregist = document.querySelector('#b_iconregist');

        g_iconregist.classList.add('nav_icon_hover');
        b_iconregist.style.display = 'block';
    }
    function openIconBag() {
        const g_iconbag = document.querySelector('#g_iconbag');
        const b_iconbag = document.querySelector('#b_iconbag');

        g_iconbag.classList.remove('nav_icon_hover');
        b_iconbag.style.display = 'none';
    }
    function closeIconBag() {
        const g_iconbag = document.querySelector('#g_iconbag');
        const b_iconbag = document.querySelector('#b_iconbag');

        g_iconbag.classList.add('nav_icon_hover');
        b_iconbag.style.display = 'block';
    }
    
    // 스크린 1201px 이상일때 미니 메뉴바 호버시 이벤트
    function openMiniNav() {
        const nav_mini = document.querySelector('#nav_mini');
        nav_mini.classList.remove('display_none');
    }
    function closeMiniNav() {
        const nav_mini = document.querySelector('#nav_mini');
        nav_mini.classList.add('display_none');
    }

    // 햄버거 클릭시 이벤트
    function openNavMini() {
        const nav = document.querySelector('#nav');
        const hamburger = document.querySelector('#hamburger');
        const cancel = document.querySelector('#cancel');

        nav.removeAttribute('id', 'nav');
        hamburger.style.display = 'none'
        cancel.style.display = 'block'
        cancel.removeAttribute('class', 'cancel');
    }

    // X 클릭시 이벤트
    function closeNavMini() {
        const nav = document.querySelector('.nav');
        const hamburger = document.querySelector('#hamburger');
        const cancel = document.querySelector('#cancel');

        if(window.innerWidth > 1200){
            nav.setAttribute('id', 'nav');
            hamburger.style.display = 'none';
            cancel.setAttribute('class', 'cancel');
            cancel.style.display = 'none'
        }else if(window.innerWidth <= 1200) {
            nav.setAttribute('id', 'nav');
            hamburger.style.display = 'block';
            cancel.setAttribute('class', 'cancel');
            cancel.style.display = 'none'
        }
    }

    // 로고 클릭시 이벤트
    function logoclick() {
        const nav = document.querySelector('.nav');
        const hamburger = document.querySelector('#hamburger');
        const cancel = document.querySelector('#cancel');

        if(window.innerWidth > 1200){
            nav.setAttribute('id', 'nav');
            hamburger.style.display = 'none';
            cancel.setAttribute('class', 'cancel');
            cancel.style.display = 'none'
        }else if(window.innerWidth <= 1200) {
            nav.setAttribute('id', 'nav');
            hamburger.style.display = 'block';
            cancel.setAttribute('class', 'cancel');
            cancel.style.display = 'none'
        }

        window.location.href = '/';
    }

    // 스크린 크기 (width: 1200px) 변화에 따른 햄버거, X아이콘 조절
    function changeNav() {
        const nav = document.querySelector('.nav');
        const cancel = document.querySelector('#cancel');
        const hamburger = document.querySelector('#hamburger');
        const plus = document.querySelector('.plus');

        if(window.innerWidth > 1200) {
            nav.removeAttribute('id', 'nav');
            hamburger.style.display = 'none';
            cancel.style.display = 'none';
            plus.style.display = 'none';
        } else if(window.innerWidth <= 1200) {
            nav.setAttribute('id', 'nav');
            hamburger.style.display = 'block';
            cancel.style.display = 'none';
            plus.style.display = 'inline-block';
        }
    }
    onMounted(() => {
        window.addEventListener('resize', changeNav)

        // 페이지 로드 시 쿠키 확인 
        const modalClosed = Cookies.get('modalClosed');
        if (modalClosed === 'true') {
            // 모달 숨기기
            showModal.value = false; 
            const modal = document.querySelector('.modal');
            modal.style.display = 'none';
            document.body.style.overflowY = 'scroll';
            document.body.style.height = '';
        }
    })

    
</script>

<style>
    @import url('../css/common.css');
</style>
