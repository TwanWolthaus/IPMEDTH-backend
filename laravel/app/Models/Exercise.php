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
        return $this->belongsToMany(Training::class, 'training_exercise');
    }



   public function scopeFilterBySkill(Builder $query, ...$skills)
    {
        // Assuming skills are passed as an array or as individual arguments
        return $query->whereHas('skills', function ($q) use ($skills) {
            $q->whereIn('name', $skills);
        });
    }

    public function scopeFilterByCategory(Builder $query, ...$categories)
    {
        // Filter exercises based on the provided categories
        return $query->whereHas('skills.category', function ($q) use ($categories) {
            $q->whereIn('name', $categories); // Match exercises with any of the provided category names
        });
    }

    public function scopeDurationBetween(Builder $query, $duration): Builder
    {
        // Split the comma-separated range into two values
        $duration = explode(':', $duration);

        // Apply the range filter
        return $query->whereBetween('duration', $duration);
    }


    public function scopeWaterExercise(Builder $query, $value = null): Builder
    {
        if (is_null($value)) {
            return $query; // Return all results if no filter is specified
        }

        $values = explode(',', $value);

        $booleanValues = array_map(function ($val) {
            return filter_var($val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        }, $values);

        return $query->whereIn('water_exercise', $booleanValues);
    }

}
