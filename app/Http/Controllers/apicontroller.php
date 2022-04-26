<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Hash;

class apicontroller extends Controller
{
    function index(Request $request)
    {
        $user= User::where('email', $request->email)->first();
        // return $user;
        // print_r($data);
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }
        
             $token = $user->createToken('my-app-token')->plainTextToken;
        
            $response = [
                'user' => $user,
                'token' => $token
            ];
        
             return response($response, 201);
    }

    function list(Request $req){
        
        return User::all();
        
    }

    
    function update(Request $req){
        $rules=array(
            "name"=>'required',
            "email"=>'required'
        );
        $validator=Validator::make($req->all(),$rules);
        if($validator->fails()){
            return $validator->errors();
        }
        else{
        $device=User::find($req->id);
        $device->name=$req->name;
        $device->email=$req->email;
        $result= $device->save();
        if($result){
            return ["result"=>"data is updated"];

        }
 
        return ["result"=>"no"];
    }}
    function delete($id){
        $device=User::find($id);
        if($device)
        {
        $result=$device->delete();
        if($result){
        return ['result'=>"record deleted {$id}"];
        }
        
    }
    else{
    return "no record {$id}";
    }
    }

    function search($name)
    {
        $device=User::where("name",$name)->get();
        if(count($device)>0){
            return $device;
        }
        return ['result'=>"{$name} not found"];
    }


    
}
