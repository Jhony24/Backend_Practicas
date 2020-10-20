<?php

namespace App\Http\Controllers;

use App\Http\Models\Areas;
use App\Http\Models\Carreras;
use App\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CarrerasController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
        //$this->middleware('role:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexR()
    {
        try {
            $listado = Carreras::all();
            return response()->json($listado, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al listar los datos de carreras: ' . $ex->getMessage()
            ], 206);
        }
    }
    public function index(Request $request)
    {
        if (Auth::check()) {
            if (!Auth::user()->isAdmin()) {
                $id = Auth::id();
                try {
                    $carreras = User::find($id);
                    $lista = $carreras->carreradeusuario;
                    return response()->json([$lista], Response::HTTP_OK);
                } catch (Exception $ex) {
                    return response()->json([
                        'error' => 'Huno un error al enconrar la carrera =>' . $id . ' : ' . $ex->getMessage()
                    ], 404);
                }
            } else {
                try {
                    $listado = Carreras::all();
                    return response()->json($listado, Response::HTTP_OK);
                } catch (Exception $ex) {
                    return response()->json([
                        'error' => 'Hubo un error al listar los datos de carreras: ' . $ex->getMessage()
                    ], 206);
                }
            }
        }


        //return response()->json(['carrera' =>  Carreras::all()], 200);
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
            $carreras = Carreras::create($request->all());
            return response()->json($carreras, Response::HTTP_CREATED);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al registrar los datos de carrras: ' . $ex->getMessage()
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
            $carreras = Carreras::find($id);
            $lista = $carreras->areas1;
            return response()->json($carreras, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al encontrar la carrera =>' . $id . ' : ' . $ex->getMessage()
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
            $carreras = Carreras::findOrFail($id);
            $carreras->update($request->all());
            return response()->json($carreras, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Huno un error al actualizar la carrera =>' . $id . ' : ' . $ex->getMessage()
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
            Carreras::find($id)->delete();
            return response()->json([], Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Huno un error al eliminar la carrera =>' . $id . ' : ' . $ex->getMessage()
            ], 400);
        }
    }
}
