<?php

namespace App\Filament\Resources\ChallengeResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use App\Models\ChallengeReward;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ChallengeResource;

class CreateChallenge extends CreateRecord
{
    protected static string $resource = ChallengeResource::class;
    protected static ?string $title = 'Créer un challenge';

    protected function getHeaderActions(): array
    {
        return [Action::make('back')->label('Retour')->color('gray')->url(url('/hub/challenges'))->icon('heroicon-o-arrow-turn-down-left')];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // remove reward_id and reward_type_id from the data array
        unset($data['reward_id']);
        unset($data['reward_type_id']);
        // $data['description'] = 'Description du challenge';
        return $data;
    }

    protected function afterCreate(): void
    {
        ChallengeReward::create([
            'challenge_id' => $this->record->id,
            'reward_id' => $this->data['reward_id'],
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
