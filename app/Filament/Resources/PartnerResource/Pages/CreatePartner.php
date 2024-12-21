<?php

namespace App\Filament\Resources\PartnerResource\Pages;

use App\Filament\Resources\PartnerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePartner extends CreateRecord
{
    protected static string $resource = PartnerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // remove reward_id and reward_type_id from the data array
        dd($data);
        unset($data['reward_type_id']);
        // $data['description'] = 'Description du challenge';
        return $data;
    }
}
