<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['meta' => 'array', 'published_at' => 'datetime'];
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
