<template>
    <!-- 모달 -->
    <div class="modal">
        <div class="modal_img_box">
            <!-- <img src="/img/age19.png" class="modal_img"> -->
        </div>
        <button @click="closeModal" class="btn_yes">YES</button>
        <button @click="openAlert" class="btn_no">NO</button>

    </div>
    <!-- header -->
    <header>
        <div class="header_container">
            <div class="header_content">
                <div class="logo"><a href=""><img src="/img/logo.png" class="logo"></a></div>
                <div @click="clickHamburger" class="hamburger" id="hamburger"><img src="/img/hamburger.png" class="hamburger_img"></div>
                <div @click="clickCancel" class="cancel" id="cancel"><img src="/img/cancel.png" class="cancel_img"></div>
                <ul class="nav" id="nav">
                    <li class="nav_box nav_item1">
                        <a @mouseover="openMiniNav" @mouseleave="closeMiniNav" href="" class="nav_font">
                            전체 메뉴 <span class="plus"> + </span>
                            <div class="nav_mini display_none" id="nav_mini">
                                <ul class="nav_mini_title">
                                    <li class="nav_mini_item1"><a href="" class="nav_mini_font">탁주</a></li>
                                    <li class="nav_mini_item2"><a href="" class="nav_mini_font">과실주</a></li>
                                    <li class="nav_mini_item3"><a href="" class="nav_mini_font">증류주</a></li>
                                </ul>
                            </div>
                        </a>
                    </li>
                    <li class="nav_box nav_item2">
                        <a href="" class="nav_font ">
                            전통주 이야기
                        </a>
                    </li>
                    <li class="nav_box nav_item4">
                        <a href=""  class="nav_font">
                            공지사항
                        </a>
                    </li>
                    <li class="nav_item5">
                        <a @mouseover="openIconLogin" @mouseleave="closeIconLogin" href="" class="nav_font">
                            <div class="nav_user_box">
                                <img src="/img/login.png" class="nav_icon" id="b_iconuser">
                                <img src="/img/goldlogin.png" class="nav_icon_hover" id="g_iconuser">
                                <div class="nav_user">로그인</div>
                            </div>
                        </a> 
                    </li>
                    <div class="nav_user_line"></div>
                    <li class="nav_item6">
                        <a @mouseover="openIconRegist" @mouseleave="closeIconRegist" href="" class="nav_font">
                            <div class="nav_user_box">
                                <img src="/img/regist.png" class="nav_icon" id="b_iconregist">
                                <img src="/img/goldregist.png" class="nav_icon_hover" id="g_iconregist">
                                <div class="nav_user">회원가입</div>
                            </div>
                        </a>
                    </li>
                    <div class="nav_user_line"></div>
                    <li class="nav_item7">
                        <a @mouseover="openIconBag" @mouseleave="closeIconBag" href="" class="nav_font">
                            <div class="nav_user_box">
                                <img src="/img/bag.png" class="nav_icon" id="b_iconbag">
                                <img src="/img/goldbag.png" class="nav_icon_hover" id="g_iconbag">
                                <div class="nav_user">장바구니</div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- 스와이퍼 -->
    <div class="swiper_box">
        <img src="/img/swiper1.png" class="swiper_img">
        <div class="swiper_content">
            <h1 class="swiper_title">11%</h1>
            <h1 class="swiper_title2">싱싱한 감귤의 맛과 향,</h1>
            <h1 class="swiper_title2 swiper_title_weight">니모메</h1>
            <h2 class="swiper_title3">제주샘주가 정성껏 빛은 좋은술,</h2>
            <h2 class="swiper_title3">니모메의 고유한 맛을 즐겨보세요</h2>
            <a href="" class="swiper_show">보러가기</a>
        </div>
        <img src="/img/left.png" class="swiper_left_icon">
        <img src="/img/right.png" class="swiper_right_icon">
    </div>
    
</template>

<script setup>
import { onMounted } from 'vue';
    // 모달창 닫기
    function closeModal() {
        const modal = document.querySelector('.modal');
        modal.style.display = 'none';
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
    function clickHamburger() {
        const nav = document.querySelector('#nav');
        const hamburger = document.querySelector('#hamburger');
        const cancel = document.querySelector('#cancel');

        nav.removeAttribute('id', 'nav');
        hamburger.style.display = 'none'
        cancel.style.display = 'block'
        cancel.removeAttribute('class', 'cancel');
    }

    // X 클릭시 이벤트
    function clickCancel() {
        const nav = document.querySelector('.nav');
        const hamburger = document.querySelector('#hamburger');
        const cancel = document.querySelector('#cancel');

        nav.setAttribute('id', 'nav');
        hamburger.style.display = 'block';
        cancel.setAttribute('class', 'cancel');
        cancel.style.display = 'none'
    }

    // 스크린 크기 (width: 770px) 변화에 따른 햄버거, X아이콘 조절
    function changeNav() {
        const nav = document.querySelector('.nav');
        const cancel = document.querySelector('#cancel');
        const hamburger = document.querySelector('#hamburger');
        const plus = document.querySelector('.plus');

        if(window.innerWidth > 770) {
            nav.removeAttribute('id', 'nav');
            hamburger.style.display = 'none';
            cancel.style.display = 'none';
            plus.style.display = 'none';
        } else if(window.innerWidth <= 770) {
            nav.setAttribute('id', 'nav');
            hamburger.style.display = 'block';
            cancel.style.display = 'none';
            plus.style.display = 'inline-block';
        }
    }
    onMounted(() => {
        window.addEventListener('resize', changeNav)
    })

    // 스와이퍼

</script>

<style>
    @import url('../css/common.css');
</style>
