<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    /*make register function */
    public function register(Request $request){
        /*validate email */
       $validatedEmail=Validator::make($request->all(),[
        'email'=>'required|string|email|max:255|unique:users'
       ]);
       /*check validity */
       if($validatedEmail->fails()){
         return response()->json([
            'error'=>'Duplicate email',
            'status'=>'Response::HTTP_PROCESSABLE_ENTITY',
            'message'=>'Duplicate Email detected. Please input another email'

         ],Response::HTTP_UNPROCESSABLE_ENTITY);
       }
       /*  */
       $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|confirmed',

    ]);

            $validatedData['password'] = bcrypt($request->password);
            $user = User::create($validatedData);
            // sends a verification email once registration is done
            // event(new Registered($user));
            $accessToken = $user->createToken('authToken')->accessToken;
            return response(['access_token' => $accessToken], Response::HTTP_OK); //200


    }

    /*Login function */
    public function login(Request $request)
    {
        $loginData = $request->validate([

            'email' => 'email|required',
            'password' => 'required',

        ]);
        if (!auth()->attempt($loginData)) {
            return response(['message' => 'invalid credentials'], 401);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }

    /*Logout Function */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out',
        ], Response::HTTP_OK); //Status 200
    }

}
