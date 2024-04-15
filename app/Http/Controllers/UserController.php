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
            return response()->json(["result" => "success", "user_id" => $userId], 200);
        } else {
            return response()->json(["result" => "fail"], 200);
        }
    }
}
