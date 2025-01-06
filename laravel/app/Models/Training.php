<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = [
        'start_time',
        'end_time',
        'name'
    ];


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
        return $this->belongsToMany(Exercise::class, 'trainings_exercises');
    }
}
