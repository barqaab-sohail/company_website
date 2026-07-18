<?php

namespace App\Filament\Resources\AboutProfiles\Pages;

use App\Filament\Resources\AboutProfiles\AboutProfileResource;
use App\Filament\Resources\AboutProfiles\Schemas\AboutOverviewForm;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

class EditAboutProfile extends EditRecord
{
    use HasAboutSectionNavigation;

    protected static string $resource = AboutProfileResource::class;

    protected static ?string $title = 'About Us - Overview';

    public function form(Schema $schema): Schema
    {
        return AboutOverviewForm::configure($schema);
    }
}
