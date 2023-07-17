<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeachingLoad extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'courses',
        'CUs',
        'assignee_id'
    ];
}
