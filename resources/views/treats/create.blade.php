<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- その他のメタタグやスタイルシートのリンクなど -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <!-- treatを投稿 'location_id',
        'shelf_life_id',
        'image',
        'name',
        'made_date',
        'pickup_deadline'をフォームに入力 -->

    <div class="container">
        <form action="{{ route('treats.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="location_id">Location</label>
                <select class="form-control" id="location_id" name="location_id">
                    <!-- セレクトと自由記述を共存させたい -->
                    <option value="1">自宅</option>
                    <option value="2">学校</option>
                    <option value="3">駅</option>
                </select>
            </div>
            <div class="form-group">
                <label for="shelf_life_id">Shelf Life</label>
                <input class="form-control" id="shelf_life_id" name="shelf_life_id" type="date">
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input class="form-control" id="image" name="image" type="file">
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" id="name" name="name" type="text">
            </div>
            <div class="form-group">
                <label for="made_date">Made Date</label>
                <input class="form-control" id="made_date" name="made_date" type="date">
            </div>
            <div class="form-group">
                <label for="pickup_deadline">Pickup Deadline</label>
                <input class="form-control" id="pickup_deadline" name="pickup_deadline" type="date">
            </div>
            <button class="btn btn-primary" type="submit">Submit</button>
        </form>
</body>

</html>