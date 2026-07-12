<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $guarded = [];
    protected function casts(): array { return ['items'=>'array','is_active'=>'boolean']; }
    public function getImageUrlAttribute(): ?string { if(!$this->image)return null; return Str::startsWith($this->image,['assets/','/']) ? asset(ltrim($this->image,'/')) : Storage::disk('public')->url($this->image); }
}
