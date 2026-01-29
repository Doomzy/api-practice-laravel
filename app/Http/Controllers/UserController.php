<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserPostRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(UserLoginRequest $request)
    {
        try{
            $validatedData= $request->validated();
            $user= User::where("email", $validatedData['email'])->first();

            if($user && Hash::check($validatedData['password'], $user->password)){
                $token= $user->createToken("auth-token")->plainTextToken;
                return response()->json(["token"=>$token]);
            }

            throw new \Exception('Login credintials are incorrect');

        }catch (\Exception $error){
            Log::error($error->getMessage());
            return response($error->getMessage(), 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(UserPostRequest $request)
    {
        try{
            $validatedData= $request->validated();
            $newUser = User::create($validatedData);
            return new UserResource($newUser);

        }catch (\Exception $error){
            Log::error($error->getMessage());
            return response($error->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function getProfile(Request $request)
    {
        try{
            $userId= $request->user()->id;
            $user= User::find($userId);

            return new UserResource($user);

        }catch (\Exception $error){
            Log::error($error->getMessage());
            return response($error->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
