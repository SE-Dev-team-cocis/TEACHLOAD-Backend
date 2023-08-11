<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_name',
        'department_code',
        'college_id'
    ];
   /* Department belongs to a college */
   public function college():BelongsTo{
    return $this->belongsTo(College::class);
   }

   /* Department has many courses */
   public function courses():HasMany
   {
     return $this->hasMany(Course::class);
   }
}
