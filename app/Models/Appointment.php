<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $casts = ['appointment_time' => 'datetime'];

    protected $fillable = [
        'patient_id', 'doctor_id', 'appointment_time', 'reason',
        'status', 'symptoms', 'diagnosis', 'prescription'
    ];

    public function patient() { return $this->belongsTo(User::class, 'patient_id'); }
    public function doctor() { return $this->belongsTo(User::class, 'doctor_id'); }
}
