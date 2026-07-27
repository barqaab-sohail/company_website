<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AboutProfile extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'highlights' => 'array',
            'organization_units' => 'array',
            'registrations' => 'array',
            'clients' => 'array',
        ];
    }

    public function mediaUrl(?string $path): ?string
    {
        if (! $path) return null;

        return Str::startsWith($path, ['assets/', '/'])
            ? asset(ltrim($path, '/'))
            : Storage::disk('public')->url($path);
    }

    public function clientRecords(): HasMany
    {
        return $this->hasMany(Client::class)->orderBy('sort_order')->orderBy('id');
    }

    public function registrationRecords(): HasMany
    {
        return $this->hasMany(Registration::class)->orderBy('sort_order')->orderBy('id');
    }
}
