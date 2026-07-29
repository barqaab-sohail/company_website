<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use App\Models\ContactSetting;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected array $contactSettings = [];

    private const CONTACT_FIELDS = [
        'email_heading', 'office_heading', 'company_name', 'address', 'phone',
        'fax', 'public_email', 'notification_email', 'logo', 'map_embed_url',
    ];

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (in_array($data['slug'] ?? null, ['contact', 'contact-us'], true)) {
            $settings = ContactSetting::query()->first();

            foreach (self::CONTACT_FIELDS as $field) {
                $data[$field] = $settings?->{$field};
            }
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (in_array($data['slug'] ?? null, ['contact', 'contact-us'], true)) {
            foreach (self::CONTACT_FIELDS as $field) {
                $this->contactSettings[$field] = $data[$field] ?? null;
            }
        }

        foreach (self::CONTACT_FIELDS as $field) {
            unset($data[$field]);
        }

        return $data;
    }

    protected function afterSave(): void
    {
        if (in_array($this->record->slug, ['contact', 'contact-us'], true)) {
            ContactSetting::query()->updateOrCreate(
                ['id' => ContactSetting::query()->value('id') ?? 1],
                $this->contactSettings,
            );
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
