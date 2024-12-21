<?php

namespace App\Filament\Resources\PartnerResource\Pages;

use Filament\Actions;
use App\Models\Partner;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\RewardCategory;
use App\Models\PartnerCategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PartnerResource;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Tapp\FilamentGoogleAutocomplete\Forms\Components\GoogleAutocomplete;


class ListPartners extends ListRecords
{
    use \App\Filament\Traits\Actionable;

    protected static string $resource = PartnerResource::class;
    protected static ?string $title = 'Liste des partenaires';

    protected function getHeaderActions(): array
    {
        return [
            self::create()
                ->form([
                    Section::make()->schema([
                        TextInput::make('name')->label('Nom')->required(),
                        Select::make('partner_category_id')->label('Catégorie')->options(PartnerCategory::pluck('name', 'id'))->required(),
                        Select::make('reward_type_id')->options(RewardCategory::pluck('name', 'id'))->label('Type de recompense')->required()->live(),
                        Select::make('reward_id')
                            ->options(function (Get $get) {
                                if ($get('reward_type_id') === null) {
                                    return [];
                                }
                                return RewardCategory::find($get('reward_type_id'))->rewards->pluck('value', 'id');
                            })
                            ->label('Recompense')

                            ->required(),
                    PhoneInput::make('phone')->label('Téléphone')->required()->columnSpan(2),
                        GoogleAutocomplete::make('location')
                        ->label('Adresse')
                        ->countries([
                            'CI',
                            'MA',
                        ])
                        ->language('fr')
                        ->withFields([
                            TextInput::make('address')
                                ->extraInputAttributes([
                                    'data-google-field' => '{street_number} {route}, {sublocality_level_1}',
                                ]),
                            TextInput::make('country'),
                            TextInput::make('coordinates')
                                ->columnSpan(2)
                                ->extraInputAttributes([
                                    'data-google-field' => '{latitude}, {longitude}',
                                ]),
                        ]),
                        // Geocomplete::make('location')
                        //     ->isLocation()
                        //     ->countries(['ma', 'ci'])
                        //     ->geocodeOnLoad(),

                        FileUpload::make('image')->label('Logo/Image')->required()->columnSpan(2),
                    ])->columns(2),
                ])->action(function ($data) {
                    $coordinates = explode(',', $data['coordinates']);
                    $locationData = [
                        'lat' => (float) trim($coordinates[0]),
                        'lng' => (float) trim($coordinates[1]),
                        'formatted_address' => $data['address'] . ', ' . $data['country']
                    ];

                    $data['location'] = json_encode($locationData);
                    unset($data['coordinates']);
                    unset($data['reward_type_id']);

                    Partner::create($data);
                }),
        ];
    }
}
