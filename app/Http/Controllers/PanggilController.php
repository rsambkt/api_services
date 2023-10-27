<?php

namespace App\Http\Controllers;

use App\Models\Panggil;
use Illuminate\Http\Request;
use App\Http\Resources\AntrianResource;
use Illuminate\Support\Facades\Validator;

class PanggilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json([
            'metadata'=>[
                'code'=>401,
                'message'=>'Gagal Memanggil Antrian'
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return response()->json([
            'metadata'=>[
                'code'=>401,
                'message'=>'Gagal Memanggil Antrian'
            ]
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator=Validator::make($request->all(),[
            'kodebooking' => 'required',
            'loketpemanggil' => 'required|string|max:255',
        ]);
        if($validator->fails()){
            return response()->json([
                'metadata'=>[
                    'code'=>401,
                    'message'=>'Gagal Memanggil Antrian'
                ],
                'response'=>$validator->errors()
            ]);
        }else{
            // print_r($request); exit;
            // $panggil = Panggil::create([$request]);
            $panggil = Panggil::create([
                'kodebooking' => $request->kodebooking,
                'loketpemanggil' => $request->loketpemanggil,
                'jenisdisplay' => empty($request->jenisdisplay)?'Admisi':$request->jenisdisplay,
                'displayid' => empty($request->displayid)?'0':$request->displayid,
                'status' => $request->status==null?'1':$request->status,
            ]);
            return response()->json([
                'metadata'=>[
                    'code'=>200,
                    'message'=>'Pemanggilan Berhasil'
                ],
                'response' => $panggil
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Panggil $panggil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Panggil $panggil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePanggilRequest $request, Panggil $panggil)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Panggil $panggil)
    {
        //
    }
}
