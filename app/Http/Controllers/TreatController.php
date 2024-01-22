<?php

namespace App\Http\Controllers;

use App\Models\Treat;
use App\Models\ShelfLife;
use App\Models\Location;
use App\Models\TreatInterest;
use App\Models\GuestUser;
use App\Http\Requests\StoreTreatRequest;
use App\Http\Requests\UpdateTreatRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TreatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $myTreats = Treat::where('user_id', Auth::id())->get();
        $othersTreats = Treat::where('user_id', '!=', Auth::id())->get();
        return view('treats.index', compact('myTreats', 'othersTreats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('treats.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTreatRequest $request)
    {
        $date = $request->all();
        $data['image'] = "後でs3に保存するように変更する";
        $data['url'] = Str::uuid();

        $treat = Treat::create([
            'location_id' => $date['location_id'],
            'shelf_life_id' => $date['shelf_life_id'],
            'image' => $date['image'],
            'name' => $date['name'],
            'made_date' => $date['made_date'],
            'pickup_deadline' => $date['pickup_deadline'],
            'url' => $data['url'],
            'user_id' => auth()->user()->id,
        ]);

        // // その他から追加されたときShelfLifeやLocationにも挿入する
        // $shelfLife = ShelfLife::create([
        //     'treat_id' => $treat->id,
        //     'shelf_life' => $date['shelf_life_id'],
        //     'shelf_life_status' => 1,
        // ]);

        // $location = Location::create([
        //     'treat_id' => $treat->id,
        //     'location' => $date['location_id'],
        // ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Treat $treat)
    {
        // 選択されたtreatのidと同じものを取得
        $treat = Treat::query()->where('id', '=', $treat->id)->first();
        // treatのidに紐づくtreat_interestを取得
        $treatInterests = TreatInterest::query()->where('treat_id', '=', 1)->get();
        $guestUsers = GuestUser::query()->where('treat_id', '=', $treat->id)->get();

        $user = Auth::user();

        if ($user && $user->id === $treat->user_id) {
            // 投稿した本人の場合
            return view('treats.show', compact('treat', 'treatInterests', 'guestUsers'));
            // } else if (!$user) {
            //     // ゲストユーザーの場合
            //     // 不要？ゲストユーザーがsession_idを登録するボタンはviewで制御すればよい？
            //     return view('treats.show', compact('treat', 'user'));
        } else {
            // 投稿した本人ではない場合
            return view('treats.show', compact('treat'));
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
}
