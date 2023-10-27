<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panggil extends Model
{
    use HasFactory;
    protected $table='jkn_panggil';
    public $timestamps = false;
    public $fillable = [
        'idx',
        'kdoebooking',
        'loketpemanggil',
        'jenisdisplay',
        'displayid',
        'status',
    ];
    protected $primaryKey = 'idx';

}
