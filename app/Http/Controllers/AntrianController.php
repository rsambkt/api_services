<?php

namespace App\Http\Controllers;
use App\Models\Antrian;
use Illuminate\Http\Request;
use App\Http\Resources\AntrianResource;
use Illuminate\Support\Facades\Validator;

class AntrianController extends Controller
{
    
    public function index(Request $request){
        $limit=$request->has('limit')?$request->input('limit'):10;
        $tanggal=$request->has('tanggal')?$request->input('tanggal'):date('Y-m-d');
        $keyword=$request->has('keyword')?$request->input('keyword'):"";
        $antrian=Antrian::latest()
        ->where(function($query) use ($keyword)
        {
            $query->where("nomorkartu","LIKE","%{$keyword}%")
            ->orWhere("kodebooking","LIKE","%{$keyword}%")
            ->orWhere("nik","LIKE","%{$keyword}%")
            ->orWhere("nama","LIKE","%{$keyword}%");
        })
        ->where("tanggalperiksa","=","$tanggal")
        ->paginate($limit);

        $antrian->appends(array('keyword'=>$keyword));
        return new AntrianResource(200,"List Data Antrian",$antrian);
    }
    public function store(Request $request){
        
        $validator = Validator::make($request->all(),[
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
        ]);
    }
    function show(Antrian $antrian){
        return new AntrianResource('200','Data Ditemukan',$antrian);
    }
    function check(Request $request){
        $kodebooking=$request->has('kodebooking')?$request->input('kodebooking'):'';
        $antrian=Antrian::latest()
        ->where("kodebooking","=",$kodebooking)
        ->first();
        return new AntrianResource('200','Data Ditemukan',$antrian);
    }
    function latestrow(Request $request){
        
        $jenis=$request->has('jenis')?$request->input('jenis'):'admisi';
        $tipe=$request->has('tipe')?$request->input('tipe'):1; /* 1. normal 2. Prioritas 3.Lewati*/
        $tanggalperiksa=$request->has('tanggalperiksa') ? $request->input('tanggalperiksa') : date('Y-m-d');
        if($jenis=='admisi'){
            $loket=$request->has('loket')?$request->input('loket'):'0';
            $antrian = Antrian::latest()
            ->where("loketid","=",$loket)
            ->where("jnsantrianadmisi","=",$tipe)
            ->where("taskid","<",3)
            ->where("tanggalperiksa",$tanggalperiksa)
            ->where("angkaantreanadmisi","IS NOT",null)
            ->orderBy("angkaantreanadmisi","DESC")
            ->first();
        }else if("jenis"=='poli'){
            $antrian = Antrian::latest()
            ->where("jnsantrian","=",$tipe)
            ->where("taskid",">=",3)
            ->where("taskid","<",5)
            ->where("tanggalperiksa",$tanggalperiksa)
            ->where("nomorantrean","IS NOT",null)
            ->orderBy("nomorantrean","DESC")
            ->first();
        }else{
            $antrian = Antrian::latest()
            ->where("jnsantrianfarmasi","=",$tipe)
            ->where("taskid",">=",5)
            ->where("taskid","<=",7)
            ->where("tanggalperiksa",$tanggalperiksa)
            ->where("nomorantrean","IS NOT",null)
            ->orderBy("nomorantrean","DESC")
            ->first();
        }
        
        return new AntrianResource(200,"Antrian Terakhir",$antrian);
    }
    function listantrian(Request $request){
        $jenis=$request->has('jenis')?$request->input('jenis'):'admisi';
        $tipe=$request->has('tipe')?$request->input('tipe'):1; /* 1. normal 2. Prioritas 3.Lewati*/
        $tanggalperiksa=$request->has('tanggalperiksa') ? $request->input('tanggalperiksa') : date('Y-m-d');
        if($jenis=='admisi'){
            $loket=$request->has('loket')?$request->input('loket'):'0';
            $antrian = Antrian::all()
            ->where("loketid","=",$loket)
            ->where("jnsantrianadmisi","=",$tipe)
            ->where("taskid","<",3)
            ->where("tanggalperiksa",$tanggalperiksa)
            ->where("angkaantreanadmisi","IS NOT",null)
            ->orderBy("angkaantreanadmisi","DESC")
            ->get();
        }else if("jenis"=='poli'){
            $antrian = Antrian::all()
            ->where("jnsantrian","=",$tipe)
            ->where("taskid",">=",3)
            ->where("taskid","<",5)
            ->where("tanggalperiksa",$tanggalperiksa)
            ->where("nomorantrean","IS NOT",null)
            ->orderBy("nomorantrean","DESC")
            ->get();
        }else{
            $antrian = Antrian::all()
            ->where("jnsantrianfarmasi","=",$tipe)
            ->where("taskid",">=",5)
            ->where("taskid","<=",7)
            ->where("tanggalperiksa",$tanggalperiksa)
            ->where("nomorantrean","IS NOT",null)
            ->orderBy("nomorantrean","DESC")
            ->get();
        }
        
        return new AntrianResource(200,"List Data angtrian",$antrian);
    }
    // function cekvalid(){
    //     $isValid=\App\Helpers\Akses::isValid();
    //     // echo $isValid; exit;
    //     // print_r($isValid);exit;
    //     if($isValid['status']){
    //         return response()->json([
    //             'metadata'=>[
    //                 'code'=>200,
    //                 'message'=>$isValid['message']
    //             ]
    //         ]);
    //     }else{
    //         return response()->json([
    //             'metadata'=>[
    //                 'code'=>401,
    //                 'message'=>$isValid['message']
    //             ]
    //         ], 401);
    //     }
    // }
}
