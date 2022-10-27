<?php

namespace App\Http\Controllers;

use App\Models\Cafeteria;
use App\Http\Requests\StoreCafeteriaRequest;
use App\Http\Requests\UpdateCafeteriaRequest;

class CafeteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCafeteriaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCafeteriaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cafeteria  $cafeteria
     * @return \Illuminate\Http\Response
     */
    public function show(Cafeteria $cafeteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cafeteria  $cafeteria
     * @return \Illuminate\Http\Response
     */
    public function edit(Cafeteria $cafeteria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCafeteriaRequest  $request
     * @param  \App\Models\Cafeteria  $cafeteria
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCafeteriaRequest $request, Cafeteria $cafeteria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cafeteria  $cafeteria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cafeteria $cafeteria)
    {
        //
    }
}
