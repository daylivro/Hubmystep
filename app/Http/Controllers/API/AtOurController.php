<?php

namespace App\Http\Controllers\API;

use App\Models\AtOurPartner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Scan\GenerateScanCode;
use App\Http\Requests\Partner\WalkingRequest;
/**
 * @group  Visit Our Partner
 * @authenticated
 */
class AtOurController extends Controller
{
    /**
     * Historique des visites chez nos partenaires
     *
     * @return void
     */
    public function index()
    {
        $atOurPartner = AtOurPartner::with('partner')
            ->where('user_id', auth()->user()->id)
            ->get();

        return $this->responseSuccess('', $atOurPartner);
    }


        /**
     * Starting march towards the partner
     *
     * @bodyParam partner_id int required
     * @param Request $request
     * @return void
     * @authenticated
     */
    public function startWalking(WalkingRequest $request)
    {
        $validated = $request->validated();
        $partner = \App\Models\Partner::find($validated['partner_id']);

        if (!$partner) {
            return $this->responseUnprocessable('Le partenaire n\'existe pas');
        }

        if (AtOurPartner::ensureUserHasNotVisitInProgress()) {
            return $this->responseUnprocessable('vous avez déjà un challenge en cours pour ce partenaire');
        }

        $atOurPartner = AtOurPartner::create([
            'user_id' => auth()->user()->id,
            'partner_id' => $validated['partner_id'],
            'minimum_steps' => $validated['minimum_steps'],
            'current_steps_in_beginning' => $validated['current_steps_in_beginning'],
        ]);

        return $this->responseSuccess('Votre visite au partenaire a été lancée avec succès');
    }

    /**
     * Mark the march towards the partner as done
     *
     * @param WalkingRequest $request
     * @bodyParam challenge_id int required
     * @bodyParam current_latitude float required
     * @bodyParam current_longitude float required
     * @authenticated
     */
    public function markAsWalked(WalkingRequest $request, GenerateScanCode $generateScanCode)
    {
        $atOurPartner = AtOurPartner::query()
            ->where([
                'done' => false,
                'scan_at' => null,
            ])
            ->with('partner')
            ->whereId($request->challenge_id)
            ->first();

        if (! $atOurPartner) {
            return $this->responseNotFound('Le challenge n\'existe pas ou a déjà été marqué comme terminé');
        }

        $stepsCompleted = $request->current_steps_in_end - $atOurPartner->current_steps_in_beginning;

        if ($stepsCompleted < $atOurPartner->minimum_steps) {
            return $this->responseUnprocessable(
                sprintf(
                    'Vous devez faire au minimum %d pas. Vous avez fait seulement %d pas.',
                    $atOurPartner->minimum_steps,
                    $stepsCompleted
                )
            );
        }

        $atOurPartner->update([
            'done' => true,
            'current_steps_in_end' => $request->current_steps_in_end,
        ]);

        $generateScanCode->execute($atOurPartner);

        return $this->responseSuccess('Votre visite au partenaire a été marquée comme terminée avec succès', [
            'scan_url' => $atOurPartner->win_scan_url
        ]);
    }

    /**
     * Action de transfert des points de visite chez un partenaire dans le wallet
     *
     * @param WalkingRequest $request
     * @return void
     */
    public function transfertRewards(WalkingRequest $request)
    {
        $atOurPartner = AtOurPartner::find($request->challenge_id);

        if($atOurPartner->scan_at) {
            return $this->responseUnprocessable('Impossible de transférer les points de visite, car le challenge a déjà été marqué comme terminé');
        }

        if(! $atOurPartner) {
            return $this->responseUnprocessable('Le challenge n\'existe pas');
        }

        $userMile = $atOurPartner->user->userMile;

        $userMile->update([
            'miles' => $userMile->mile + $atOurPartner->partner->reward->value
        ]);

        $atOurPartner->update(['scan_at' => now()]);

        return $this->responseSuccess('Les points de visite ont été transférés avec succès');
    }

    /**
     * Mark the march towards the partner as left
     *
     * @param AtOurPartner $atOurPartner
     * @return void
     */
    public function leftWalking(AtOurPartner $atOurPartner)
    {
        if($atOurPartner->isLeft()) {
            return $this->responseUnprocessable('vous avez déjà quitté votre visite au partenaire');
        }
        $atOurPartner->update(['left' => true]);
        return $this->responseSuccess('Vous avez quitté votre visite au partenaire avec succès');
    }
}
