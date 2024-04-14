<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idioms extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'isocode',
        'text',
        'campo',
       
    ];
}
