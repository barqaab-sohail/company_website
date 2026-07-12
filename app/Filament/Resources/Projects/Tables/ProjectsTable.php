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
                TextColumn::make('title')->searchable()->sortable(), TextColumn::make('category')->badge(),
                TextColumn::make('images_count')->counts('images')->label('Images'), TextColumn::make('status')->badge(),
            ])
            ->filters([
                SelectFilter::make('category')->options(['power-projects'=>'Power Projects','dams-hydropower'=>'Dams and Hydropower','canals-barrages-drains'=>'Canals, Barrages and Drains','environment'=>'Environment','construction-highways'=>'Construction']),
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
