<?php

namespace App\Http\Controllers;

use App\Http\Models\Areas;
use App\Http\Models\Carreras;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Contracts\Providers\Auth as TymonAuth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AreasController extends Controller
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
    public function index(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                try {
                    //$areas=Areas::all();
                    $areas = Areas::join("carreras", "areas.idcarrera", "=", "carreras.id")
                        ->select('areas.*', 'carreras.nombrecarreras')
                        ->get();
                    return response()->json($areas, Response::HTTP_OK);
                } catch (Exception $ex) {
                    return response()->json([
                        'error' => 'Hubo un error al listar los datos de carreras: ' . $ex->getMessage()
                    ], 206);
                }
            } else {
                try {
                    $areas = Areas::join("carreras", "areas.idcarrera", "=", "carreras.id")
                        ->select('areas.*', 'carreras.nombrecarreras')
                        ->where('areas.idcarrera', '=', Auth::user()->idcarrera)
                        ->get();
                    return response()->json($areas, Response::HTTP_OK);
                } catch (Exception $ex) {
                    return response()->json([
                        'error' => 'Hubo un error al listar los datos de areas: ' . $ex->getMessage()
                    ], 206);
                }
            }
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
                'nombrearea' => 'required|unique:areas|min:6|max:50',
            ]);

        if ($validator->fails()) {
            return response($validator->errors()->all(), 422);
        }
        try {
            $areas = Areas::create($request->all());
            return response()->json($areas, Response::HTTP_CREATED);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Huno un error al registrar losd atos de areas: ' . $ex->getMessage()
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
            $areas = Areas::find($id);

            $lista = $areas->carreras1;
            return response()->json($areas, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al encontrar el area =>' . $id . ' : ' . $ex->getMessage()
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
            'nombrearea' => 'required|unique:areas,nombrearea',
        ]);
        try {
            $areas = Areas::findOrFail($id);
            $areas->update($request->all());
            return response()->json($areas, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Huno un error al actualizar la area =>' . $id . ' : ' . $ex->getMessage()
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
            Areas::find($id)->delete();
            return response()->json([], Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al eliminar el area =>' . $id . ' : ' . $ex->getMessage()
            ], 400);
        }
    }
}
