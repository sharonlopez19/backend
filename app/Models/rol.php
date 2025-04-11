<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class rol extends Model
{
    use HasFactory;
    protected  $table = 'rol';
    public $timestamps = false;
    protected $primaryKey = 'idRol';
    protected $fillable = [
        'nombreRol'
    ];
}
