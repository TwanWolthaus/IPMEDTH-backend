<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Skill;

class Exercise extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category'
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'exercises_skills');
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }

    public function trainings()
    {
        return $this->belongsToMany(Training::class);
    }
}
