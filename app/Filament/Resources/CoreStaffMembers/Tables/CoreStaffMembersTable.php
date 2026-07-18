<?php

namespace App\Filament\Resources\CoreStaffMembers\Tables;

use Filament\Actions\{BulkActionGroup, DeleteBulkAction, EditAction};
use Filament\Tables\Columns\{IconColumn, ImageColumn, TextColumn};
use Filament\Tables\Table;

class CoreStaffMembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')->label('Photo')->getStateUsing(fn ($record) => $record->photo_url)->circular(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('designation')->searchable(),
                TextColumn::make('years_experience')->label('Experience'),
                TextColumn::make('sort_order')->sortable(),
                IconColumn::make('is_active')->boolean(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
