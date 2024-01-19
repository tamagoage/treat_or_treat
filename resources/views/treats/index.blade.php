<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- その他のメタタグやスタイルシートのリンクなど -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <!-- ここに上記のコードを挿入 -->
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="myTreats-tab" data-toggle="tab" href="#myTreats" role="tab">My Treats</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="othersTreats-tab" data-toggle="tab" href="#othersTreats" role="tab">Others' Treats</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="myTreats" role="tabpanel">
                @foreach($myTreats as $treat)
                <p>{{ $treat->name }}</p>
                <p>{{ $treat->description }}</p>
                @endforeach
            </div>
            <div class="tab-pane fade" id="othersTreats" role="tabpanel">
                @foreach($othersTreats as $treat)
                <p>{{ $treat->name }}</p>
                <p>{{ $treat->description }}</p>
                @endforeach
            </div>
        </div>
        <a href="{{ route('treats.create') }}" class="btn btn-primary">Create</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>