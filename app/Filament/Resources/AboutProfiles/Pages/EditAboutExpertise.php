<?php

namespace App\Filament\Resources\AboutProfiles\Pages;

use App\Filament\Resources\AboutProfiles\AboutProfileResource;
use App\Filament\Resources\AboutProfiles\Schemas\AboutExpertiseForm;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

class EditAboutExpertise extends EditRecord
{
    use HasAboutSectionNavigation;

    protected static string $resource = AboutProfileResource::class;

    protected static ?string $title = 'About Us - Expertise';

    public function form(Schema $schema): Schema
    {
        return AboutExpertiseForm::configure($schema);
    }
}
