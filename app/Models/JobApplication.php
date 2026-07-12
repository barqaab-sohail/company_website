<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $guarded = [];
    protected function casts(): array { return ['education'=>'array','total_experience'=>'decimal:1']; }
    public function content() { return $this->belongsTo(Content::class); }
    public function jobOpening() { return $this->belongsTo(JobOpening::class); }
}
