<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;


class Convenio extends Model
{
    use SoftDeletes;
    protected $table='convenio';
    protected $primaryKey='id';
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $fillable = ['id','externalid_convenio','tipo_convenio','idempresa','fecha_inicio','fecha_culminacion','objeto','idcarrera','estadoconvenio'];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->externalid_convenio=(string) Uuid::generate(4);
        });
    }

    public function getRouterKyName(){
        return 'externalid_convenio';
    }
}