<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SemesterList extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'course_id',
        'semester',
    ];

    public function courses():BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /*Semester list belongs to a staff */
    public function staff():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
