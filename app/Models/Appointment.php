<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
* @method static \Illuminate\Database\Eloquent\Builder where($column, $operator = null, $value = null, $boolean = 'and')
* @method static \Illuminate\Database\Eloquent\Builder create($attributes)
*/

class Appointment extends Model
{
    use HasFactory;
    protected $casts = ['appointment_time' => 'datetime'];

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_time',
        'reason',
        'status',
        'symptoms',
        'diagnosis',
        'prescription'
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
