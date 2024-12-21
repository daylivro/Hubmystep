<?php

namespace App\Livewire\Tables;

use Livewire\Component;

use Filament\Tables\Table;
use App\Models\ChallengeUser;
use Faker\Provider\ar_EG\Text;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Challenge extends Component implements HasTable, HasForms
{

    use InteractsWithTable;
    use InteractsWithForms;

    public $user;
    // public function mount()
    // {
    //     $this->user->load('challenges');
    // }
    public function table(Table $table): Table
    {

        return $table->query(ChallengeUser::query()->where('user_id', $this->user->id)->with('challenge')->latest())
            ->columns([
                TextColumn::make('created_at')->searchable()->sortable()->dateTime('d/m/Y')->label('Date d\'inscripition'),
                TextColumn::make('challenge.title')->searchable()->sortable()->label('Challenge'),
                TextColumn::make('challenge.amount')->searchable()->sortable()->label('Montant de participation'),
                TextColumn::make('challenge.duration')->searchable()->sortable()->label('Duree'),
            ]);
    }
    public function render()
    {
        return view('livewire.tables.challenge');
    }
}