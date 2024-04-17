<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController
{
    /**
     * Display a listing of the tasks.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255', // was removed exists:users
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(["result" => $validator->errors()], 400);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $userId = Auth::id(); // Get authenticated user's ID
            $token = Auth::getUser()->getRememberToken(); // Get authenticated user's token
            return response()->json(["result" => "success", "user_id" => $userId, "token" => $token], 200);
        } else {
            return response()->json(["result" => "fail"], 200);
        }
    }

    public function checkToken(Request $request): JsonResponse
    {
        // Get the authenticated user
        $user = Auth::user();
        $givenToken = $request->input('token');

        // Check if the user is authenticated
        if ($user) {
            // Get the remember token
            $token = $user->getRememberToken();

            // Check if token matches the existing one
            if($givenToken === $token) {
                return response()->json(["result" => "success"], 200);
            } else {
                return response()->json(["result" => "fail"], 200);
            }
        } else {
            return response()->json(["result" => "fail"], 200);
        }

    }
}
