<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;
    
    protected $table = "jkn_antrian";
    public $fillable = [
        'kodebooking',
        'nomorkartu',
        'nik',
        'nohp',
        'kodepoli',
        'norm',
        'nama',
        'tanggalperiksa',
        'kodedokter',
        'jampraktek',
        'jeniskunjungan',
        'nomorreferensi',
        'labelantrianadmisi',
        'labelantrianpoli',
        'labelantrianfarmasi',
        'antreanadmisi',
        'nomorantrean',
        'antreanfarmasi',
        'angkaantreanadmisi',
        'angkaantrean',
        'angkaantreanfarmasi',
        'jenisresep',
        'namapoli',
        'namadokter',
        'estimasidilayani',
        'keterangan',
        'source',
        'jkn',
        'spm',
        'statusadmisi',
        'status',
        'statusfarmasi',
        'jenispasien',
        'pasienbaru',
        'sisakuotajkn',
        'kuotajkn',
        'sisakuotanonjkn',
        'kuotanonjkn',
        'batal',
        'alasanbatal',
        'checkin',
        'waktucheckin',
        'loketid',
        'label',
        'taskid',
        'jnsantrian',
        'jnsantrianadmisi',
        'jnsantrianfarmasi',
        'terkirim',
        'failedmessage',
        'ket',
        'nosep'
    ];

    protected $primaryKey = 'kodebooking';
    public $timestamps = false;
    protected $casts = [
        'kodebooking' => 'string'
    ];

    public function ruang() {
        return $this->belongsTo('App\Models\Ruang');
    }
}
