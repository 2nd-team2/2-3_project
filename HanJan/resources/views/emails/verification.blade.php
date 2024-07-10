<!DOCTYPE html>
<html>
<head>
    <title>이메일 인증</title>
</head>
<body>
    <p>아래 링크를 클릭하여 이메일 검증을 완료해 주세요:</p>
    <a href="{{ url('/verify/' . $token) }}">이메일 검증</a>
</body>
</html>