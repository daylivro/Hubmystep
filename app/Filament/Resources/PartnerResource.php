<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Partner;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\RewardCategory;
use App\Models\PartnerCategory;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use App\Filament\Resources\PartnerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use App\Filament\Resources\PartnerResource\RelationManagers;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Configuration';
    protected static ?string $label = 'Partenaires';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Date de création')->dateTime('d/m/Y'),
                ImageColumn::make('image')->label('Image'),
                TextColumn::make('name')->label('Nom')->searchable(),
                TextColumn::make('category.name')->label('Catégorie')->searchable()->formatStateUsing(fn($record) => $record->category->name),
                TextColumn::make('phone')->label('Contact')->searchable()->label('Contact'),
                TextColumn::make('reward.value')->label('Recompense')->searchable(),
                ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label(''),
                Tables\Actions\EditAction::make()->label('')
                ->form([
                    Section::make()
                        ->schema([
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
                            PhoneInput::make('phone')->label('Téléphone')->required(),
                            FileUpload::make('image')->label('Logo/Image')->required()->columnSpan(2),
                        ])
                        ->columns(2),
                ])->action(function($record, $data){
                    unset($data['reward_type_id']);
                    $record->update($data);
                }),
                Tables\Actions\DeleteAction::make()->label('')
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('category')->latest();
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
            'index' => Pages\ListPartners::route('/'),
            // 'create' => Pages\CreatePartner::route('/create'),
            'view' => Pages\ViewPartner::route('/{record}'),
            // 'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
