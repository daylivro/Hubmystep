<?php

namespace App\Livewire\Tables;

use App\Models\User;
use Livewire\Component;
use Filament\Tables\Table;
use App\Models\ChallengeUser;
use Filament\Tables\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;



class Participation extends Component implements HasTable, HasForms
{

    use InteractsWithTable;
    use InteractsWithForms;

    public $challenge;

    public function mount()
    {
        $this->challenge->load('participants');
    }


    public function table(Table $table): Table
    {

        return $table->query(ChallengeUser::query()->where('challenge_id', $this->challenge->id)->with('user')->latest())
            ->columns([
                TextColumn::make('created_at')->searchable()->sortable()->dateTime('d/m/Y')->label('Date d\'inscripition'),
                TextColumn::make('user.name')->searchable()->sortable()->label('Nom complet'),
                TextColumn::make('user.email')->searchable()->sortable()->label('Email'),
                TextColumn::make('id')->searchable()->sortable()
                    ->label('Parts effectués')
                    ->formatStateUsing(fn($record) =>
                    $record->currentParts()),
                TextColumn::make('updated_at')->searchable()->sortable()
                    ->label('Jours restants')
                    ->formatStateUsing(fn($record) => $record->remainingDays()),

            ])->actions([
                Action::make('view')
                    ->icon('heroicon-o-eye')
                    ->label('')->tooltip('Consulter')->url(fn($record) => route('filament.hub.resources.challenge-users.view', $record))
            ]);
    }
    public function render()
    {
        return view('livewire.tables.participation');
    }
}
