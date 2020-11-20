<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;


class Postulacion extends Model
{
    use SoftDeletes;
    protected $table='postulacion';
    protected $primaryKey='id';
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $fillable = ['id','externalid_postulacion','id_estudiante','id_practica','id_proyecto','estado_postulacion','fecha_postulacion','observacion'];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->externalid_postulacion=(string) Uuid::generate(4);
        });
    }
    public function getRouterKyName(){
        return 'externalid_postulacion';
    }
}