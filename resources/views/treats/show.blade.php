<?php
if (isset($treat)) {
    dump($treat->toArray());
}
if (isset($treatInterests)) {
    dump($treatInterests->toArray());
}
if (isset($guestUsers)) {
    dump($guestUsers->toArray());
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

        <form method="POST" action="{{ route('updateApprovalStatus', ['treat' => $treat->id]) }}">
            @csrf
            <!-- $guestUsersをforeachで出力 -->
            @if(isset($guestUsers))
            @foreach($guestUsers as $guestUser)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $guestUser->session_id }}</h5>
                    <p class="card-text">{{ $guestUser->nickname }}</p>
                    <label class="label cursor-pointer">
                        <input type="checkbox" class="toggle" name="guestUser[{{ $guestUser->session_id }}]" />
                    </label>
                    <label class="label cursor-pointer">
                        <span class="label-text">保留する</span>
                        <input type="checkbox" class="checkbox pendingStatus" id="guestUser[{{ $guestUser->session_id }}]" name="guestUserPendingStatus[{{ $guestUser->session_id }}]" />
                    </label>
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
                    <label class="label cursor-pointer">
                        <span class="label-text">Remember me</span>
                        <input type="checkbox" class="toggle" name="treatInterest[{{ $interest->user_id }}]" />
                    </label>
                    <label class="label cursor-pointer">
                        <span class="label-text">保留する</span>
                        <input type="checkbox" class="checkbox pendingStatus" id="treatInterest[{{ $interest->user_id }}]" name="treatInterestPendingStatus[{{ $interest->user_id }}]" />
                    </label>
                </div>
            </div>
            @endforeach
            @endif
            <button type="submit" class="btn">送信</button>
        </form>
    </div>
    <!-- layout確認 -->
    <input type="checkbox" class="toggle" />
    <input type="checkbox" checked="checked" class="checkbox" />

    <script>
        const pendingStatus = document.querySelectorAll('.pendingStatus');
        const pendingStatusName = Array.from(pendingStatus).map((element) => {
            return element.name;
        });

        // チェックボックスがcheckedのとき、toggleをdisabledにする
        pendingStatus.forEach((element) => {
            element.addEventListener('change', () => {
                const toggle = document.querySelector(`input[name="${element.id}"]`);
                if (element.checked) {
                    toggle.disabled = true;
                } else {
                    toggle.disabled = false;
                }
            });
        });
    </script>
</body>