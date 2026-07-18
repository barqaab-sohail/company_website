<?php

namespace App\Filament\Resources\AboutProfiles\Pages;

use App\Filament\Resources\AboutProfiles\AboutProfileResource;
use App\Filament\Resources\AboutProfiles\Schemas\AboutRegistrationForm;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

class EditAboutRegistration extends EditRecord
{
    use HasAboutSectionNavigation;

    protected static string $resource = AboutProfileResource::class;

    protected static ?string $title = 'About Us - Registration';

    public function form(Schema $schema): Schema
    {
        return AboutRegistrationForm::configure($schema);
    }
}
