<?php

namespace App\Http\Controllers;

use App\Models\Grados;
use App\Http\Requests\StoreGradosRequest;
use App\Http\Requests\UpdateGradosRequest;

class GradosController extends Controller
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
     * @param  \App\Http\Requests\StoreGradosRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGradosRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grados  $grados
     * @return \Illuminate\Http\Response
     */
    public function show(Grados $grados)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grados  $grados
     * @return \Illuminate\Http\Response
     */
    public function edit(Grados $grados)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGradosRequest  $request
     * @param  \App\Models\Grados  $grados
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGradosRequest $request, Grados $grados)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grados  $grados
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grados $grados)
    {
        //
    }
}
