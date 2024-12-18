<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

   

    public function scopeFilterBySkill($query, $skills)
    {
        $skillsArray = explode(',', $skills); // Split the comma-separated skills into an array
        
        // Use whereHas to filter exercises that have any of the skills in the list
        return $query->whereHas('skills', function ($q) use ($skillsArray) {
            $q->whereIn('name', $skillsArray); // Match exercises with any of the skills in the list
        });
    }
    



}
