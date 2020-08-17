<?php

use App\Http\Models\Areas;
use App\User;
use App\Http\Models\Role;
use App\Mail\TestMail;
use FastRoute\Route;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    //return $router->app->version();
    $area=Areas::findOrFail(2);
    return $router->$area->carrera1;
});


$router->get('/test', function () {
    
    /*return Role::create([
        'nombre_rol'=>'Administrador',
        'descripcion'=>'Administrador del sistema wb',
    ]);*/

    $user = User::find(2);
    $user->roles()->sync([1]);
    return $user->roles;
  

});


//login
$router->group(['prefix' => 'api',], function () use ($router) {

    $router->post('login', 'AuthController@login');
    $router->post('register', 'AuthController@register');
    $router->post('logout', 'AuthController@logout');
    $router->post('refresh', 'AuthController@refresh');
    $router->get('user-profile','AuthController@userProfile');
    $router->get('users', 'AuthController@allUsers');
    $router->post('me', 'AuthController@me');
    $router->put('usuarioA/{id}','AuthController@activar');
    $router->get('roles-profile', 'AuthController@rolesprofile');

});

//carreras
$router ->group(['middleware' =>[],'prefix'=>'api'], function () use ($router){
    $router->get('carrera','CarrerasController@index');
    $router->get('carreraR','CarrerasController@indexR');
    $router->get('carrera/{id}','CarrerasController@show');
    $router->post('carrera','CarrerasController@store');
    $router->put('carrera/{id}','CarrerasController@update');
    $router->delete('carrera/{id}','CarrerasController@destroy');

});

//usuarios
$router ->group(['middleware'=>[],'prefix'=>'api'], function () use ($router){
    $router->get('usuario','UsuarioController@index');
    $router->get('usuario/{id}','UsuarioController@show');
    $router->post('usuario','UsuarioController@store');
    $router->put('usuario/{id}','UsuarioController@update');
    $router->delete('usuario/{id}','UsuarioController@destroy');

});

//areas

$router ->group(['middleware'=>[],'prefix'=>'api'], function () use ($router){

    
    $router->get('area','AreasController@index');
    //$router->get('area','AreasController@indexU');
    $router->get('area/{id}','AreasController@show');
    $router->post('area','AreasController@store');
    $router->put('area/{id}','AreasController@update');
    $router->delete('area/{id}','AreasController@destroy');

});


//empresas
$router ->group(['prefix'=>'api'], function () use ($router){
    $router->get('empresa','EmpresasController@index');
    $router->get('empresa/{id}','EmpresasController@show');
    $router->post('empresa','EmpresasController@store');
    $router->put('empresa/{id}','EmpresasController@update');
    $router->delete('empresa/{id}','EmpresasController@destroy');

});

//practicas
$router ->group(['middleware'=>[],'prefix'=>'api'], function () use ($router){
    $router->get('practica','PracticasController@index');
    $router->get('practicaP','PracticasController@indexP');
    $router->get('practica/{id}','PracticasController@show');
    $router->post('practica','PracticasController@store');
    $router->put('practica/{id}','PracticasController@update');
    $router->delete('practica/{id}','PracticasController@destroy');

});



//convenios
$router ->group(['prefix'=>'api'], function () use ($router){
    $router->get('convenio','ConveniosController@index');
    $router->get('convenio/{id}','ConveniosController@show');
    $router->post('convenio','ConveniosController@store');
    $router->put('convenio/{id}','ConveniosController@update');
    $router->delete('convenio/{id}','ConveniosController@destroy');

});

//proyecto macro
$router ->group(['prefix'=>'api'], function () use ($router){
    $router->get('macro','ProyectoMacroController@index');
    $router->get('macro/{id}','ProyectoMacroController@show');
    $router->post('macro','ProyectoMacroController@store');
    $router->put('macro/{id}','ProyectoMacroController@update');
    $router->delete('macro/{id}','ProyectoMacroController@destroy');
});

//proyecto basico
$router ->group(['prefix'=>'api'], function () use ($router){
    $router->get('basico','ProyectoBasicoController@index');
    $router->get('basico/{id}','ProyectoBasicoController@show');
    $router->post('basico','ProyectoBasicoController@store');
    $router->put('basico/{id}','ProyectoBasicoController@update');
    $router->delete('basico/{id}','ProyectoBasicoController@destroy');
});


//probar relaciones
$router->get('/probar', function() {
    $carrera=App\Http\Models\Carreras::findOrFail(1); //id de la carrera que tiene relacion con la tabla areas
    return $carrera->areas1->toArray();
});
$router->get('/probar2', function() {
    $area=App\Http\Models\Areas::findOrFail(1); //id de la carrera que tiene relacion con la tabla areas
    return $area->carreras1->toArray();
});

$router->get('/mail', function() {
    Mail::to("admin@admin.com")->send(new TestMail());
    return "mail enviado";
});

//prostulaciones
$router ->group(['prefix'=>'api'], function () use ($router){
    $router->get('postulacion','PostulacionController@index');
    //$router->get('macro/{id}','ProyectoMacroController@show');
    $router->post('postulacion','PostulacionController@store');
    //$router->put('macro/{id}','ProyectoMacroController@update');
    //$router->delete('macro/{id}','ProyectoMacroController@destroy');
});

