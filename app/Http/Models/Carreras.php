<?php

namespace App\Http\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Carreras extends Model
{
    use SoftDeletes;
    protected $table='carreras';
    protected $primaryKey='id';
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $fillable = ['id','externalid_carreras','nombrecarreras','estadocarreras'];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->externalid_carreras=(string) Uuid::generate(4);
        });
    }

    public function getRouterKyName(){
        return 'externalid_carreras';
    }

    public function areas1(){
        return $this->hasMany(Areas::class,'idcarrera'); //relacion de 1 a muchos
    }

    
}
