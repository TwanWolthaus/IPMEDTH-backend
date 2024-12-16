<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class);
    }

    public function tools()
    {
        return $this->hasMany(Tool::class);
    }
}
