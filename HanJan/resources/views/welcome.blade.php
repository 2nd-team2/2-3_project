<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        {{-- csrf 토큰 : 공격 방어하기 위해서 / resources/js/axios.js파일 추가--}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <title>HANJAN</title>
    </head>
    <body>
        <div id="app">
            <App-Component></App-Component>
        </div>
    </body>
</html>