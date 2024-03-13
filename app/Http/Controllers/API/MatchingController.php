<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MatchingController extends Controller
{
    public function startMatching(Request $request)
    {
        $userId = $request->input('user_id');
        $interestId = $request->input('interest_id');

        try {
            $currentUserInterests = User::findOrFail($userId)->interests->pluck('id')->toArray();

            $randomUser = User::where('id', '!=', $userId)
                ->where('isAdmin', false)
                ->whereHas('interests', function ($query) use ($currentUserInterests, $interestId) {
                    $query->whereIn('interest_id', $currentUserInterests)
                        ->orWhere('interest_id', $interestId);
                })
                ->inRandomOrder()
                ->firstOrFail();

            // You may want to customize the response structure based on your API requirements
            return response()->json([
                'random_user' => $randomUser,
                'show_user' => true,
            ]);
        } catch (ModelNotFoundException $exception) {
            // Handle the case where no matching user is found
            return response()->json([
                'random_user' => null,
                'show_user' => true,
            ]);
        }
    }
}
