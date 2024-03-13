<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Report;

class ReportController extends Controller{
    public function report(Request $request)
    {
        $validatedData = $request->validate([
            'name'   => 'required|string|min:3|max:20',
            'reason' => 'required|string|max:500',
        ]);

        $report = Report::create($validatedData);

        return response()->json(['success' => 'Report submitted successfully.', 'report' => $report], 201);
    }
}