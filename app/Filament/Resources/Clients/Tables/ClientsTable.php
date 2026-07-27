<?php

namespace App\Filament\Resources\Clients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                ImageColumn::make('logo')->label('Logo')->disk('public')->height(42)->width(64),
                TextColumn::make('name')->searchable()->sortable()->weight('medium'),
                TextColumn::make('website')->label('Website')->searchable()->limit(38)->url(fn ($record) => $record->website)->openUrlInNewTab()->placeholder('—'),
                TextColumn::make('sort_order')->label('Order')->sortable(),
                IconColumn::make('is_active')->label('Visible')->boolean()->sortable(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
