<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hat extends Model
{
    use HasFactory;
    protected $fillable = [
        'hat_name',
        'hat_desc',
        'hat_link',
        'hat_image'
    ];
}
