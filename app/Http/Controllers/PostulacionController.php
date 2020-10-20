<?php

namespace App\Http\Controllers;

use App\Http\Models\Postulacion;
use App\Http\Models\Practicas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class PostulacionController extends Controller
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
            $listado = Postulacion::join('users', 'postulacion.id_estudiante', '=', 'users.id')
                ->join('practicas', 'postulacion.id_practica', '=', 'practicas.id')
                ->join('areas', 'practicas.idarea', '=', 'areas.id')
                ->join('empresas', 'practicas.idempresa', '=', 'empresas.id')
                ->join('carreras', 'users.idcarrera', '=', 'carreras.id')
                ->select('postulacion.*', 'users.*', 'practicas.*', 'practicas.*', 'areas.nombrearea', 'empresas.nombreempresa', 'carreras.nombrecarreras')
                ->where('users.idcarrera', '=', Auth::user()->idcarrera)
                ->get();

            return response()->json($listado, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al listar los datos de postulacion: ' . $ex->getMessage()
            ], 206);
        }
    }
    public function indexPos()
    {
        try {
            $listado = Postulacion::where('postulacion.id_estudiante', '=', Auth::user()->id)
                ->join('users', 'postulacion.id_estudiante', '=', 'users.id')
                ->join('practicas', 'postulacion.id_practica', '=', 'practicas.id')
                ->join('areas', 'practicas.idarea', '=', 'areas.id')
                ->join('empresas', 'practicas.idempresa', '=', 'empresas.id')
                ->join('carreras', 'users.idcarrera', '=', 'carreras.id')
                ->select('postulacion.*', 'users.nombre_completo', 'practicas.*', 'areas.nombrearea', 'empresas.nombreempresa')
                ->get();

            return response()->json($listado, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al listar los datos de postulacion: ' . $ex->getMessage()
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
        /*$this->validate($request, [
            'id_estudiante' => 'required|unique:postulacion',
        ]);*/
        try {
            $postulacion = new Postulacion;
            $postulacion->externalid_postulacion = $request->input('externalid_postulacion');
            $postulacion->id_estudiante = $request->input('id_estudiante');
            $postulacion->id_practica = $request->input('id_practica');
            $postulacion->id_proyecto = $request->input('id_proyecto');
            $postulacion->estado_postulacion = $request->input('estado_postulacion');
            $postulacion->fecha_postulacion = $request->input('fecha_postulacion');

            $practica = Practicas::find($postulacion->id_practica = $request->input('id_practica'));
            $estudiante = Postulacion::where('id_estudiante', '=', $postulacion->id_estudiante = $request->input('id_estudiante'))->where('estado_postulacion', '!=','FINALIZADA')->where('estado_postulacion', '!=','RECHAZADA')->get();


            if ($practica->cupos > 0 && $estudiante->count() <= 0) {
                $postulacion->save();
                Practicas::find($postulacion->id_practica = $request->input('id_practica'))->decrement('cupos');
                return response()->json($postulacion, Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'No existe cupos disponibles para esta practica o usted ya posee una postulacion', $practica->cupos, $estudiante->count()], 409);
            }
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al registrar la postulacion: ' . $ex->getMessage()
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
