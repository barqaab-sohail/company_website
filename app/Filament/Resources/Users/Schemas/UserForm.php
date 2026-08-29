<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Account')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                    TextInput::make('password')
                        ->password()
                        ->revealable()
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->dehydrated(fn (?string $state): bool => filled($state))
                        ->minLength(8)
                        ->helperText('Leave blank while editing to keep the current password.'),
                    Toggle::make('is_active')
                        ->label('Allow login')
                        ->default(true),
                    Toggle::make('is_super_admin')
                        ->label('Full administrator access')
                        ->helperText('Full administrators can manage users and access every section.')
                        ->live(),
                ])
                ->columns(2),
            Section::make('Page permissions')
                ->description('Select the administration sections this user may open and manage.')
                ->schema([
                    CheckboxList::make('permissions')
                        ->hiddenLabel()
                        ->options(User::PERMISSIONS)
                        ->columns(3)
                        ->bulkToggleable()
                        ->disabled(fn ($get): bool => (bool) $get('is_super_admin')),
                ]),
        ]);
    }
}
