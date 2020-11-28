<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;


class Practicas extends Model
{
    use SoftDeletes;
    protected $table='practicas';
    protected $primaryKey='id';
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $fillable = ['id','externalid_practicas','tipo_practica','cupos','horas_cumplir','ciclo_necesario','fecha_inicio','hora_entrada','hora_salida','salario','actividades','requerimientos','ppestado','idcarrera','idarea','idempresa'];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->externalid_practicas=(string) Uuid::generate(4);
        });
    }
    public function getRouterKyName(){
        return 'externalid_practicas';
    }
}