// 이메일 유효성 검사
document.getElementById('email').addEventListener('input', function() {
    var email = this.value;
    var emailError = document.getElementById('emailError');
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        emailError.textContent = '이메일 주소가 형식에 맞지 않습니다.';
        emailError.classList.add('error');
    } else {
        emailError.textContent = '';
        emailError.classList.remove('error');
    }
});

// 비밀번호 유효성 검사
document.getElementById('password').addEventListener('input', function() {
    var password = this.value;
    var passwordError = document.getElementById('passwordError');
    console.log(password);
    if (password.length < 8) {
        passwordError.textContent = '비밀번호가 형식에 맞지 않습니다.';
        passwordError.classList.add('error');
    } else {
        passwordError.textContent = '';
        passwordError.classList.remove('error');
    }
});

{/* <p>{{ errorMsgPassword }}</p>
<input @change="chkPassword" /> */}

{/* <script setup>

const errorMsgPassword = ref('');

function chkPassword(e) {
    if (e.target.value.length < 8) {
        errorMsgPassword.value = '비밀번호가 형식에 맞지 않습니다.';
    } else {
        errorMsgPassword.value = '';
    }
}

</script> */}

// 비밀번호 확인 유효성 검사
document.getElementById('password_chk').addEventListener('input', function() {
    var password = document.getElementById('password').value;
    var passwordChk = this.value;
    var passwordChkError = document.getElementById('passwordChkError');
    if (password !== passwordChk) {
        passwordChkError.textContent = '비밀번호가 일치하지 않습니다.';
        passwordChkError.classList.add('error');
    } else {
        passwordChkError.textContent = '';
        passwordChkError.classList.remove('error');
    }
});

// 전화번호 유효성 검사
document.getElementById('phone').addEventListener('input', function() {
    var phone = this.value;
    var phoneError = document.getElementById('phoneError');
    var phonePattern = /^\d{3}-\d{3,4}-\d{4}$/;
    if (!phonePattern.test(phone)) {
        phoneError.textContent = '전화번호 형식에 맞지 않습니다.';
        phoneError.classList.add('error');
    } else {
        phoneError.textContent = '';
        phoneError.classList.remove('error');
    }
});

// 주소 유효성 검사
document.getElementById('address').addEventListener('input', function() {
    var address = this.value;
    var addressError = document.getElementById('addressError');
    if (address === '') {
        addressError.textContent = '주소를 입력해주세요.';
        addressError.classList.add('error');
    } else {
        addressError.textContent = '';
        addressError.classList.remove('error');
    }
});

// 생년월일 유효성 검사
document.getElementById('birth').addEventListener('input', function() {
    var birth = this.value;
    var birthError = document.getElementById('birthError');
    var birthDate = new Date(birth);
    var today = new Date();
    var age = today.getFullYear() - birthDate.getFullYear();
    var monthDifference = today.getMonth() - birthDate.getMonth();
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    if (age < 19) {
        birthError.textContent = '만 19세 이상만 가입이 가능합니다.';
        birthError.classList.add('error');
    } else {
        birthError.textContent = '';
        birthError.classList.remove('error');
    }
});

// 폼 제출 시 유효성 검사
document.getElementById('regist_form').addEventListener('submit', function(event) {
    var valid = true;

    var email = document.getElementById('email');
    var emailError = document.getElementById('emailError');
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email.value)) {
        emailError.textContent = '이메일 주소가 형식에 맞지 않습니다.';
        emailError.classList.add('error');
        valid = false;
    }

    var password = document.getElementById('password');
    var passwordError = document.getElementById('passwordError');
    if (password.value.length < 8) {
        passwordError.textContent = '비밀번호가 형식에 맞지 않습니다.';
        passwordError.classList.add('error');
        valid = false;
    }

    var passwordChk = document.getElementById('password_chk');
    var passwordChkError = document.getElementById('passwordChkError');
    if (password.value !== passwordChk.value) {
        passwordChkError.textContent = '비밀번호가 일치하지 않습니다.';
        passwordChkError.classList.add('error');
        valid = false;
    }

    var phone = document.getElementById('phone');
    var phoneError = document.getElementById('phoneError');
    var phonePattern = /^\d{10,11}$/;
    if (!phonePattern.test(phone.value)) {
        phoneError.textContent = '전화번호 형식에 맞지 않습니다.';
        phoneError.classList.add('error');
        valid = false;
    }

    var address = document.getElementById('address');
    var addressError = document.getElementById('addressError');
    if (address.value === '') {
        addressError.textContent = '주소를 입력해주세요.';
        addressError.classList.add('error');
        valid = false;
    }

    var birth = document.getElementById('birth');
    var birthError = document.getElementById('birthError');
    var birthDate = new Date(birth.value);
    var today = new Date();
    var age = today.getFullYear() - birthDate.getFullYear();
    var monthDifference = today.getMonth() - birthDate.getMonth();
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    if (age < 19) {
        birthError.textContent = '만 19세 이상만 가입이 가능합니다.';
        birthError.classList.add('error');
        valid = false;
    }

    if (!valid) {
        event.preventDefault();
    }
});