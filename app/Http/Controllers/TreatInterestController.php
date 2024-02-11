<?php

namespace App\Http\Controllers;

use App\Models\TreatInterest;
use App\Models\Treat;
use App\Http\Requests\StoreTreatInterestRequest;
use App\Http\Requests\UpdateTreatInterestRequest;
use Illuminate\Support\Facades\Auth;
// use DragonCode\Contracts\Cashier\Auth\Auth;

class TreatInterestController extends Controller
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
    public function store(StoreTreatInterestRequest $request, Treat $treat)
    {
        $treatId = $treat->id;
        $userId = Auth::user()->id;

        $guestUser = TreatInterest::create([
            'user_id' => $userId,
            'treat_id' => $treatId,
            'status' => 'pending',
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(TreatInterest $treatInterest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TreatInterest $treatInterest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTreatInterestRequest $request, TreatInterest $treatInterest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TreatInterest $treatInterest)
    {
        //
    }
}
