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
    public function store(StoretreatRequest $request)
    {
        var_dump($request->all());
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
