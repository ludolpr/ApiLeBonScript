<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Factory;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'picture' => 'nullable|max:50',
            'zipcode' => 'required|numeric|digits:5',
            'address' => 'required|max:150',
            'town' => 'required|max:100',
            'coords' => 'required|max:150',
            'id_role' => 'sometimes|integer|exists:roles,id',
        ]);
        // valeur par defaut
        $roleId = $request->id_role ?? 1;


        $user = $this->user::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'picture' => $request->picture,
            'zipcode' => $request->zipcode,
            'address' => $request->address,
            'town' => $request->town,
            'coords' => $request->coords,
            'id_role' => $roleId,

        ]);
        // dd($user);

        //bad request ---> 
        // $token = JWTAuth::fromUser($user);

        $token = auth()->login($user);

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'User created successfully!',
            ],
            'data' => [
                'user' => $user,
                'access_token' => [
                    'token' => $token,
                    'type' => 'Bearer',
                    'expires_in' => auth()->factory()->getTTL() * 3600,
                ],
            ],
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!$token = auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'meta' => [
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Invalid email or password',
                ],
                'data' => [],
            ], 401);
        }

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Login successful.',
            ],
            'data' => [
                'user' => auth()->user(),
                'access_token' => [
                    'token' => $token,
                    'type' => 'Bearer',
                    'expires_in' => auth()->factory()->getTTL() * 3600,
                ],
            ],
        ]);
    }

    public function logout()
    {
        $token = JWTAuth::getToken();
        if (!$token) {
            return response()->json([
                'meta' => [
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Token not provided',
                ],
                'data' => [],
            ], 401);
        }

        JWTAuth::invalidate($token);

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Successfully logged out',
            ],
            'data' => [],
        ]);
    }
}
