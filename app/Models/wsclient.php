<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wsclient extends Model
{
    use HasFactory;
    protected $table = 'wsclient';

    protected $fillable = [
        'client_id',
        'secret_key',
        'key',
        'instansi',
        'modulid',
        'status'
    ];

    protected $hidden = [
        'secret_key',
    ];
}
