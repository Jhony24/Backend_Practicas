<?php

namespace App\Http\Controllers;

use App\Http\Models\Usuario;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UsuarioController extends Controller
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
            $listado = DB::table('users')
                ->join('carreras','users.idcarrera','=',"carreras.id")
                ->select('users.*','carreras.nombrecarreras')
                ->get();
            return response()->json($listado, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Huno un error al listar losd atos de los usuarios: '.$ex->getMessage()
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
            $usuario = Usuario::create($request->all());
            return response()->json($usuario,Response::HTTP_CREATED);
        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Huno un error al registrar losd atos de areas: '.$ex->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {
            $usuario = Usuario::find($id);
            return response()->json($usuario,Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Huno un error al enconrar la area =>'.$id.' : '.$ex->getMessage()
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
            $areas = Usuario::findOrFail($id);
            $areas->update($request->all());
            return response()->json($areas,Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Huno un error al actualizar la area =>'.$id.' : '.$ex->getMessage()
            ], 206);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            Usuario::find($id)->delete();
            return response()->json([],Response::HTTP_OK);

        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Huno un error al eliminar la area =>'.$id.' : '.$ex->getMessage()
            ], 400);
        }
    }
}
