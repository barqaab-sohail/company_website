<?php

namespace App\Filament\Resources\Registrations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table->defaultSort('sort_order')->columns([
            TextColumn::make('title')->searchable()->sortable()->wrap()->weight('medium'),
            TextColumn::make('number')->label('Registration No.')->searchable()->placeholder('—')->wrap(),
            IconColumn::make('document')->label('File')->boolean(fn ($state) => filled($state))->trueIcon('heroicon-o-document-check')->falseIcon('heroicon-o-minus')->trueColor('success')->falseColor('gray')->url(fn ($record) => $record->document_url)->openUrlInNewTab(),
            IconColumn::make('show_document')->label('Full view')->boolean()->sortable(),
            TextColumn::make('sort_order')->label('Order')->sortable(),
            IconColumn::make('is_active')->label('Visible')->boolean()->sortable(),
        ])->recordActions([EditAction::make()])->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
