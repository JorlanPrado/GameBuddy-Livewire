<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $rules = array(
            "name" => "required|min:5|max:15|unique:users,name",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6|max:20",
            "gender" => "required|in:Male,Female,Other",
            "age" => "required|integer|min:1|max:120"
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->gender = $request->gender;
            $user->age = $request->age;

            $result = $user->save();

            if ($result) {
                return response()->json(["Result" => "New user has been registered"], 201);
            } else {
                return response()->json(["Result" => "Failed to register user"], 500);
            }
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->plainTextToken;

            return response()->json(['userId' => $user->id, 'token' => $token], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            return response()->json(['message' => 'Logout successful'], 200);
        }

        return response()->json(['message' => 'User not authenticated'], 401);
    }

    public function list()
    {
        // Fetch all users excluding the admin
        $users = User::where('isAdmin', false)->get();

        return response()->json($users);
    }

    public function update(Request $request, $userId)
    {
        $authenticatedUser = auth()->user();

        // Check if the authenticated user has permission to update the specified user
        if ($authenticatedUser->id !== (int)$userId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validate the request data
        $request->validate([
            'name' => 'sometimes|required|min:3|max:15|unique:users,name,' . $userId,
            'email' => 'sometimes|required|email|unique:users,email,' . $userId,
            'password' => 'sometimes|required|min:6|max:20',
        ]);

        // Find the user by ID
        $user = User::find($userId);

        // Check if the user exists
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Update user information based on the provided data
        $user->fill($request->all());

        // Save the updated user information
        $result = $user->save();

        if ($result) {
            return response()->json(["message" => "User updated successfully"], 200);
        } else {
            return response()->json(["message" => "Failed to update user"], 500);
        }
    }

    public function destroy($userId)
    {
        $authenticatedUser = auth()->user();

        // Check if the authenticated user has permission to delete the specified user
        if ($authenticatedUser->id !== (int)$userId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Find the user by ID
        $user = User::find($userId);

        // Check if the user exists
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Perform any additional checks or logic before deletion (if needed)

        // Delete the user
        $result = $user->delete();

        if ($result) {
            return response()->json(["message" => "User deleted successfully"], 200);
        } else {
            return response()->json(["message" => "Failed to delete user"], 500);
        }
    }
}
