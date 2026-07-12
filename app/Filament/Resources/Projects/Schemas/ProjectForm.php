<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\{DateTimePicker, FileUpload, Repeater, RichEditor, Select, Textarea, TextInput, Toggle};
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Project')->schema([
                    TextInput::make('title')->required()->live(onBlur:true)->afterStateUpdated(fn($state,$set)=>$set('slug',Str::slug($state))),
                    TextInput::make('slug')->required()->unique(ignoreRecord:true),
                    Select::make('category')->options(['power-projects'=>'Power Projects','dams-hydropower'=>'Dams and Hydropower','canals-barrages-drains'=>'Canals, Barrages and Drains','environment'=>'Environment','construction-highways'=>'Construction']),
                    Textarea::make('subtitle')->columnSpanFull(),
                    RichEditor::make('body')->columnSpanFull(),
                    Textarea::make('scope_of_project')->label('Scope of the Project')->rows(7)->columnSpanFull(),
                    Textarea::make('scope_of_services')->label('Scope of Services')->rows(7)->columnSpanFull(),
                ])->columns(2)->columnSpanFull(),
                Section::make('Project Images')->description('Upload and reorder any number of images. Mark one image as featured for the project listing.')->schema([
                    Repeater::make('images')->relationship()->schema([
                        FileUpload::make('path')->image()->disk('public')->directory('project-gallery')->maxSize(10240)->imagePreviewHeight('180')->required()->columnSpanFull(),
                        TextInput::make('caption'), TextInput::make('alt_text')->label('Alternative text'),
                        TextInput::make('sort_order')->numeric()->default(0), Toggle::make('is_featured')->label('Featured image'),
                    ])->columns(2)->reorderable('sort_order')->addActionLabel('Add project image')->columnSpanFull(),
                ])->columnSpanFull(),
                Section::make('Publishing')->schema([
                    Select::make('status')->options(['draft'=>'Draft','published'=>'Published','archived'=>'Archived'])->default('published')->required(),
                    DateTimePicker::make('published_at')->default(now()), TextInput::make('sort_order')->numeric()->default(0),
                ])->columns(3)->columnSpanFull(),
            ]);
    }
}
