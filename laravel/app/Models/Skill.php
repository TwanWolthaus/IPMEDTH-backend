<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'exercises_skills');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
