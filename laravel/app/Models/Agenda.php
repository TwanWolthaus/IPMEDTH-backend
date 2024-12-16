<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    public function trainings()
	{
    	return $this->hasMany(Training::class);
	}

    public function team()
	{
    	return $this->belongsTo(Team::class);
	}
}
