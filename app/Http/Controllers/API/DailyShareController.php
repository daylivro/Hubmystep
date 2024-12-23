<?php

namespace App\Http\Controllers\API;

use App\Models\DailyShare;
use Illuminate\Http\Request;
use App\Services\DailyShareService;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailyShareResource;
use App\Http\Requests\Share\ValideDailyShareRequest;

/**
 * @group  Parts
 *
 * @authenticated
 */
class DailyShareController extends Controller
{
    /**
     * Historique des parts journaliers
     */
    public function index()
    {
        return DailyShareResource::collection(DailyShare::whereUserId(auth()->id())->latest()->get());
    }

    /**
     * Valider les parts journaliers
     */
    public function store(ValideDailyShareRequest $request, DailyShareService $validateShareSerivice)
    {
        // if(DailyShare::today()->whereUserId(auth()->id())->count() > 0) {
        //     return $this->responseUnprocessable('Today part is already validated');
        // }

        $dayliShare = DailyShare::create([
            'user_id' => auth()->id(),
            'shares' => $request->shares,
            'date' => today()
        ]);

        $validateShareSerivice->save($dayliShare);
        return $this->responseSuccess('Vos parts journaliers ont été validées avec succès');
    }

    /**
     * Total des parts d'un utilisateur
     */
    public function userHistory()
    {
        return $this->responseSuccess('', [
            'total' => DailyShare::whereUserId(auth()->id())->sum('shares')
        ]);
    }
}
