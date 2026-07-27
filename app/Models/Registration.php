<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Registration extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'show_document' => 'boolean'];
    }

    public function aboutProfile(): BelongsTo { return $this->belongsTo(AboutProfile::class); }

    public function getDocumentUrlAttribute(): ?string
    {
        return $this->document ? Storage::disk('public')->url($this->document) : null;
    }

}
