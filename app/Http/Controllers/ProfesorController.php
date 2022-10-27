<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use App\Http\Requests\StoreProfesorRequest;
use App\Http\Requests\UpdateProfesorRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ProfesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $profesor = Profesor::all();
        return Inertia::render('personas/Profesores', compact('profesor'));
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
    public function profesoresapi()
    {
        $profesores = Profesor::all();
        return response()->json([
            $profesores
        ], Response::HTTP_OK);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProfesorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'lastname' => 'required',
            'age' => 'required|numeric',
            'gender' => 'required',
            'course' => 'required',
        ]);

        $profesores = new Profesor([
            'name' => $request->input('name'),
            'lastname' => $request->input('lastname'),
            'age' => $request->input('age'),
            'gender' => $request->input('gender'),
            'course' => $request->input('course')
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $mivalidated = $validator->validated();

            return $mivalidated;
        } else {
            $profesores->save();
            return response()->json(["message" => "Guardado con éxito", "ejecuccion" => true, $profesores]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profesor  $profesor
     * @return \Illuminate\Http\Response
     */
    public function show(Profesor $profesor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profesor  $profesor
     * @return \Illuminate\Http\Response
     */
    public function edit(Profesor $profesor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProfesorRequest  $request
     * @param  \App\Models\Profesor  $profesor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfesorRequest $request, Profesor $profesor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profesor  $profesor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profesor $profesor)
    {
        //
    }
}
