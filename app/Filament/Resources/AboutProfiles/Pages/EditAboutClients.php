<?php

namespace App\Filament\Resources\AboutProfiles\Pages;

use App\Filament\Resources\AboutProfiles\AboutProfileResource;
use App\Filament\Resources\AboutProfiles\Schemas\AboutClientsForm;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

class EditAboutClients extends EditRecord
{
    use HasAboutSectionNavigation;

    protected static string $resource = AboutProfileResource::class;

    protected static ?string $title = 'About Us - Clients';

    public function form(Schema $schema): Schema
    {
        return AboutClientsForm::configure($schema);
    }
}
