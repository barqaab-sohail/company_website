<?php

namespace App\Filament\Resources\ContactSettings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Inquiry email forwarding')->description('Every new Contact Us inquiry will be saved in Inquiries and a copy will be sent to this address. Leave it empty to disable email forwarding.')->schema([
                TextInput::make('notification_email')->label('Forward inquiries to')->email()->maxLength(255)->placeholder('contact@barqaab.com')->helperText('Your server mail settings must be configured for actual email delivery.'),
            ])->columnSpanFull(),
        ]);
    }
}
