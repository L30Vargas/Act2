<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Libs\ResultResponse;
use Illuminate\Database\Eloquent\Model;

class Actors extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lastname',
        'DoB',
        'nacionalidad',
        'text',
        'campo',
    ];


    }

    

