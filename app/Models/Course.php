<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Course extends Model
{
    use HasFactory;


    /*Course has many subgroups */
    public function subgroups():HasMany
    {
        return $this->hasMany(Subgroup::class);
    }

    protected $fillable = [
        'course_name',
        'course_code',
        'course_cus',
        'semester_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    /*Course has many semesterlist */

    public function semesterlists():HasMany
    {
        return $this->hasMany(SemesterList::class);
    }

    /*Course belongs to a department */

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }


}
