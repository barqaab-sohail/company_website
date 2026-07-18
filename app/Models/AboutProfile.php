<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
}
