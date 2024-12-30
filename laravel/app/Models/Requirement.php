<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    protected $fillable = [
        'exercise_id',
        'description',
        'amount',
        'is_optional'
    ];


    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
