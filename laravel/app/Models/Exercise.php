<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Skill;

class Exercise extends Model
{
    protected $fillable = [
        'name',
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

   

   public function scopeFilterBySkill(Builder $query, ...$skills)
{
    // Assuming skills are passed as an array or as individual arguments
    return $query->whereHas('skills', function ($q) use ($skills) {
        $q->whereIn('name', $skills);
    });
}

    



}
