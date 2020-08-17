<?php

namespace App\Http\Controllers;

use App\Http\Models\ProyectoMacro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProyectoMacroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $listado=ProyectoMacro::where('proyectomacro.idcarrera','=',Auth::user()->idcarrera)
                //->join('carreras','practicas.idcarrera','=','carreras.id')
                ->join('areas','proyectomacro.idarea','=','areas.id')
                ->select('proyectomacro.*','areas.nombrearea')
                ->get();
                return response()->json($listado, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Hubo un error al listar los datos de proyecto macro: '.$ex->getMessage()
            ], 206);
        }
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $macro = ProyectoMacro::create($request->all());
            return response()->json($macro,Response::HTTP_CREATED);
        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Hubo un error al registrar los datos del proyecto macro: '.$ex->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $macro = ProyectoMacro::find($id);
            $lista=$macro->basico;
            return response()->json($lista,Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Hubo un error al encontrar el proyecto macro =>'.$id.' : '.$ex->getMessage()
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $macro = ProyectoMacro::findOrFail($id);
            $macro->update($request->all());
            return response()->json($macro,Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Hubo un error al actualizar el proyecto macro =>'.$id.' : '.$ex->getMessage()
            ], 206);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            ProyectoMacro::find($id)->delete();
            return response()->json([],Response::HTTP_OK);

        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Hubo un error al eliminar el proyecto macro =>'.$id.' : '.$ex->getMessage()
            ], 400);
        }
    }
}
