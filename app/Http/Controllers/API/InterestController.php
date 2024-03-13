<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Interest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class InterestController extends Controller
{
    // UPDATE ------------------------------
    public function updateInterests(Request $request, $userId)
    {
        // Find the user
        $user = User::find($userId);
    
        // Handle user not found case
        if (!$user) {
            return response()->json(['result' => 'User not found'], 404);
        }
    
        // Validate request data
        $request->validate([
            'interests' => 'required|array|min:1|max:5',
        ]);
    
        $interests = [];
    
        // Process each interest from the request
        foreach ($request->interests as $interest) {
            $interestId = $interest['id'] ?? null;
    
           
            if (!$interestId) {
                $newInterest = Interest::create(['name' => $interest['game']]);
                $interestId = $newInterest->id;
            }
    
            
            $interests[] = $interestId;
        }
    
        $user->interests()->sync($interests);
    
        // Return a successful response
        return response()->json([
            'result' => 'Interests updated successfully',
            'user' => $user,
            
        ]);
    }
}
