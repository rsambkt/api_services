<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ruang extends Model
{
    use HasFactory;
    protected $table='ruang';
    public $fillable = [
        'idx',
        'idx_rsam',
        'kode_jkn',
        'ruang',
        'kode_poli_jkn',
        'poliklinik',
        'jns_layanan',
        'jnsPelayanan',
        'icon',
        'loketid',
        'loketkode',
        'labelantrian',
        'labelantrianpoli',
        'autoregister',
        'status_ruang',
    ];

    protected $primaryKey = 'idx';
}
