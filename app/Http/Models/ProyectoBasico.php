<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;


class ProyectoBasico extends Model
{
    use SoftDeletes;
    protected $table='proyectobasico';
    protected $primaryKey='id';
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $fillable = ['id','externalid_basico','idmacro','nombre_prbasico','actividades','estadobasico'];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->externalid_basico=(string) Uuid::generate(4);
        });
    }

    public function getRouterKyName(){
        return 'externalid_basico';
    }
}