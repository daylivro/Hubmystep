<?php

namespace App\Http\Controllers\API;

use App\Models\Challenge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChallengeResource;

/**
 * @group Challenge
 */
class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @unauthenticated
     */
    public function index()
    {
        return ChallengeResource::collection(Challenge::latest()->with('rewards')->get());
    }

    /**
     * store new participant to the challenge.
     * @authenticated
     */
    public function addParticipant(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Challenge $challenge)
    {
        return new ChallengeResource($challenge);
    }
}
