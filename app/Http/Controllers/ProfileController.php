<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProfileRequest;
use App\Models\Profile;


class ProfileController extends Controller
{
public function show($id)
{
    $profile = Profile::where('user_id', $id)->first();
    
    if (!$profile) {
        return response()->json(['message' => 'Profile not found'], 404);
    }

    return response()->json([
        'message' => 'Profile loaded',
        'data'    => $profile
    ], 200);
}

  public function store(StoreProfileRequest $request)
{
    $profile = Profile::create($request->validated());

    return response()->json([
        'message' => 'Profile created successfully',
        'data' => $profile
    ], 201);
}

}