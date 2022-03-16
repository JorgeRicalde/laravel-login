<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    /**
     * Valida el email y contraseña, devolviendo los datos del usuario y un Access Token
     */
    public function login(AuthRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'message' => 'Email o Contraseña incorrecto'
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return new JsonResponse([
            'token_type' => 'Bearer',
            'access_token' => $token,
            'user' => $user,
        ], 200);
    }

    /**
     * Elimina el Access Token del usuario que realizo la solicitud
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return new JsonResponse(null, 200);
    }

    /**
     * Retorna los datos del usuario autentificado
     */
    public function ping(Request $request): JsonResponse
    {
        return new JsonResponse([
            'token_type' => 'Bearer',
            'access_token' => $request->bearerToken(),
            'user' => $request->user(),
        ], 200);
    }
}
