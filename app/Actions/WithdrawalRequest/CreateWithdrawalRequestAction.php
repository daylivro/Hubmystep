<?php

namespace App\Actions\WithdrawalRequest;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\WithdrawalRequest;
use App\Events\Withdrawal\WithdrawalRequestCreated;

class CreateWithdrawalRequestAction
{
    /**
     * Crée une nouvelle demande de retrait
     *
     * @param User $user
     * @param array<string, mixed> $data
     * @return WithdrawalRequest
     */
    public function __invoke( array $data): WithdrawalRequest
    {
        $withdrawalRequest = WithdrawalRequest::create([
            'identifier' => Str::upper($this->ensureIdentifierIsUnique("WR-".date('Ymd')."-".Str::random(2))),
            'amount' => (int) $data['amount'],
            'status' => 'pending',
            'user_id' => Arr::get($data, 'user_id')
        ]);

        // WithdrawalRequestCreated::dispatch($withdrawalRequest);

        return $withdrawalRequest;
    }

    private function ensureIdentifierIsUnique(string $identifier): string
    {
        if (WithdrawalRequest::where('identifier', $identifier)->exists()) {
            return  $this->ensureIdentifierIsUnique(Str::random(10));
        }

        return $identifier;
    }
}
