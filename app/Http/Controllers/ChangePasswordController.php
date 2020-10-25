<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ChangePasswordController extends Controller
{
    public function process(Request $request)


    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);
        return $this->getPasswordResetTableRow($request)->count() > 0 ? $this->changePassword($request) : $this->tokenNotFoundResponse();
    }

    private function getPasswordResetTableRow($request)
    {
        return DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->resetToken]);
    }

    public function tokenNotFoundResponse()
    {
        return response()->json([
            'error' => 'Token o Email incorrectos'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    private function changePassword($request)
    {
        $user = User::where('email', $request->email)->first();
        $user->update(['password' => app('hash')->make($request->password)]);
        $this->getPasswordResetTableRow($request)->delete();
        return response()->json(['data' => 'Contraseña cambiada correctamente
        '], Response::HTTP_CREATED);
    }
}
