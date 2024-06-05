<template>
    <!-- header -->
    <header>
        <div class="header_container">
            <div class="header_content">
                <div class="logo"><a href=""><img src="/img/logo.png" class="logo"></a></div>
                <ul class="nav">
                    <li class="nav_box">
                        <a href="" class="nav_font">전체 메뉴
                            <div @mouseover="openMiniNav()" class="nav_mini" id="nav_mini">
                                <ul class="nav_mini_title">
                                    <li><a href="" class="nav_mini_font">탁주</a></li>
                                    <li><a href="" class="nav_mini_font">과실주</a></li>
                                    <li><a href="" class="nav_mini_font">증류주</a></li>
                                </ul>
                            </div>
                        </a>
                    </li>
                    <li class="nav_box">
                        <a href="" class="nav_font">
                            전통주 이야기
                        </a>
                    </li>
                    <li class="nav_box">
                        <a href="" class="nav_font">
                            1 : 1 문의
                        </a>
                    </li>
                    <li class="nav_box">
                        <a href=""  class="nav_font">
                            공지사항
                        </a>
                    </li>
                    <li>
                        <a href="" class="nav_font nav_user_box">
                            <img src="/img/login.png" class="nav_icon">
                            <img src="/img/goldlogin.png" class="nav_icon_hover">
                            <div class="nav_user">로그인</div>
                        </a>
                    </li>
                    <li>
                        <a href="" class="nav_font nav_user_box">
                            <img src="/img/regist.png" class="nav_icon">
                            <img src="/img/goldregist.png" class="nav_icon_hover">
                            <div class="nav_user">회원가입</div>
                        </a>
                    </li>
                    <li>
                        <a href="" class="nav_font nav_user_box">
                            <img src="/img/bag.png" class="nav_icon">
                            <img src="/img/goldbag.png" class="nav_icon_hover">
                            <div class="nav_user">장바구니</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
</template>

<script setup>
    function openMiniNav() {
        
    }
</script>

<style>
    @import url('../css/common.css');
</style>
