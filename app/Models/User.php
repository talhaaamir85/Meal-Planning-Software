<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function goals()
    {
        return $this->hasMany(UserGoal::class);
    }

    public function meals()
    {
        return $this->hasMany(UserMeal::class);
    }

    public function biometrics()
    {
        return $this->hasMany(BiometricEntry::class);
    }
    public function mealPlans()
{
    return $this->hasMany(MealPlan::class);
}

}
