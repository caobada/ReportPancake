<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Response;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    static function JsonExport($code,$msg,$data = []){
        return Response::json([
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ]);
    }

    static function GetInfoCustomer($uuid,$page_id){
        // if($token == null){
            $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1aWQiOiIzOGVkMDZiNy1hMzM4LTQxZjAtYjcyZC0wMGE4MDExZTdjNmUiLCJpYXQiOjE1NjU4NDUzMTcsImZiX25hbWUiOiJDYW8gQmFkYSIsImZiX2lkIjoiNzIyMjY4NzY3OTEwOTkwIiwiZXhwIjoxNTczNjIxMzE3fQ.OrMnQa--TuY4OoZ_P5yeD3LJDZHQtP6zI9iDwbXt5do';
        // }
       
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => 'https://pages.fm/api/v1/pages/'.$page_id.'/conversations/'.$uuid.'?access_token='.$token
        ]);
        $resp = curl_exec($ch);
        $values = ($resp);
        curl_close($ch);
        return $values;
    }
}
