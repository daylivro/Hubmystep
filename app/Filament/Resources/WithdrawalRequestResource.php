<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\WithdrawalRequest;
use Filament\Tables\Filters\Filter;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\WithdrawalRequestResource\Pages;
use App\Filament\Resources\WithdrawalRequestResource\RelationManagers;

class WithdrawalRequestResource extends Resource
{
    protected static ?string $model = WithdrawalRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Gestion des retraits';
    protected static ?string $navigationLabel = 'Retraits';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->dateTime('d/m/Y H:i')->label('Date de création'),
                Tables\Columns\TextColumn::make('identifier')->label('Identifiant'),
                Tables\Columns\TextColumn::make('amount')->label('Montant'),
                Tables\Columns\TextColumn::make('status')->label('Statut')
                    ->color(function($state) {
                        return match($state) {
                            'pending' => 'warning',
                            'accepted' => 'success',
                            'rejected' => 'danger',
                        };
                    })
                    ->formatStateUsing(function($record) {
                        return match($record->status) {
                            'pending' => 'En attente',
                            'accepted' => 'Approuvée',
                            'rejected' => 'Rejetée',
                        };
                    })
                    ->badge(),
                Tables\Columns\TextColumn::make('user_id')->label('Utilisateur')->formatStateUsing(fn ($record) => $record->user->first_name.' '.$record->user->last_name),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'En attente',
                        'accepted' => 'Approuvée',
                        'rejected' => 'Rejetée',
                    ])
                    ->label('Statut'),
                Filter::make('created_at')
                    ->label('Date de création')
                    ->form([
                        DatePicker::make('created_at_from')
                            ->label('De')
                            ->native(false),
                        DatePicker::make('created_at_to')
                            ->label('À')
                            ->native(false),
                    ])
                    ->query(function(Builder $query, array $data) {
                        return $query
                            ->when($data['created_at_from'], fn ($query, $date) => $query->whereDate('created_at', '>=', $date))
                            ->when($data['created_at_to'], fn ($query, $date) => $query->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('mark_as_approved')
                    ->label('')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->hidden(fn ($record) => $record->status !== 'pending')
                    ->modalHeading('Approuver le retrait')
                    ->modalDescription('Voulez-vous vraiment approuver ce retrait ?')
                    ->tooltip('Approuver le retrait')
                    ->action(function($record) {
                        $record->update(['status' => 'accepted']);
                        $miles = $record->amount / 0.1;
                        $record->user->userMile->decrement('miles', $miles);
                        Notification::make()
                            ->title('Retrait approuvé')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('mark_as_rejected')
                    ->label('')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->hidden(fn ($record) => $record->status !== 'pending')
                    ->modalHeading('Rejeter le retrait')
                    ->modalDescription('Voulez-vous vraiment rejeter ce retrait ?')
                    ->tooltip('Rejeter le retrait')
                    ->action(function($record) {
                        $record->update(['status' => 'rejected']);
                        Notification::make()
                            ->title('Retrait rejeté')
                            ->success()
                            ->send();
                    }),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderBy('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWithdrawalRequests::route('/'),
            'create' => Pages\CreateWithdrawalRequest::route('/create'),
            'view' => Pages\ViewWithdrawalRequest::route('/{record}'),
            'edit' => Pages\EditWithdrawalRequest::route('/{record}/edit'),
        ];
    }
}
