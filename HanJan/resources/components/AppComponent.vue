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
    <router-view></router-view>
    <!-- 스와이퍼 -->
    <swiper
        :spaceBetween="30"
        :centeredSlides="true"
        :autoplay="{
        delay: 2500,
        disableOnInteraction: false,
        }"
        :pagination="{
        clickable: true,
        }"
        :navigation="true"
        :modules="modules"
        class="mySwiper"
    >
        <swiper-slide>
            <div class="swiper_box">
                <img src="/img/swiper1.png" class="swiper_img">
                <div class="swiper_content">
                    <h1 class="swiper_title">11%</h1>
                    <h1 class="swiper_title2">싱싱한 감귤의 맛과 향,</h1>
                    <h1 class="swiper_title2 swiper_title_weight">니모메</h1>
                    <h2 class="swiper_title3">제주샘주가 정성껏 빛은 좋은술,</h2>
                    <h2 class="swiper_title3">니모메의 고유한 맛을 즐겨보세요.</h2>
                    <a href="" class="swiper_show">보러가기</a>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide>
            <div class="swiper_box">
                <img src="/img/swiper2.png" class="swiper_img">
                <div class="swiper_content">
                    <h1 class="swiper_title">6%</h1>
                    <h1 class="swiper_title2">흑당 밀크티를 먹은 듯,</h1>
                    <h1 class="swiper_title2 swiper_title_weight">스파클링 오디 별산</h1>
                    <h2 class="swiper_title3">파이나 머핀처럼 손으로 간편하게</h2>
                    <h2 class="swiper_title3">집어 먹을 수 있는 빵과 즐겨보세요.</h2>
                    <a href="" class="swiper_show">보러가기</a>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide>
            <div class="swiper_box">
                <img src="/img/swiper3.png" class="swiper_img">
                <div class="swiper_content">
                    <h1 class="swiper_title">6%</h1>
                    <h1 class="swiper_title2">시원한 청량감과 부드럽고 달콤한 맛</h1>
                    <h1 class="swiper_title2 swiper_title_weight">구름을 벗삼아</h1>
                    <h2 class="swiper_title3">유기농 햇찹쌀, 전통누룩, 천연 암반수</h2>
                    <h2 class="swiper_title3">매콤한 음식과 찰떡궁합</h2>
                    <a href="" class="swiper_show">보러가기</a>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide>
            <div class="swiper_box">
                <img src="/img/swiper4.png" class="swiper_img">
                <div class="swiper_content">
                    <h1 class="swiper_title">16%</h1>
                    <h1 class="swiper_title2">짙은 달콤한 포도 주스향,</h1>
                    <h1 class="swiper_title2 swiper_title_weight">무주 구천동 산머루주</h1>
                    <h2 class="swiper_title3">풍미가 진하지 않고 가볍게</h2>
                    <h2 class="swiper_title3">즐길 수 있는 안주를 추천합니다.</h2>
                    <a href="" class="swiper_show">보러가기</a>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide>
            <div class="swiper_box">
                <img src="/img/swiper5.png" class="swiper_img">
                <div class="swiper_content">
                    <h1 class="swiper_title">25%</h1>
                    <h1 class="swiper_title2">매실의 달콤한 풍미,</h1>
                    <h1 class="swiper_title2 swiper_title_weight">서울의 밤</h1>
                    <h2 class="swiper_title3">생선회나 샤브샤브처럼</h2>
                    <h2 class="swiper_title3">담백한 음식과 함께 하시길 추천합니다.</h2>
                    <a href="" class="swiper_show">보러가기</a>
                </div>
            </div>
        </swiper-slide>
    </swiper>

    <!-- 전통주 이야기 -->
    <div class="alcohol_story">
        <div class="alcohol_story_title">
            <h1>우리는 왜</h1>
            <h1>한국 전통술을 알리고자 하는가?</h1>
        </div>
        <img class="alcohol_story_img" src="/img/alcohol.png"></img>
        <img class="alcohol_story_img2" src="/img/hangari.png"></img>
        <div class="alcohol_story_content">
            <p>우리는 전통술의 발전을 통해 지역 경제를 활성화하고, 나아가 세계 10위의 경제대국에 걸맞는 한국 술의 문화 상품화에 작은 보탬이 되고자 합니다.</p>
        </div>
    </div>

    <!-- 날씨 추천 술 -->
    <div class="weather_alcohol">
        <h1 class="weather_alcohol_title">오늘의 날씨와 맞는 술은?</h1>
        <div class="weather_alcohol_box">
            <img src="/img/alcohol1.jpeg" class="weather_alcohol_img">
            <h1 class="weather_alcohol_num">01</h1>
            <h1 class="weather_alcohol_name">고도리 샤인머스캣 와인</h1>
            <div class="weather_alcohol_type">과실주 10.5%</div>
            <a href="" class="weather_alcohol_a">바로가기</a>
        </div>
        <div class="weather_alcohol_box2">
            <h1 class="weather_alcohol_num">01</h1>
            <h1 class="weather_alcohol_name">고도리 샤인머스캣 와인</h1>
            <div class="weather_alcohol_type">과실주 10.5%</div>
            <a href="" class="weather_alcohol_a">바로가기</a>
            <img src="/img/alcohol1.jpeg" class="weather_alcohol_img">
        </div>
        <div class="weather_alcohol_box">
            <img src="/img/alcohol1.jpeg" class="weather_alcohol_img">
            <h1 class="weather_alcohol_num">01</h1>
            <h1 class="weather_alcohol_name">고도리 샤인머스캣 와인</h1>
            <div class="weather_alcohol_type">과실주 10.5%</div>
            <a href="" class="weather_alcohol_a">바로가기</a>
        </div>
        <div class="weather_alcohol_box2 weather_none">
            <h1 class="weather_alcohol_num">01</h1>
            <h1 class="weather_alcohol_name">고도리 샤인머스캣 와인</h1>
            <div class="weather_alcohol_type">과실주 10.5%</div>
            <a href="" class="weather_alcohol_a">바로가기</a>
            <img src="/img/alcohol1.jpeg" class="weather_alcohol_img">
        </div>
        <div class="weather_alcohol_box">
            <img src="/img/alcohol1.jpeg" class="weather_alcohol_img">
            <h1 class="weather_alcohol_num">01</h1>
            <h1 class="weather_alcohol_name">고도리 샤인머스캣 와인</h1>
            <div class="weather_alcohol_type">과실주 10.5%</div>
            <a href="" class="weather_alcohol_a">바로가기</a>
        </div>
        <div class="weather_alcohol_box2">
            <h1 class="weather_alcohol_num">01</h1>
            <h1 class="weather_alcohol_name">고도리 샤인머스캣 와인</h1>
            <div class="weather_alcohol_type">과실주 10.5%</div>
            <a href="" class="weather_alcohol_a">바로가기</a>
            <img src="/img/alcohol1.jpeg" class="weather_alcohol_img">
        </div>
        <div class="weather_alcohol_box">
            <img src="/img/alcohol1.jpeg" class="weather_alcohol_img">
            <h1 class="weather_alcohol_num">01</h1>
            <h1 class="weather_alcohol_name">고도리 샤인머스캣 와인</h1>
            <div class="weather_alcohol_type">과실주 10.5%</div>
            <a href="" class="weather_alcohol_a">바로가기</a>
        </div>
        <div class="weather_alcohol_box2 weather_none">
            <h1 class="weather_alcohol_num">01</h1>
            <h1 class="weather_alcohol_name">고도리 샤인머스캣 와인</h1>
            <div class="weather_alcohol_type">과실주 10.5%</div>
            <a href="" class="weather_alcohol_a">바로가기</a>
            <img src="/img/alcohol1.jpeg" class="weather_alcohol_img">
        </div>
    </div>

    <!-- 리뷰 -->
    <div class="review_container">
        <h1 class="review">한잔 리뷰</h1>
        <div class="review_box">
            <img src="/img/alcohol2.jpeg" class="goods_img">
            <h1 class="review_title">리뷰 제목</h1>
            <P class="review_content">여자들이 좋아할 맛 그런데 저한테도 깔끔한 맛 정도</P>
            <a href="" class="review_a">
                <div class="goods_title">제주, 동백 제주, 동백 제주, 동백</div>
                <div class="goods_read">자세히 보기</div>
            </a>
        </div>
        <div class="review_box">
            <img src="/img/alcohol2.jpeg" class="goods_img">
            <h1 class="review_title">리뷰 제목</h1>
            <P class="review_content">여자들이 좋아할 맛 그런데 저한테도 깔끔한 맛 정도</P>
            <a href="" class="review_a">
                <div class="goods_title">제주, 동백</div>
                <div class="goods_read">자세히 보기</div>
            </a>
        </div>
        <div class="review_box">
            <img src="/img/alcohol2.jpeg" class="goods_img">
            <h1 class="review_title">리뷰 제목</h1>
            <div class="review_content">
                가나다라마바사아자차카타파하가나다라마바사아자차카타파하가나다라마바사아자차카타파하가나다라마바사아자차카타파하가나다라마바사아자차카타파하가나다라마바사아자차카타파하가나다라마바사아자차카타파하가나다라마바사아자차카타파하
            </div>
            <a href="" class="review_a">
                <div class="goods_title">제주, 동백</div>
                <div class="goods_read">자세히 보기</div>
            </a>
        </div>
        <div class="review_box review_none">
            <img src="/img/alcohol2.jpeg" class="goods_img">
            <h1 class="review_title">리뷰 제목</h1>
            <P class="review_content">여자들이 좋아할 맛 그런데 저한테도 깔끔한 맛 정도</P>
            <a href="" class="review_a">
                <div class="goods_title">제주, 동백</div>
                <div class="goods_read">자세히 보기</div>
            </a>
        </div>
    </div>

    <!-- 공지사항 -->
    <div class="notification_container">
        <a href="" class="notification">공지사항 +</a>
        <a href="" class="notification_a">
            <div class="notification_title">공지 제목</div>
            <div class="notification_date">2024-06-04</div>
        </a>
        <a href="" class="notification_a">
            <div class="notification_title">공지 제목</div>
            <div class="notification_date">2024-06-04</div>
        </a>
        <a href="" class="notification_a">
            <div class="notification_title">공지 제목</div>
            <div class="notification_date">2024-06-04</div>
        </a>
        <a href="" class="notification_a">
            <div class="notification_title">공지 제목</div>
            <div class="notification_date">2024-06-04</div>
        </a>
        <a href="" class="notification_a">
            <div class="notification_title">공지 제목</div>
            <div class="notification_date">2024-06-04</div>
        </a>
        <a href="" class="notification_a">
            <div class="notification_title">공지 제목</div>
            <div class="notification_date">2024-06-04</div>
        </a>
        <a href="" class="notification_a">
            <div class="notification_title">공지 제목</div>
            <div class="notification_date">2024-06-04</div>
        </a>
    </div>

    <!-- move top -->
    <a href="#" class="move_top">
        <img src="/img/up.png" class="move_top_img">
    </a>

    <!-- footer -->
     <footer>
        <div class="footer_team">
            <div class="footer_team_member">
                <p class="team_member_name">권성환</p>
                <p>간단한 소개</p>
            </div>
            <div class="footer_team_member">
                <p class="team_member_name">서보원</p>
                <p>간단한 소개</p>
            </div>
            <div class="footer_team_member">
                <p class="team_member_name">유호경</p>
                <p>간단한 소개</p>
            </div>
            <div class="footer_team_member">
                <p class="team_member_name">권민서</p>
                <p>간단한 소개</p>
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
            </div>
        </div>
     </footer>
    
</template>

<script setup>
import { onMounted } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';

    // 모달창 닫기 + 스크롤 움직임 제어
    function closeModal() {
        const modal = document.querySelector('.modal');
        modal.style.display = 'none';
        document.body.style.overflow = 'scroll';
        document.body.style.height = '';
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
    })

    // 스와이퍼
    const modules = [Autoplay, Pagination, Navigation];

</script>

<style>
    @import url('../css/common.css');
</style>
