<?php

namespace App\Filament\Resources\JobOpenings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\{IconColumn, TextColumn};

class JobOpeningsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(), TextColumn::make('location'),
                TextColumn::make('minimum_qualification')->label('Minimum Qualification')->limit(45)->tooltip(fn ($record) => $record->minimum_qualification),
                TextColumn::make('experience_required')->label('Experience Required')->limit(40)->tooltip(fn ($record) => $record->experience_required),
                TextColumn::make('closing_date')->date()->sortable(), TextColumn::make('applications_count')->counts('applications')->label('Applications'), IconColumn::make('is_active')->boolean(),
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
