<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CoreStaffMember extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (! $this->photo) return null;

        return Str::startsWith($this->photo, ['assets/', '/'])
            ? asset(ltrim($this->photo, '/'))
            : Storage::disk('public')->url($this->photo);
    }
}
