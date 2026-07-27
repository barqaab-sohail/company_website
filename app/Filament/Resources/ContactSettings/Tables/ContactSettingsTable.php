<?php

namespace App\Filament\Resources\ContactSettings\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('notification_email')->label('Inquiry forwarding email')->placeholder('Not configured'),
            TextColumn::make('updated_at')->label('Last updated')->dateTime()->sortable(),
        ])->recordActions([EditAction::make()->label('Configure')]);
    }
}
