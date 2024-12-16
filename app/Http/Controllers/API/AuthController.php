<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * Validates the request data and creates a new user in the database if the validation passes.
     * Returns a JSON response with the newly created user data or validation errors.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance containing user input.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the registration status and data.
     */
    //
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('user');

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'message' => 'User created successfully',
            'data' => $user,
        ], Response::HTTP_CREATED);
    }

    public function login_(LoginRequest $request){

        $request->validated();

        if(Auth::attempt(["email" => $request->email, "password" => $request->password])) {
            $user = Auth::user();

            $token = $user->createToken('AccessToken')->accessToken;
            $this->response = true;
            $this->data = [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ];
            $this->alert = "Login successfully";
            return $this->returnShow(['access_token' => $token, 'token_type' => 'Bearer', 'user' => $user]);
        } else {
            $this->alert = "Credenciales incorrectas.";
            $this->status = Response::HTTP_UNAUTHORIZED;
            return $this->returnShow();

        }
    }

    public function login(LoginRequest $request)
    {
        $request->validated();

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Credentials do not match'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        $token = $user->createToken('Auth_Api_Token')->accessToken;

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Inicio de sesión exitoso.',
            'data' => [
                'user' => $user,
                'access_token' => $token,
            ],
        ], Response::HTTP_OK);

    }

    public function profile()
    {
        $userData = auth()->user();

        if (!$userData) {
            $this->alert = "User not found";
            $this->status = Response::HTTP_NOT_FOUND;
            return $this->returnShow($userData);
        }

        $this->response = true;
        $this->data = $userData;;
        return $this->returnShow($userData);
    }


    public function logout()
    {
        $token = auth()->user()->token();
        $token->revoke();
        $this->response = true;
        return $this->returnRevokeToken();
    }
}
