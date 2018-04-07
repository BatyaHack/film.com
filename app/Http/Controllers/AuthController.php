<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator, DB, Hash, Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $credentials = $request->only('name', 'email', 'password');

        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|max:255',
        ];

        $validator = Validator::make($credentials, $rules);

        // dd($validator);

        if($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $token = str_random(30);

        try
        {
            $user = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password), 'token' => $token]);
        }
        catch(Exception $ex)
        {
            return response()->json(['success' => false, 'error' => $ex->getMessage()]);
        }

        return response()->json(['success' => true, 'user' => $user]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($credentials, $rules);

        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }

        $user_email = $credentials['email'];
        $user_password = $credentials['password'];
        $user = User::where('email', $user_email)->first();

        if(!Hash::check($user_password, $user->password)) {
            return response()->json(['success' => false, 'error'=> 'User or password not found']);  
        }

        try
        {
            $token = JWTAuth::attempt($credentials);
        }
        catch(JWTException $ex)
        {
            return response()->json(['success' => false, 'error'=> $ex->getMessage()]);            
        }

        return response()->json([
            'success' => true, 
            'user' => $user, 
            'data'=> [ 
                'token' => $token,
                'tokenTime' => 7 * 24 * 60
            ]]);
    }

    public function logout(Request $request)
    {
        $this->validate($request, ['token' => 'required']);

        try
        {
            JWTAuth::invalidate($request->input('token'));
            return response()->json(['success' => true, 'message'=> "You have successfully logged out."]);
        }
        catch(JWTException $ex)
        {
            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.']);
        }
    }

}
