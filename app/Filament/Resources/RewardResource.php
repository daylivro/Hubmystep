<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Reward;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\RewardCategory;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RewardResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RewardResource\RelationManagers;

class RewardResource extends Resource
{
    protected static ?string $model = Reward::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift-top';
    protected static ?string $navigationGroup = 'Configuration';
    protected static ?string $label = 'Récompenses';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')->label('Catégorie'),
                TextColumn::make('value')->label('Valeur'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('')
                    ->tooltip('Editer')
                    ->form([
                        Select::make('reward_category_id')
                            ->label('Catégorie')
                            ->options(RewardCategory::pluck('name', 'id'))
                            ->required(),
                        TextInput::make('value')->label('La valeur')->required(),
                    ]),
                Tables\Actions\DeleteAction::make()->label('')->tooltip('Supprimer'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListRewards::route('/'),
            // 'create' => Pages\CreateReward::route('/create'),
            // 'edit' => Pages\EditReward::route('/{record}/edit'),
        ];
    }
}
