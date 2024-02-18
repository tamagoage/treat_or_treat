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
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container">
        <!-- $treatの情報をカードで出力 -->
        @if(isset($treat))
        <div class="card w-96 bg-base-100 shadow-xl">
            <div class="card-body">
                <h5 class="card-title">{{ $treat->name }}</h5>
                <p class="card-text">{{ $treat->url }}</p>
                <!-- 画像を表示 -->
                <img src="{{ $treat->image }}" class="w-full h-auto rounded">
            </div>
        </div>
        @endif

        @if(isset($userCategory) && $userCategory === "interest")
        <!-- Interestに表示される画面 -->
        @if(!$treatInterestExists)
        <form method="POST" action="{{ route('treatInterestStore', ['treat' => $treat->id]) }}">
            @csrf
            <label class="label cursor-pointer">
                <input type="checkbox" class="toggle" name="interestApprovalBtn" />
            </label>
            <button type="submit" class="btn">送信</button>
        </form>
        @else
        <div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md flex items-center space-x-4">
            <div>
                <div class="text-xl font-medium text-black">userId: {{ $treatInterestStatus->user_id }}</div>
                <p class="text-gray-500">申請状況: {{ $treatInterestStatus->status }}</p>
            </div>
        </div>
        @endif
        <!-- Interest -->

        @elseif(!isset($userCategory))
        <!-- 未ログインユーザーに表示される画面 -->
        @if(!$guestUserExists)
        <form method="POST" action="{{ route('guestUserStore', ['treat' => $treat->id]) }}">
            @csrf
            <!-- モーダルの中身 -->
            <input type="checkbox" id="my_modal_7" class="modal-toggle" />
            <div class="modal" role="dialog">
                <div class="modal-box">
                    <h3 class="text-lg font-bold">Hello!</h3>
                    <input type="text" placeholder="Type here" name="nickname" id="nickname" class="input input-bordered w-full max-w-xs" />
                </div>
                <label class="modal-backdrop" for="my_modal_7">Close</label>
            </div>
            <!-- ここまで中身 -->
            <label class="label cursor-pointer">
                <input type="checkbox" class="toggle" name="approvalBtn" />
            </label>
            <button id="guestApplyBtn" type="submit" class="btn">送信</button>
        </form>
        @else
        <div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md flex items-center space-x-4">
            <div>
                <div class="text-xl font-medium text-black">ニックネーム: {{ $guestUserStatus->nickname }}</div>
                <p class="text-gray-500">申請状況: {{ $guestUserStatus->status }}</p>
            </div>
        </div>
        @endif
        <!-- 未ログインユーザー -->

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @endif

        <form method="POST" action="{{ route('updateApprovalStatus', ['treat' => $treat->id]) }}">
            @csrf
            <!-- $guestUsersをforeachで出力 -->
            @if(isset($guestUsers))
            @foreach($guestUsers as $guestUser)
            <div class="card w-96 bg-base-100 shadow-xl mt-5">
                <div class="card-body">
                    <h5 class="card-title">{{ $guestUser->nickname }}</h5>
                    <p class="card-text">{{ $guestUser->status }}</p>
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
            <div class="card w-96 bg-base-100 shadow-xl mt-5">
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

            @if(isset($guestUsers) || isset($treatInterests))
            <button type="submit" class="btn">送信</button>
            @endif
        </form>
    </div>

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


        // session_idが未登録ユーザーの処理
        @if(isset($guestUserExists) && !$guestUserExists)

        let guestApplyBtn = document.getElementById('guestApplyBtn');
        let openModalBtn;
        let nickname = document.getElementById('nickname');

        // ページの読み込み時にopenModalBtnに置き換え
        if (nickname.value.trim() === '') {
            guestApplyBtn.outerHTML = '<label id="openModalBtn" for="my_modal_7" class="btn">ニックネーム入力</label>';
            openModalBtn = document.getElementById('openModalBtn');
        }

        // テキストエリアの入力に応じて置き換え
        nickname.addEventListener('input', () => {
            if (nickname.value.trim() !== '') {
                if (openModalBtn) {
                    openModalBtn.outerHTML = '<button id="guestApplyBtn" type="submit" class="btn">送信</button>';
                    guestApplyBtn = document.getElementById('guestApplyBtn');
                    openModalBtn = null;
                }
            } else {
                if (guestApplyBtn) {
                    guestApplyBtn.outerHTML = '<label id="openModalBtn" for="my_modal_7" class="btn">ニックネーム入力</label>';
                    openModalBtn = document.getElementById('openModalBtn');
                    guestApplyBtn = null;
                }
            }
        });

        @endif
    </script>
</body>