<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];
    protected function casts(): array { return ['meta'=>'array','published_at'=>'datetime']; }
    public function images() { return $this->hasMany(ProjectImage::class)->orderBy('sort_order'); }
    public function featuredImage() { return $this->hasOne(ProjectImage::class)->where('is_featured', true)->orderBy('sort_order'); }
}
