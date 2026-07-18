<?php

namespace App\Filament\Resources\AboutProfiles\Pages;

use App\Filament\Resources\AboutProfiles\AboutProfileResource;
use App\Filament\Resources\AboutProfiles\Schemas\AboutOrganizationForm;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

class EditAboutOrganization extends EditRecord
{
    use HasAboutSectionNavigation;

    protected static string $resource = AboutProfileResource::class;

    protected static ?string $title = 'About Us - Organization Chart';

    public function form(Schema $schema): Schema
    {
        return AboutOrganizationForm::configure($schema);
    }
}
