<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'phone', 'password', 'date_of_birth', 'gender', 'emergency_contact_name', 'emergency_contact_phone', 'known_allergies', 'chronic_conditions'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
            'date_of_birth' => 'date',
        ];
    }

    public function doctor(){
        return $this->hasOne(Doctor::class);
    }
    public function isDoctor(){
        return $this->role === 'doctor';
    }

    public function scopeDoctors($query)
    {
        return $query->where('role', 'doctor');
    }

    public function appointments(){
        return $this->hasMany(Appointment::class, 'patient_id');
    }
}

