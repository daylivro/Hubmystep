<?php

namespace App\Http\Controllers\API;

use App\Models\Challenge;
use Illuminate\Http\Request;
use App\Models\ChallengeUser;
use App\States\Challenge\Pending;
use App\States\Challenge\Cancelled;
use App\States\Challenge\Completed;
use App\Http\Controllers\Controller;
use App\States\Challenge\InProgress;
use App\Http\Resources\ParticipationResource;
use App\Http\Requests\CreateParticipationRequest;
use App\Http\Requests\MarkChallengeAsPaidRequest;
use App\Actions\Challenge\CreateParticipationAction;
use App\Actions\Challenge\MarkChallengeAsPaidAction;

/**
 * @group Participation
 *
 * All participation related endpoints
 * @authenticated
 */
class ParticipationController extends Controller
{
    /**
     * Historique des participations
     *
     * @return void
     */
    public function index()
    {
        $participations = ChallengeUser::where('user_id', auth()->id())->latest()->with('challenge.rewards')->get();
        return $this->responseSuccess('', ParticipationResource::collection($participations));
    }

    /**
     * store new participant to the challenge.
     *
     * @param CreateParticipationRequest $request
     * @param CreateParticipationAction $createParticipationAction
     * @return void
     */
    public function store(CreateParticipationRequest $request, CreateParticipationAction $createParticipationAction)
    {
        $challenge = Challenge::find($request->challenge_id);

        $challengeUser = ChallengeUser::where(['user_id' => auth()->id(), 'challenge_id' => $challenge->id])
            ->whereNotState('state', [Completed::class, Cancelled::class])
            ->get();

        if ($challengeUser->count() > 0) {
            return $this->responseUnprocessable('Participation already exists for this challenge');
        }

       $challengeUser =  $createParticipationAction->execute([
            'challenge_id' => $challenge->id,
            'user_id' => $request->user()->id,
            'amount' => $challenge->amount,
            'duration' => $challenge->duration,
            'goal' => $challenge->number_of_parts,
        ]);

        (new MarkChallengeAsPaidAction())->execute($challengeUser);

        return $this->responseSuccess('Participation created successfully');
    }


    /**
     * Mark participation as paid for test and run start action
     */
    public function markAsPaid(MarkChallengeAsPaidRequest $request, MarkChallengeAsPaidAction $markChallengeAsPaidAction)
    {
        $challengeUser = ChallengeUser::find($request->challenge_user_id);
      if(! $challengeUser->state->equals(Pending::class)) {
            return $this->responseUnprocessable('Participation already paid');
        }
        $markChallengeAsPaidAction->execute($challengeUser);
        return $this->responseSuccess('Participation started successfully');
    }
}
