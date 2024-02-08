<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- その他のメタタグやスタイルシートのリンクなど -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!-- Open the modal using ID.showModal() method -->
    <button class="btn" onclick="my_modal_2.showModal()">open modal</button>
    <dialog id="my_modal_2" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Hello!</h3>
            <p class="py-4">Press ESC key or click outside to close</p>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</body>

</html>