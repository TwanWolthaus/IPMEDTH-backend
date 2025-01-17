<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Enums\Role;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // 'permission_id',
        'password',
        'role',
        'disabled',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'date_birth',
        'gender',
        'diploma',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class,
        ];
    }

    public function trainings()
    {
        return $this->belongsToMany(Training::class, 'trainings_trainers');
    }

    public function permission()
    {
        return $this->hasOne(Permission::class);
    }

    public function isAdmin()
    {
        return $this->role === Role::Admin;
    }

    public function isTrainer()
    {
        return $this->role === Role::Trainer;
    }

    public function isGuest()
    {
        return $this->role === Role::Guest;
    }
}
