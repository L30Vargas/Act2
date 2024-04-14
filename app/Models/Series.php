<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'url',
        'platform_id',
        'director_id',
        'idiom_id',
        'text',
        'campo',
    ];
}
