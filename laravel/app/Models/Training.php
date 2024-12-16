<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    public function exercise()
    {
        return $this->hasOne(Exercise::class);
    }

    public function location()
    {
        return $this->hasOne(Location::class);
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'trainings_trainers');
    }
}
