<?php

namespace App\Http\Controllers;

use App\Http\Models\Ficticio;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class FicticioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $ficticio = Ficticio::select('ficticio.*')
                ->where('ficticio.idcarrera', '=', Auth::user()->idcarrera)
                ->get();
            //$listado = Empresas::all();
            return response()->json($ficticio, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Huno un error al listar los datos de ficticio: ' . $ex->getMessage()
            ], 206);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'idcarrera' => 'required',
            'nombreempresa' => 'required|min:20|max:200',
            'nombrearea' => 'required|min:10|max:100',
            'actividades' => 'min:20|max:200'
        ]);
        try {
            $ficticio = Ficticio::create($request->all());
            return response()->json($ficticio, Response::HTTP_CREATED);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al registrar los datos de ficticio: ' . $ex->getMessage()
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
            $ficticio = Ficticio::find($id);
            return response()->json($ficticio, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Huno un error al enconrar el ficticio =>' . $id . ' : ' . $ex->getMessage()
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
            $ficticio = Ficticio::findOrFail($id);
            $ficticio->update($request->all());
            return response()->json($ficticio, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Huno un error al actualizar la ficticio =>' . $id . ' : ' . $ex->getMessage()
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
            Ficticio::find($id)->delete();
            return response()->json([], Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Huno un error al eliminar la ficticio =>' . $id . ' : ' . $ex->getMessage()
            ], 400);
        }
    }
}
