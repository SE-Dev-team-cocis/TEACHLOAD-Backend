<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SemesterList extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'course_id',
        'semester',
    ];

    public function courses():HasOne
    {
        return $this->hasOne(Course::class);
    }

    /*Semester list belongs to a staff */
    public function staff():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course():BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    //   /*Course has many subgroups */
    //   public function subgroups():HasMany
    //   {
    //       return $this->hasMany(Subgroup::class);
    //   }

}
