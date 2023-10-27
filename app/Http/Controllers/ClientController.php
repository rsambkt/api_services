<?php

namespace App\Http\Controllers;
use App\Models\wsclient;
use Illuminate\Http\Request;
use App\Http\Resources\AntrianResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class ClientController extends Controller
{
    //
    public function create(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'client_id' => 'required|string|unique:wsclient',
            'secret_key' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'modulid' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'metadata'=>[
                    'code'=>401,
                    'message'=>'Gagal registrasi data'
                ],
                'response'=>$validator->errors()
            ]);
        }else{
            $user = wsclient::create([
                'client_id' => $request->client_id,
                'secret_key' => Crypt::encryptString($request->secret_key),
                'instansi' => $request->instansi,
                'modulid' => $request->modulid,
                'key' => $request->key,
                'status' => $request->status,
            ]);
            return response()->json([
                'metadata'=>[
                    'code'=>200,
                    'message'=>'Registrasi Modul Sukses'
                ],
                'response' => $user
            ]);
        }
    }
}
