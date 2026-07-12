<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectImage extends Model
{
    protected $guarded = [];
    protected function casts(): array { return ['is_featured'=>'boolean']; }
    public function project() { return $this->belongsTo(Project::class); }
    public function getUrlAttribute(): string
    {
        if (Str::startsWith($this->path, ['http://', 'https://'])) return $this->path;
        if (Str::startsWith($this->path, '/')) return url($this->path);
        return Storage::disk('public')->url($this->path);
    }
}
