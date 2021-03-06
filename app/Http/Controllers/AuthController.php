<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Models\Carreras;
use App\Http\Models\Role;
use App\Mail\Activacion;
use App\Mail\ActivarUsuario;
use App\Mail\TestMail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;
use Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'registerApp', 'loginApp']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Credenciales Invalidas, Intente Nuevamente'], 401);
        }


        return $this->respondWithToken($token);
    }

    public function loginApp()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Credenciales Invalidas, Intente Nuevamente'], 401);
        }
        return $this->respondWithTokenApp($token);
    }

    public function register(Request $request)
    {
        //validate incoming request 
        $message = $this->validate($request, [
            'cedula' => 'required|unique:users|min:10',
            'nombre_completo' => 'required|min:15|max:80',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5|max:15',
            'idcarrera' => 'required',
        ]);

        try {

            $user = new User;
            $user->externalid_users = $request->input('externalid_users');
            $user->cedula = $request->input('cedula');
            $user->nombre_completo = $request->input('nombre_completo');
            $user->telefono = $request->input('telefono');
            $user->genero = $request->input('genero');
            $user->ciclo = $request->input('ciclo');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            $user->estadousuario = $request->input('estadousuario');
            $user->idcarrera = $request->input('idcarrera');

            $user->save();
            $user->asignarRol(2);

            //$user->roles()->sync(Role::where('nombre_rol', 'user')->first());
            //Mail::to("jhonycupos@gmail.com")->send(new ActivarUsuario($message));
            return response()->json(['usuario' => $user, 'message' => 'Usuario Creado'], 201);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['errors' => 'Registro de Usuario ha fallado' . $e->getMessage()], 409);
        }
    }

    public function registerApp(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'cedula' => 'required|unique:users|min:10',
            'nombre_completo' => 'required|min:10|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8|max:20',
            'idcarrera' => 'required',
        ]);

        try {

            $user = new User;
            $user->externalid_users = $request->input('externalid_users');
            $user->cedula = $request->input('cedula');
            $user->nombre_completo = $request->input('nombre_completo');
            $user->telefono = $request->input('telefono');
            $user->genero = $request->input('genero');
            $user->ciclo = $request->input('ciclo');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            $user->estadousuario = $request->input('estadousuario');
            $user->idcarrera = $request->input('idcarrera');

            $user->save();
            $user->asignarRol(3);
            return response()->json(['usuario' => $user, 'message' => 'Usuario Creado'], 201);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['errors' => 'Registro de Usuario ha fallado'], 409);
        }
    }

    public function activar(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->estadousuario = $request->estadousuario = 1;
            $user->email = $request->email;
            $user->save();
           // Mail::to($user->email = $request->email)->send(new Activacion());
            return response()->json([$user], Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al actualizar el estado del usuario =>' . $id . ' : ' . $ex->getMessage()
            ], 206);
        }
    }
    public function desactivar(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->estadousuario = $request->estadousuario = 0;
            $user->save();
            return response()->json([$user], Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al actualizar el estado del usuario =>' . $id . ' : ' . $ex->getMessage()
            ], 206);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function userProfile()
    {
        $id = Auth::id();
        $usuario = User::find($id);

        $rol = $usuario->roles;
        return response()->json($usuario, Response::HTTP_OK);
    }

    public function rolesprofile()
    {
        $id = Auth::id();
        $usuario = User::find($id);
        $rol = $usuario->Rol();
        return response()->json($rol, Response::HTTP_OK);
    }
    public function userCarrera()
    {
        $id = Auth::id();
        $user = User::find($id);
        $carrera = Carreras::find($user->idcarrera);
        //dd($carrera);

        return response()->json($carrera, Response::HTTP_OK);
    }

    public function allUsers(Request $request)

    {
        $request->user()->authorizeRoles('admin');
        try {
            $usuarios = User::join("carreras", "users.idcarrera", "=", "carreras.id")
                ->select('users.*', 'carreras.nombrecarreras')
                ->get();
            return response()->json($usuarios, Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json([
                'error' => 'Hubo un error al listar los datos de carreras: ' . $ex->getMessage()
            ], 206);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        //$id = Auth::id();
        $usuario = auth()->user()->id;
        $usuario2 = User::find($usuario);
        $rol = $usuario2->Rol();
        if ($rol[0] == 'admin' || $rol[0] == 'user') {
            if (auth()->user()->estadousuario == 1) {
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60,
                    'user' => auth()->user()
                ]);
            } else if (auth()->user()->estadousuario == 0) {
                return response()->json(['error' => 'Cuenta no Activa, Espere Confirmación'], 401);
            }
        } else {
            return response()->json(['error' => 'No tiene permiso para ingresar'], 401);
        }
    }

    protected function respondWithTokenApp($token)
    {
        $usuario = auth()->user()->id;
        $usuario2 = User::find($usuario);
        $rol = $usuario2->Rol();
        if ($rol[0] == 'estudiante') {
            if (auth()->user()->estadousuario == 1) {
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 7200,
                    'user' => auth()->user()
                ]);
            } else if (auth()->user()->estadousuario == 0) {
                return response()->json(['error' => 'No puede Ingresar en la Aplicación'], 401);
            }
        } else {
            return response()->json(['error' => 'No tiene permiso para ingresar'], 401);
        }
    }
}
