<?php

namespace App\Http\Controllers;

use App\Models\GuestUser;
use App\Models\Treat;
use App\Http\Requests\StoreGuestUserRequest;
use App\Http\Requests\UpdateGuestUserRequest;

class GuestUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGuestUserRequest $request, Treat $treat)
    {
        $data = $request->all();
        dump($data);
        $treat_id = $treat->id;
        // 閲覧者(未登録ユーザー)のセッションIDを取得
        $sessionId = $request->session()->getId();

        $guestUser = GuestUser::create([
            'nickname' => $data['nickname'],
            'session_id' => $sessionId,
            'treat_id' => $treat_id,
            // 規定値をpendingに設定
            'status' => 'pending',
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(GuestUser $guestUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuestUser $guestUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGuestUserRequest $request, GuestUser $guestUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuestUser $guestUser)
    {
        //
    }
}
