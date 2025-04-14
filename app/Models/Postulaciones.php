<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Postulaciones extends Model
{
    use HasFactory;

    protected $table = 'postulaciones';
    public $timestamps = false;
    protected $primaryKey = 'idPostulaciones';

    protected $fillable = [
        'fechaPostulacion',
        'estado',
        'vacantesId'
    ];
}
