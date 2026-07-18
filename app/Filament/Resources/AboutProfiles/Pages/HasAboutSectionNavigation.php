<?php

namespace App\Filament\Resources\AboutProfiles\Pages;

use App\Filament\Resources\AboutProfiles\AboutProfileResource;
use Filament\Actions\Action;

trait HasAboutSectionNavigation
{
    protected function getHeaderActions(): array
    {
        $record = $this->getRecord();

        return [
            Action::make('overview')->label('Overview')->url(AboutProfileResource::getUrl('overview', ['record' => $record])),
            Action::make('organization')->label('Organization Chart')->url(AboutProfileResource::getUrl('organization', ['record' => $record])),
            Action::make('registration')->label('Registration')->url(AboutProfileResource::getUrl('registration', ['record' => $record])),
            Action::make('clients')->label('Clients')->url(AboutProfileResource::getUrl('clients', ['record' => $record])),
            Action::make('expertise')->label('Expertise')->url(AboutProfileResource::getUrl('expertise', ['record' => $record])),
        ];
    }
}
