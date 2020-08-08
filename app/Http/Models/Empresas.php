<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;


class Empresas extends Model

{
    use SoftDeletes;
    protected $table='empresas';
    protected $primaryKey='id';
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $fillable = ['id','externalid_empresas','nombreempresa','tipo_empresa','nombrerepresentante','ruc','direccion','telefono','correo','actividades','idcarrera','estadoempresa'];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->externalid_empresas=(string) Uuid::generate(4);
        });
    }

    public function getRouterKyName(){
        return 'externalid_empresas';
    }
}