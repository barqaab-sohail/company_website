<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\{ImageColumn, TextColumn};
use Filament\Tables\Filters\SelectFilter;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featuredImage.path')->disk('public')->label('Image'),
                TextColumn::make('title')->searchable()->sortable(), TextColumn::make('projectCategory.name')->label('Category')->badge()->sortable(),
                TextColumn::make('images_count')->counts('images')->label('Images'), TextColumn::make('status')->badge(),
            ])
            ->filters([
                SelectFilter::make('project_category_id')->label('Category')->relationship('projectCategory', 'name'),
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
