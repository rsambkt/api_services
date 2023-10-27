<?php 

namespace App\Helpers;
// use \illuminate\support\facades\DB;
use Illuminate\Support\Facades\Crypt;

use DB;
class Akses{
    public static function isValid(){
        $header=getallheaders();
        $signature = $header['signature'];
        $clientid=$header['client-id'];
        $timestamp=$header['timestamp'];
        $client = DB::table('wsclient')
            ->where("client_id","=",$clientid)
            ->first();
        $newsignature = hash_hmac('sha256', $clientid."&".$timestamp, Crypt::decryptString($client->secret_key), true);
        $newsignature = base64_encode($newsignature);
        date_default_timezone_set('UTC');
        $curtimestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        $selisih=$curtimestamp-$timestamp;
        if(empty($client)){
            return [
                'status'=>false,
                'message'=>'Invalid User Or Password',
                'client'=>[
                    'clientid'=>$clientid,
                    'secret_key'=>'00001',
                    'timestamp'=>$timestamp,
                    'signature'=>$signature
                ],
                'server'=>[
                    'clientid'=>$clientid,
                    'secret_key'=>Crypt::decryptString($client->secret_key),
                    'timestamp'=>$timestamp,
                    'signature'=>$newsignature
                ]
            ];
        }
        if($selisih>86400) {
            return [
                'status'=>false,
                'message'=>'Expired Timestamps',
                'client'=>[
                    'clientid'=>$clientid,
                    'secret_key'=>'00001',
                    'timestamp'=>$timestamp,
                    'signature'=>$signature
                ],
                'server'=>[
                    'clientid'=>$clientid,
                    'secret_key'=>Crypt::decryptString($client->secret_key),
                    'timestamp'=>$timestamp,
                    'signature'=>$newsignature
                ]
            ];
        }
        if($signature!=$newsignature){
            return [
                'status'=>false,
                'message'=>'Invalid Signature',
                'client'=>[
                    'clientid'=>$clientid,
                    'secret_key'=>'00001',
                    'timestamp'=>$timestamp,
                    'signature'=>$signature
                ],
                'server'=>[
                    'clientid'=>$clientid,
                    'secret_key'=>Crypt::decryptString($client->secret_key),
                    'timestamp'=>$timestamp,
                    'signature'=>$newsignature
                ]
            ];
        }
        return [
            'status'=>true,
            'message'=>'Accepted',
            'client'=>[
                'clientid'=>$clientid,
                'secret_key'=>'00001',
                'timestamp'=>$timestamp,
                'signature'=>$signature
            ],
            'server'=>[
                'clientid'=>$clientid,
                'secret_key'=>Crypt::decryptString($client->secret_key),
                'timestamp'=>$timestamp,
                'signature'=>$newsignature
            ]
        ];

    }

    // encryption data
    const TIME_DIFF_LIMIT = 480;

	public static function encrypt(array $json_data, $cid, $secret) {
		return self::doubleEncrypt(strrev(time()) . '.' . json_encode($json_data), $cid, $secret);
	}

	public static function decrypt($hased_string, $cid, $secret) {
		$parsed_string = self::doubleDecrypt($hased_string, $cid, $secret);
		list($timestamp, $data) = array_pad(explode('.', $parsed_string, 2), 2, null);
		if (self::tsDiff(strrev($timestamp)) === true) {
			return json_decode($data, true);
		}
		return null;
	}

	private static function tsDiff($ts) {
		return abs($ts - time()) <= self::TIME_DIFF_LIMIT;
	}

	private static function doubleEncrypt($string, $cid, $secret) {
		$result = '';
		$result = self::enc($string, $cid);
		$result = self::enc($result, $secret);
		return strtr(rtrim(base64_encode($result), '='), '+/', '-_');
	}

	private static function enc($string, $key) {
		$result = '';
		$strls = strlen($string);
		$strlk = strlen($key);
		for($i = 0; $i < $strls; $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % $strlk) - 1, 1);
			$char = chr((ord($char) + ord($keychar)) % 128);
			$result .= $char;
		}
		return $result;
	}

	private static function doubleDecrypt($string, $cid, $secret) {
		$result = base64_decode(strtr(str_pad($string, ceil(strlen($string) / 4) * 4, '=', STR_PAD_RIGHT), '-_', '+/'));
		$result = self::dec($result, $cid);
		$result = self::dec($result, $secret);
		return $result;
	}

	private static function dec($string, $key) {
		$result = '';
		$strls = strlen($string);
		$strlk = strlen($key);
		for($i = 0; $i < $strls; $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % $strlk) - 1, 1);
			$char = chr(((ord($char) - ord($keychar)) + 256) % 128);
			$result .= $char;
		}
		return $result;
	}
}