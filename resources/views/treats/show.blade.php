<?php
if (isset($treat)) {
    dump($treat);
}
if (isset($treatInterests)) {
    dump($treatInterests);
}
if (isset($guestUsers)) {
    dump($guestUsers);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- その他のメタタグやスタイルシートのリンクなど -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container">
        <!-- $treatの情報をカードで出力 -->
        @if(isset($treat))
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $treat->name }}</h5>
                <p class="card-text">{{ $treat->url }}</p>
            </div>
        </div>
        @endif

        <!-- $guestUsersをforeachで出力 -->
        @if(isset($guestUsers))
        @foreach($guestUsers as $guestUser)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $guestUser->session_id }}</h5>
                <p class="card-text">{{ $guestUser->nickname }}</p>
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">Remember me</span>
                        <input type="checkbox" class="toggle" />
                    </label>
                </div>
            </div>
        </div>
        @endforeach
        @endif

        <!-- $treatInterestをforeachで出力 -->
        @if(isset($treatInterests))
        @foreach($treatInterests as $interest)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $interest->user_id }}</h5>
                <p class="card-text">{{ $interest->status }}</p>
            </div>
            <div class="form-control">
                <label class="label cursor-pointer">
                    <span class="label-text">Remember me</span>
                    <input type="checkbox" class="toggle" />
                </label>
            </div>
        </div>
        @endforeach
        @endif
    </div>
    <!-- 以下、既存のコード -->
</body>