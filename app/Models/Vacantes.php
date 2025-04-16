<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacantes extends Model
{
    use HasFactory;
    protected  $table = 'vacantes';
    public $timestamps = false;
    protected $primaryKey = 'idVacantes';
    protected $fillable = [
        'nomVacante',
        'descripVacante',
        'salario',
        'expMinima',
        'cargoVacante',
        'catVacId'
    ];
}
