<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api',['except'=>['login','register','validasi','getheader']]);
    }

    public function login()
    {
        // print_r($request->all()); exit;
        
        
        // $validator=Validator::make($request->all(),[
        //     'email' => 'required|string|email',
        //     'password' => 'required|string',
        // ]);

        $header=getallheaders();
        $isvalid=array(
            'client-id'=>$header['client-id'],
            'secret-key'=>$header['secret-key']
        );
        $validator=Validator::make($isvalid,[
            'client-id' => 'required|string',
            'secret-key' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json([
                'metadata'=>[
                    'code'=>401,
                    'message'=>'Error Saat Login'
                ],
                'response'=>$validator->errors(),
                'header'=>getallheaders()
            ],401);
        }
        else{
            $credentials=array(
                'username'=>$header['client-id'],
                'password'=>$header['secret-key']
            );
            $token = Auth::attempt($credentials);
            if (!$token) {
                return response()->json([
                    'metadata'=>[
                        'code'=>401,
                        'message'=>'Client ID Atau Secret Key Anda Salah'
                    ]
                ], 401);
            }

            $user = Auth::user();
            return response()->json([
                'metadata'=>[
                    'code'=>200,
                    'message'=>'Login Sukses'
                ],
                'response'=>array(
                    'user' => $user,
                    'authorization' => [
                        'token' => $token,
                        'type' => 'bearer',
                    ]
                ),
                
            ]);
        }
        
    }
    function getheader(){
        $header ="";
		date_default_timezone_set('UTC');
        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        // Create Signature
        $signature = hash_hmac('sha256', '00001'."&".$tStamp, 'client123', true);
        $encodedSignature = base64_encode($signature);

		$header .= "client-id: " . '00001' . "\r\n";
		$header .= "timestamp: " . $tStamp . "\r\n";
		$header .= "signature: " . $encodedSignature ."\r\n";
		

        
        echo "CLEINT ID : 00001\n";
        echo "SECRET KEY : client123\n";
        echo "TIMESTAMP : ".$tStamp."\n";
        echo "SIGNATURE : ".$signature."\n";
        echo "ENCODE SIGNATURE : ".$encodedSignature."\n\n";

        $decodesignature = base64_decode($encodedSignature);
        echo "ENCODE SIGNATURE : ".$encodedSignature."\n";
        echo "DECODE SIGNATURE : ".$decodesignature."\n";
        $newsignature = hash_hmac('sha256', '00001'."&".$tStamp, 'client123', true);
        echo "NEW SIGNATURE : ".$newsignature."\n";
        if($decodesignature==$newsignature){
            echo "MATCH";
        }

		// echo $header;
    }

    public function validasi()
    {
        $isValid=akses::isValid();
        if($isvalid){
            return response()->json([
                'metadata'=>[
                    'code'=>200,
                    'message'=>'Match'
                ],
                'sign'=>$isvalid
                
            ]);
        }else{
            return response()->json([
                'metadata'=>[
                    'code'=>401,
                    'message'=>'Not permition to access'
                ],
                'sign'=>$isvalid
            ], 401);
        }
        // $header=getallheaders();

        // $signature = $header['signature'];
        // $clientid=$header['client-id'];
        // $timestamp=$header['timestamp'];
        // $user = User::latest()
        //     ->where("username","=",$clientid)
        //     ->first();

        // $newsignature = hash_hmac('sha256', 'simrs'."&".$timestamp, '12345', true);
        // $newsignature = base64_encode($newsignature);

        // if($signature==$newsignature){
        //     return response()->json([
        //         'metadata'=>[
        //             'code'=>200,
        //             'message'=>'Match'
        //         ],
        //         'response'=>array(
        //             'user' => $user,
        //         ),
                
        //     ]);
        // }else{
            
        //     return response()->json([
        //         'metadata'=>[
        //             'code'=>401,
        //             'message'=>'Not permition to access'
        //         ],
        //         'response'=>[
        //             'client'=>[
        //                 'clientid'=>$clientid,
        //                 'timestamp'=>$timestamp,
        //                 'signature'=>base64_encode($signature),
        //                 'secret_key'=>Crypt::decryptString($user['secret_key']),
        //             ],
        //             'server'=>[
        //                 'clientid'=>$clientid,
        //                 'timestamp'=>$timestamp,
        //                 'signature'=>base64_encode($newsignature),
        //                 'secret_key'=>Crypt::decryptString($user['secret_key']),
        //             ]
        //         ]
        //     ], 401);

            
        // }
        
        
        // $header ="";
		// date_default_timezone_set('UTC');
        // $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        // Create Signature
        // $signature = hash_hmac('sha256', 'simrs'."&".'12345', '12345', true);
        // $encodedSignature = base64_encode($signature);

		// $header .= "client-id: " . 'simrs' . "\r\n";
		// $header .= "timestamp: " . $tStamp . "\r\n";
		// $header .= "signature: " . $encodedSignature ."\r\n";
		

        
        // echo "CLIENT ID : simrs\n";
        // echo "SECRET KEY : 12345\n";
        // echo "TIMESTAMP : ".$tStamp."\n";
        // echo "SIGNATURE : ".$signature."\n";
        // echo "ENCODE SIGNATURE : ".$encodedSignature."\n\n";

        // $decodesignature = base64_decode($encodedSignature);
        // echo "ENCODE SIGNATURE : ".$encodedSignature."\n";
        // echo "DECODE SIGNATURE : ".$decodesignature."\n";
        // $newsignature = hash_hmac('sha256', 'simrs'."&".$tStamp, '12345', true);
        // echo "NEW SIGNATURE : ".$newsignature."\n";
        // if($decodesignature==$newsignature){
        //     echo "MATCH";
        // }

        // echo $signature; exit;
        // $isvalid=array(
        //     'client-id'=>$header['client-id'],
        //     'secret-key'=>$header['secret-key']
        // );
        // $validator=Validator::make($isvalid,[
        //     'client-id' => 'required|string',
        //     'secret-key' => 'required|string',
        // ]);
        // if($validator->fails()){
        //     return response()->json([
        //         'metadata'=>[
        //             'code'=>401,
        //             'message'=>'Error Saat Login'
        //         ],
        //         'response'=>$validator->errors(),
        //         'header'=>getallheaders()
        //     ],401);
        // }
        // else{
        //     $credentials=array(
        //         'username'=>$header['client-id'],
        //         'password'=>$header['secret-key']
        //     );
        //     $token = Auth::attempt($credentials);
        //     if (!$token) {
        //         return response()->json([
        //             'metadata'=>[
        //                 'code'=>401,
        //                 'message'=>'Client ID Atau Secret Key Anda Salah'
        //             ]
        //         ], 401);
        //     }

        //     $user = Auth::user();
        //     return response()->json([
        //         'metadata'=>[
        //             'code'=>200,
        //             'message'=>'Login Sukses'
        //         ],
        //         'response'=>array(
        //             'user' => $user,
        //             'authorization' => [
        //                 'token' => $token,
        //                 'type' => 'bearer',
        //             ]
        //         ),
                
        //     ]);
        // }
        
    }

    public function register(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'username' => 'required|string|unique:users',
            'name' => 'required|string|max:255',
            'secret_key' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
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
            $user = User::create([
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'secret_key' => Crypt::encryptString($request->secret_key),
                'password' => Hash::make($request->password),
            ]);
            return response()->json([
                'metadata'=>[
                    'code'=>200,
                    'message'=>'Registrasi Sukses'
                ],
                'response' => $user
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
