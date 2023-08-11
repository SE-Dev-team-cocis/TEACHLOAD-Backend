<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'semester_name',
        'semester_code'
    ];

    /* Semester has many courses */
    public function courses():HasMany
    {
        return this->hasMany(Course::class);
    }
}
