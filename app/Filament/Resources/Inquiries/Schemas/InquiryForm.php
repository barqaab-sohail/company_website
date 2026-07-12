<?php

namespace App\Filament\Resources\Inquiries\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\{DateTimePicker, Textarea, TextInput};

class InquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(), TextInput::make('email')->email()->required(), TextInput::make('phone'), TextInput::make('subject'), Textarea::make('message')->rows(8)->columnSpanFull(), TextInput::make('status'), DateTimePicker::make('read_at'),
            ]);
    }
}
