<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permisos extends Model
{
    use HasFactory;
    protected  $table = 'permisos';
    public $timestamps = false;
    protected $primaryKey = 'idPermiso';
    protected $fillable = [
        "descrip",
        'fechaInicio',
        'estado',
        'tipoPermisoId',
        'fechaFinal',
        'contratoId'
    ];
}
