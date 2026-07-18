<?php

namespace App\Filament\Resources\ManagementMembers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\{IconColumn, ImageColumn, TextColumn};

class ManagementMembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')->label('Photo')->getStateUsing(fn ($record) => $record->photo_url)->circular(),
                TextColumn::make('name')->searchable()->sortable(), TextColumn::make('designation')->searchable(), TextColumn::make('sort_order')->sortable(), IconColumn::make('is_active')->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
