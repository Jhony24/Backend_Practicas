<?php

namespace App\Http\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;


class Role extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $fillable = [
        'nombre_rol','descripcion','externalid_roles'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->externalid_roles=(string) Uuid::generate(4);
        });
    }

    public function getRouterKyName(){
        return 'externalid_roles';
    }

    public function users(){ //relacion de muchos a muchos de la tabla roles
        return $this->belongsToMany(User::class)->withTimesTamps();
    }
}