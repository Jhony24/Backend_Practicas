<?php

namespace App\Http\Controllers;

use App\Http\Models\Convenio;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ConveniosController extends Controller
{

    public function __construct()
    { }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {
            $listado = Convenio::join('empresas', 'convenio.idempresa', '=', 'empresas.id')
                ->join('carreras', 'convenio.idcarrera', '=', 'carreras.id')
                ->select('convenio.*', 'empresas.nombreempresa', 'carreras.nombrecarreras')
                ->where('convenio.idcarrera', '=', Auth::user()->idcarrera)
                ->get();
            return response()->json($listado, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al listar los datos de convenios: ' . $ex->getMessage()
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
        $validator =
            Validator::make($request->all(), [
                'idempresa' => 'required',
                'idcarrera' => 'required',
                'fecha_inicio'=>'required',
                'fecha_culminacion' =>'min:5|max:20',
                'objeto'=>'required|min:20|max:200'
            ]);

        if ($validator->fails()) {
            return response($validator->errors()->all(), 422);
        }
        try {
            /*if($request->hasFile('archivo_convenio')){
                $file = $request->file('archivo_convenio');
                $name = time().$file->getClientOriginalName();
                $file->move(public_path().'/convenios/',$name);
            }*/

            $convenios = new Convenio();
            $convenios->tipo_convenio= $request->input('tipo_convenio');
            $convenios->idempresa= $request->input('idempresa');
            $convenios->idcarrera= $request->input('idcarrera');
            $convenios->fecha_inicio= $request->input('fecha_inicio');
            $convenios->fecha_culminacion= $request->input('fecha_culminacion');
            $convenios->estado_convenio= $request->input('estado_convenio');
            $convenios->objeto= $request->input('objeto');
            $convenios->externalid_convenio= $request->input('externalid_convenio');
            
            //$convenios->archivo_convenio=$name;
            $convenios->save();

            return response()->json($convenios, Response::HTTP_CREATED);


            //return $request;
            //$convenios->save();
            //$convenios = Convenio::create($request->all());
            //return response()->json($convenios, Response::HTTP_CREATED);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al registrar los datos de convenios: ' . $ex->getMessage()
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
            $convenios = Convenio::find($id);
            return response()->json($convenios, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al encontrar el convenios =>' . $id . ' : ' . $ex->getMessage()
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
            $convenios = Convenio::findOrFail($id);
            $convenios->update($request->all());
            return response()->json($convenios, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al actualizar la convenio =>' . $id . ' : ' . $ex->getMessage()
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
            Convenio::find($id)->delete();
            return response()->json([], Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al eliminar la convenio =>' . $id . ' : ' . $ex->getMessage()
            ], 400);
        }
    }
}
