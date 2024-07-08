<!DOCTYPE html>
<html>
<head>
    <title>이메일 인증</title>
</head>
<body>
    <p>다음 링크를 클릭하여 이메일 인증을 완료해 주세요:</p>
    <a href="{{ url('/verify/' . $token) }}">이메일 인증</a>
</body>
</html>