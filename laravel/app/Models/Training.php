<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    public function location()
    {
        return $this->hasOne(Location::class);
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function exercises()
    {
        return $this->belongsToMany(Skill::class, 'trainings_exercises');
    }
}
