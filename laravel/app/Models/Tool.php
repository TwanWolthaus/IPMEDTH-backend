<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    public function requirements()
    {
        return $this->belongsToMany(Requirement::class);
    }
}
