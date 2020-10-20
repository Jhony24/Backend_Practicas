<?php

namespace App\Http\Controllers;

use App\Http\Models\Empresas;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class EmpresasController extends Controller
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
            $empresas = Empresas::join("carreras", "empresas.idcarrera", "=", "carreras.id")
            ->select('empresas.*', 'carreras.nombrecarreras')
            ->where('empresas.idcarrera', '=', Auth::user()->idcarrera)
            ->get();
            //$listado = Empresas::all();
            return response()->json($empresas,Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Huno un error al listar losd atos de empresas: '.$ex->getMessage()
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
        
    }

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
            'nombreempresa' => 'required|unique:empresas',
            'nombrerepresentante' => 'required|min:15|max:100',
            'ruc' => 'required|unique:empresas',
            'direccion' => 'required|min:20|max:150',
            'telefono'=>'required|unique:empresas',
            'correo'=>'email|unique:empresas',
            'actividades'=>'min:20|max:200'
        ]);
        try {
            $empresas = Empresas::create($request->all());
            return response()->json($empresas,Response::HTTP_CREATED);
        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Hubo un error al registrar los datos de empresas: '.$ex->getMessage()
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
            $empresas = Empresas::find($id);
            return response()->json($empresas, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Huno un error al enconrar la empresa =>'.$id.' : '.$ex->getMessage()
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
            $empresas = Empresas::findOrFail($id);
            $empresas->update($request->all());
            return response()->json($empresas,Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Huno un error al actualizar la empresa =>'.$id.' : '.$ex->getMessage()
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
            Empresas::find($id)->delete();
            return response()->json([],Response::HTTP_OK);

        } catch (Exception $ex) {
            return response()->json([
                'error'=>'Huno un error al eliminar la empresa =>'.$id.' : '.$ex->getMessage()
            ], 400);
        }
    }
}
