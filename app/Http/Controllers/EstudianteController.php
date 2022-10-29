<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Http\Requests\StoreEstudianteRequest;
use App\Http\Requests\UpdateEstudianteRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $estudiante = Estudiante::all();
        return Inertia::render('personas/Estudiantes', compact('estudiante'));
    }
    public function example()
    {
        //
        $example = Estudiante::all();
        return Inertia::render('personas/Example', compact('example'));
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
    public function estudiantesapi()
    {
        $estudiantes = Estudiante::all();
        return response()->json([
            $estudiantes
        ], Response::HTTP_OK);
    }
    public function editarestudiante($id)
    {
        $estudiante_id = Estudiante::find($id);
        return response()->json([
            $estudiante_id
        ], Response::HTTP_OK);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEstudianteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'lastname' => 'required',
            'age' => 'required|numeric',
            'gender' => 'required'
        ]);

        $estudiantes = new Estudiante([
            'name' => $request->input('name'),
            'lastname' => $request->input('lastname'),
            'age' => $request->input('age'),
            'gender' => $request->input('gender')
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $mivalidated = $validator->validated();

            return $mivalidated;
        } else {
            $estudiantes->save();
            return response()->json(["message" => "Guardado con éxito", "ejecuccion" => true, $estudiantes]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function show(Estudiante $estudiante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function edit(Estudiante $estudiante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEstudianteRequest  $request
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //dd($request->id);
        $estudiante = Estudiante::find($request->id);
        $estudiante->update($request->all());
        return response()->json(['success' => 'Actualizado correctamente.', 'ejecucion' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estudiante $estudiante, Request $request)
    {
        //
        $estudiantes = Estudiante::find($request->id);
        $estudiantes->delete();
        return response()->json(['success' => 'Eliminado correctamente.', 'ejecucion' => true]);
    }
}
