<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;


class ProyectoMacro extends Model
{
    use SoftDeletes;
    protected $table='proyectomacro';
    protected $primaryKey='id';
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $fillable = ['id','externalid_macro','idcarrera','idarea','nombre_prmacro','encargado','descripcion','estadomacro'];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->externalid_macro=(string) Uuid::generate(4);
        });
    }

    public function getRouterKyName(){
        return 'externalid_macro';
    }

    public function basico(){
        return $this->hasMany(ProyectoBasico::class,'idmacro','id');
    }
}