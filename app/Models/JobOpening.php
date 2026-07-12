<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOpening extends Model
{
    protected $guarded = [];
    protected function casts(): array { return ['closing_date'=>'date','is_active'=>'boolean']; }
    public function applications() { return $this->hasMany(JobApplication::class); }
}
