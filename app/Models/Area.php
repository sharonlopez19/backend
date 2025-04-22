<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'area';
    public $timestamps = false;
    protected $primaryKey = 'idArea';

    protected $fillable = [
        'nombreArea',
        'jefePersonal',
        'estado'
        
    ];
}
