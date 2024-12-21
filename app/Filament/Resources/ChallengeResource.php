<?php

namespace App\Filament\Resources;

use Wizard\Step;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\Challenge;
use Filament\Tables\Table;
use App\Models\ChallengeType;
use App\Models\RewardCategory;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\ChallengeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ChallengeResource\RelationManagers;

class ChallengeResource extends Resource
{
    protected static ?string $model = Challenge::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = 'Challenges';
    protected static ?string $label = 'Challenges';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Wizard::make([
                Wizard\Step::make('Informations générales')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        TextInput::make('title')->label('Libellé')->required(),
                        TextInput::make('number_of_parts')->label('Nombre de pars')->required()->rules(['integer'])->suffix(' pars'),
                        TextInput::make('duration')->label('Duree')->required()->rules(['integer'])->suffix(' jours'),
                        TextInput::make('amount')
                            ->label('Montant de la participation')
                            ->rules(['integer'])
                            ->required()
                            ->suffix(' diram'),
                        Textarea::make('description')->label('Description')->columnSpan(2)->required(),
                        FileUpload::make('image')->label('Image')->columnSpan(2)->required(),
                    ])
                    ->columns(2),
                Wizard\Step::make('Recompenses')->schema([
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
                ]),
            ])->columnSpanFull(),
        ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Créé le')->dateTime('d/m/Y'),
                TextColumn::make('title')->label('Titre'),
                TextColumn::make('amount')->label('Montant de participation'),
                TextColumn::make('duration')->label('Duree'),
                TextColumn::make('number_of_parts')->label('Nombre de parts'),
                TextColumn::make('id')->label('Statut')->formatStateUsing(fn($record) => $record->isActive() ? 'Actif' : 'Inactif')->badge()->color(fn($record) => $record->isActive() ? 'success' : 'danger'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('')->icon('heroicon-o-eye')->tooltip('Consulter'),
                Tables\Actions\EditAction::make()->label('')->icon('heroicon-o-pencil')->tooltip('Editer'),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('rewards')->latest();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChallenges::route('/'),
            'create' => Pages\CreateChallenge::route('/create'),
            'view' => Pages\ViewChallenge::route('/{record}'),
            'edit' => Pages\EditChallenge::route('/{record}/edit'),
        ];
    }
}
