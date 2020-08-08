<?php

namespace App;

use App\Http\Models\Carreras;
use App\Http\Models\Usuario;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Webpatser\Uuid\Uuid;


class User extends Model  implements JWTSubject, AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'externalid_users', 'cedula', 'nombre_completo', 'telefono', 'genero', 'ciclo', 'idcarrera', 'email', 'password','estadousuario'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->externalid_users = (string) Uuid::generate(4);
        });
    }

    public function getRouterKyName()
    {
        return 'externalid_users';
    }



    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remeber_token'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function roles()
    { //relacion de muchos a muchos de la tabla roles
        return $this->belongsToMany('App\Http\Models\Role')->withTimesTamps();
    }

    public function asignarRol($role)
    {
        $this->roles()->sync($role, false);
    }

    public function Rol()
    {
        return $this->roles->flatten()->pluck('nombre_rol')->unique();
    }


    public function authorizeRoles($roles)
    {
        /*abort_unless($this->hasAnyRole($roles), 401);
        return true;*/
        if ($this->hasAnyRole($roles)) {
            return true;
        }
        abort(401, 'This action es unauthorized');
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('nombre_rol', $role)->first()) {
            return true;
        }
        return false;
    }

    public function isAdmin()
    {
        foreach ($this->roles()->get() as $role) {
            if ($role->nombre_rol == 'admin') {
                return true;
            }
        }
    }
    public function carreradeusuario()
    {
        return $this->belongsTo(Carreras::class,'idcarrera');    }
}
