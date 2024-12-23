<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\WithdrawalRequest;
use App\Actions\WithdrawalRequest\CreateWithdrawalRequestAction;

/**
 * @group Withdrawal Requests
 *
 * API pour les demandes de retrait
 *
 * @authenticated
 */
class WithdrawalRequestController extends Controller
{
    /**
     * Récupérer les demandes de retrait de l'utilisateur
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $withdrawalRequests = auth()->user()->withdrawalRequests()->get();
        return $this->responseSuccess('Withdrawal requests fetched successfully', $withdrawalRequests);
    }

    /**
     * Créer une demande de retrait
     * @param WithdrawalRequest $request
     * @return JsonResponse
     */
    public function store(WithdrawalRequest $request) : JsonResponse
    {
        if(auth()->user()->userMile->miles < $request->validated()['miles']) {
            return $this->responseUnprocessable('Vous n\'avez pas assez de miles pour faire ce retrait');
        }

        $action = app(CreateWithdrawalRequestAction::class);

        $data = [
            'user_id' => auth()->user()->id,
            'amount' => $this->convertToDh($request->validated()['miles'])
        ];

        $withdrawalRequest = $action(
            data: $data
        );

        return $this->responseSuccess('Demande de retrait créée avec succès', $withdrawalRequest);
    }

    private function convertToDh(int $miles) : int
    {
        return $miles * 0.1;
    }
}
