<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiometricEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recorded_at',
        'weight_kg',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'heart_rate',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
