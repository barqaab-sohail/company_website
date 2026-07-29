<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ContactSetting extends Model
{
    protected $guarded = [];

    public function getLogoUrlAttribute(): string
    {
        return $this->logo
            ? Storage::disk('public')->url($this->logo)
            : asset('assets/images/contact-barqaab-logo.png');
    }
}
