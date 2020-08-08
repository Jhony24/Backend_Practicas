<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Areas extends Model
{
    use SoftDeletes;
    protected $table='areas';
    protected $primaryKey='id';
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $fillable = ['id','externalid_areas','nombrearea','areaestado','idcarrera'];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->externalid_areas=(string) Uuid::generate(4);
        });
    }

    public function getRouterKyName(){
        return 'externalid_areas';
    }


    public function carreras1(){
        return $this->belongsTo(Carreras::class,'idcarrera');
    }
}