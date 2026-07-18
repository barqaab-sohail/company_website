<?php

namespace App\Filament\Resources\AboutProfiles\Tables;

use App\Filament\Resources\AboutProfiles\AboutProfileResource;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AboutProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('organization_units')->label('Organization Units')->formatStateUsing(fn ($state) => count($state ?? [])),
                TextColumn::make('registrations')->label('Registrations')->formatStateUsing(fn ($state) => count($state ?? [])),
                TextColumn::make('clients')->label('Clients')->formatStateUsing(fn ($state) => count($state ?? [])),
                TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->recordActions([
                Action::make('overview')
                    ->label('Overview')
                    ->icon('heroicon-o-document-text')
                    ->url(fn ($record) => AboutProfileResource::getUrl('overview', ['record' => $record])),
                Action::make('organization')
                    ->label('Organization Chart')
                    ->icon('heroicon-o-building-office-2')
                    ->url(fn ($record) => AboutProfileResource::getUrl('organization', ['record' => $record])),
                Action::make('registration')
                    ->label('Registration')
                    ->icon('heroicon-o-identification')
                    ->url(fn ($record) => AboutProfileResource::getUrl('registration', ['record' => $record])),
                Action::make('clients')
                    ->label('Clients')
                    ->icon('heroicon-o-user-group')
                    ->url(fn ($record) => AboutProfileResource::getUrl('clients', ['record' => $record])),
                Action::make('expertise')
                    ->label('Expertise')
                    ->icon('heroicon-o-academic-cap')
                    ->url(fn ($record) => AboutProfileResource::getUrl('expertise', ['record' => $record])),
            ]);
    }
}
