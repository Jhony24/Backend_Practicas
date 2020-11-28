<?php

namespace App\Http\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ficticio extends Model
{
    use SoftDeletes;
    protected $table = 'ficticio';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'externalid_ficticio', 'idcarrera', 'nombreempresa', 'nombrearea', 'nombre_prficticio', 'estudianes_requeridos', 'horas_cumplir', 'fecha_inicio', 'actividades', 'requerimientos', 'estadoficticio'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->externalid_ficticio = (string) Uuid::generate(4);
        });
    }

    public function getRouterKyName()
    {
        return 'externalid_ficticio';
    }
}
