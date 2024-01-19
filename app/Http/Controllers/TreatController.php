<?php

namespace App\Http\Controllers;

use App\Models\Treat;
use App\Http\Requests\StoretreatRequest;
use App\Http\Requests\UpdatetreatRequest;
use Illuminate\Support\Facades\Auth;

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

        $treat = Treat::create([
            'location_id' => $date['location_id'],
            'shelf_life_id' => $date['shelf_life_id'],
            'image' => $date['image'],
            'name' => $date['name'],
            'made_date' => $date['made_date'],
            'pickup_deadline' => $date['pickup_deadline'],
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(treat $treat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(treat $treat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatetreatRequest $request, treat $treat)
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
