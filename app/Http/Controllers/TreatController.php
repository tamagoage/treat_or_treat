<?php

namespace App\Http\Controllers;

use App\Models\Treat;
use App\Models\TreatInterest;
use App\Models\GuestUser;
use App\Http\Requests\StoreTreatRequest;
use App\Http\Requests\UpdateTreatRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TreatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 自分のtreatsと他人のtreats(要修正)を取得
        $myTreats = Treat::where('user_id', Auth::id())->get();
        // 自分以外のすべてを取得しているため友達以外も含まれている
        $othersTreats = Treat::where('user_id', '!=', Auth::id())->get();
        return view('treats.index', compact('myTreats', 'othersTreats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 新規投稿画面を表示
        return view('treats.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTreatRequest $request)
    {
        // 全リクエストデータを取得
        $date = $request->all();

        // リクエストから画像ファイルを取得
        $image = $request->file('image');

        try {
            // 画像ファイルをS3にアップロードし、そのパスを取得
            $path = Storage::disk('s3')->putFile('treats', $image);

            // アップロードした画像のURLを取得
            $filePath = Storage::disk('s3')->url($path);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        // UUIDを生成してURLに設定
        $data['url'] = Str::uuid();

        // データベースに新しいTreatを作成
        $treat = Treat::create([
            'location_id' => $date['location_id'],
            'shelf_life_id' => $date['shelf_life_id'],
            'image' => $path,
            'name' => $date['name'],
            'made_date' => $date['made_date'],
            'pickup_deadline' => $date['pickup_deadline'],
            'url' => $data['url'],
            'user_id' => auth()->user()->id,
        ]);

        // リダイレクト
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Treat $treat)
    {
        // 選択されたtreatのidと同じものを取得
        $treat = Treat::query()->where('id', '=', $treat->id)->first();

        // 署名付きURLを取得
        $treat->image = Storage::disk('s3')->temporaryUrl(
            $treat->image,
            now()->addMinutes(60)
        );

        // treatのidに紐づくtreat_interest,guest_userを取得
        $treatInterests = TreatInterest::query()->where('treat_id', '=', $treat->id)->get();
        $guestUsers = GuestUser::query()->where('treat_id', '=', $treat->id)->get();

        // ログインユーザーの情報を取得
        $user = Auth::user();

        if ($user && $user->id === $treat->user_id) {
            // 投稿した本人の場合
            $userCategory = "author";

            return view('treats.show', compact('userCategory', 'treat', 'treatInterests', 'guestUsers'));
        } else if (!$user) {
            // ゲストユーザー(未ログイン)の場合
            // ゲストユーザーとDBに保存されているセッションIDを取得
            $currentUserSessionId = session()->getId();
            $guestUserSessionIds = $guestUsers->pluck('session_id');
            // 現在の閲覧者が既にguestUserに登録されているか確認
            $guestUserExists = $guestUserSessionIds->contains($currentUserSessionId);

            if ($guestUserExists) {
                // 存在する場合、そのステータスを取得
                $guestUserStatus = $guestUsers->where('session_id', $currentUserSessionId)->first();
            } else {
                // 存在しない場合、nullを代入
                $guestUserStatus = null;
            }

            return view('treats.show', compact('treat',  'guestUserExists', 'guestUserStatus'));
        } else {
            // 投稿した本人ではない場合(ログイン済みの場合)
            $userCategory = "interest";
            // treatInterestのuser_idを全て取得
            $treatInterestUserIds = $treatInterests->pluck('user_id');
            // 現在の閲覧者が既にtreatInterestに登録されているか確認
            $treatInterestExists = $treatInterestUserIds->contains($user->id);

            if ($treatInterestExists) {
                // 存在する場合、そのステータスを取得
                $treatInterestStatus = $treatInterests->where('user_id', $user->id)->first();
            } else {
                // 存在しない場合、nullを代入
                $treatInterestStatus = null;
            }

            dump($treatInterestExists);

            return view('treats.show', compact('userCategory', 'treat', 'treatInterestExists', 'treatInterestStatus'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Treat $treat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTreatRequest $request, Treat $treat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(treat $treat)
    {
        //
    }

    public function updateApprovalStatus(Request $request, Treat $treat)
    {
        $requestDate = $request->all();

        // TreatのIDを取得
        $treatId = $treat->id;

        // Treatに紐づく全てのGuestUserを取得
        foreach (GuestUser::where('treat_id', '=', $treatId)->get() as $guestUser) {
            // GuestUserのsession_idを取得
            $sessionIdOfModel = $guestUser->session_id;

            // トグルボタンの状態によって'status'を'approve'か'reject'に設定
            $status = isset($requestDate['guestUser'][$sessionIdOfModel]) ? 'approve' : 'reject';

            // チェックボックスがチェックされている場合は'status'を'pending'に設定
            if (isset($requestDate['guestUserPendingStatus'][$sessionIdOfModel])) {
                $status = 'pending';
            }

            // GuestUserの'status'を更新
            $guestUser->update([
                'status' => $status,
            ]);
        }

        // Treatに紐づく全てのTreatInterestを取得
        foreach (TreatInterest::where('treat_id', '=', $treatId)->get() as $treatInterest) {
            // TreatInterestのuser_idを取得
            $userIdOfModel = $treatInterest->user_id;

            // トグルボタンの状態によって'status'を'approve'か'reject'に設定
            $status = isset($requestDate['treatInterest'][$userIdOfModel]) ? 'approve' : 'reject';

            // チェックボックスがチェックされている場合は'status'を'pending'に設定
            if (isset($requestDate['treatInterestPendingStatus'][$userIdOfModel])) {
                $status = 'pending';
            }

            // TreatInterestの'status'を更新
            $treatInterest->update([
                'status' => $status,
            ]);
        }
    }
}
