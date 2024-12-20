<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
