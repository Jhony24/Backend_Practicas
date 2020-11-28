<?php

namespace App\Http\Controllers;

use App\Http\Models\Practicas;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PracticasController extends Controller
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
            $listado = Practicas::where('practicas.idcarrera', '=', Auth::user()->idcarrera)
                //->join('carreras','practicas.idcarrera','=','carreras.id')
                ->join('areas', 'practicas.idarea', '=', 'areas.id')
                ->join('empresas', 'practicas.idempresa', '=', 'empresas.id')
                ->select('practicas.*', 'areas.nombrearea', 'empresas.nombreempresa', 'empresas.tipo_empresa', 'empresas.direccion', 'empresas.correo')
                ->where('practicas.tipo_practica', '=', 1)
                ->get();
            return response()->json($listado, Response::HTTP_OK);


            //dd($listado);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al listar los datos de practicas: ' . $ex->getMessage()
            ], 206);
        }
    }

    public function indexP()
    {
        try {
            $id = Auth::user();
            $listado = Practicas::where('practicas.idcarrera', '=', Auth::user()->idcarrera)
                //->join('carreras','practicas.idcarrera','=','carreras.id')
                ->join('areas', 'practicas.idarea', '=', 'areas.id')
                ->join('empresas', 'practicas.idempresa', '=', 'empresas.id')
                ->select('practicas.*', 'areas.nombrearea', 'empresas.nombreempresa', 'empresas.tipo_empresa', 'empresas.direccion', 'empresas.correo')
                ->where('practicas.tipo_practica', '=', 2)
                ->get();
            return response()->json($listado, Response::HTTP_OK);


            //dd($listado);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al listar los datos de practicas: ' . $ex->getMessage()
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
        $this->validate($request, [
            'tipo_practica' => 'required',
            'cupos' => 'required|numeric|min:1|max:20',
            'horas_cumplir' => 'required|numeric|min:1|max:200',
            'ciclo_necesario' => 'min:3|max:20',
            'fecha_inicio' => 'required',
            'modalidad' => 'required',
            'actividades' => 'min:20|max:250',
            'requerimientos' => 'min:20|max:250',
            'idcarrera' => 'required',
            'idarea' => 'required',
            'idempresa' => 'required'
        ]);
        try {
            $practicas = Practicas::create($request->all());
            return response()->json($practicas, Response::HTTP_CREATED);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al registrar los datos de practicas: ' . $ex->getMessage()
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
            $practicas = Practicas::find($id);
            return response()->json($practicas, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al encontrar la practica =>' . $id . ' : ' . $ex->getMessage()
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
        $this->validate($request, [
            'tipo_practica' => 'required',
            'cupos' => 'required|numeric|min:1|max:20,cupos',
            'horas_cumplir' => 'required|numeric|min:1|max:200,horas_cumplir',
            'ciclo_necesario' => 'min:3|max:20,ciclo_necesario',
            'fecha_inicio' => 'required',
            'modalidad' => 'required',
            'actividades' => 'min:20|max:250,actividades',
            'requerimientos' => 'min:20|max:250,requerimientos',
            'idcarrera' => 'required',
            'idarea' => 'required',
            'idempresa' => 'required'
        ]);
        try {
            $practicas = Practicas::findOrFail($id);
            $practicas->update($request->all());
            return response()->json($practicas, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al actualizar la practica =>' . $id . ' : ' . $ex->getMessage()
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
            Practicas::find($id)->delete();
            return response()->json([], Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al eliminar la practica =>' . $id . ' : ' . $ex->getMessage()
            ], 400);
        }
    }
}
