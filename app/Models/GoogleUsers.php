<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class GoogleUsers extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'provider_name',
        'provider_id'
    ];

}
