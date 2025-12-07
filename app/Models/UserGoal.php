<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nutrient',
        'target_value',
        'unit',
        'direction',
        'period',
        'active',
        'weight',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
