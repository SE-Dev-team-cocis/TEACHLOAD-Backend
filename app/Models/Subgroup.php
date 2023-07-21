<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subgroup extends Model
{
    use HasFactory;

    /*A subgroup belongs to a course */
    public function course():BelongsTo{
        return $this->belongsTo(Course::class);
    }
    /*fillabe */

    protected $fillable = [
        'subgroup_name',
        'no_of_students',
        'course_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

}
