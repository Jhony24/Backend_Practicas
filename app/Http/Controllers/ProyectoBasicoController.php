<?php

namespace App\Http\Controllers;

use App\Http\Models\ProyectoBasico;
use App\Http\Models\ProyectoMacro;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProyectoBasicoController extends Controller
{
    public function __construct()
    {
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $listado = DB::table('proyectobasico')
                ->join('proyectomacro','proyectobasico.idmacro','=',"proyectomacro.id")
                ->select('proyectobasico.*','proyectomacro.nombre_prmacro')
                ->get();
            return response()->json($listado, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Huno un error al listar losd atos de basico: '.$ex->getMessage()
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
            $proyectobasico = ProyectoBasico::create($request->all());
            return response()->json($proyectobasico,Response::HTTP_CREATED);
        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Huno un error al registrar losd atos de macro: '.$ex->getMessage()
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
            $proyectobasico = ProyectoBasico::find($id);
            return response()->json($proyectobasico,Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Huno un error al enconrar la basico =>'.$id.' : '.$ex->getMessage()
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
            $proyectobasico = ProyectoBasico::findOrFail($id);
            $proyectobasico->update($request->all());
            return response()->json($proyectobasico,Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Hubo un error al actualizar la basico =>'.$id.' : '.$ex->getMessage()
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
            ProyectoBasico::find($id)->delete();
            return response()->json([],Response::HTTP_OK);

        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Huno un error al eliminar la baisco =>'.$id.' : '.$ex->getMessage()
            ], 400);
        }
    }
}
