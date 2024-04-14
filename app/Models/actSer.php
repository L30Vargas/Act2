<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class actSer extends Model
{
    use HasFactory;
    protected $fillable = [
        'actor_id',
        'serie_id',
        'text',
        'campo',
        
       
    ];

}
