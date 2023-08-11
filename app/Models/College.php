<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class College extends Model
{
    use HasFactory;

    protected $fillable = [
        'college_name',
        'college_code',
    ];

     /*College has many departments */
     public function departments():HasMany
     {
         return $this->hasMany(Department::class);
     }

}
