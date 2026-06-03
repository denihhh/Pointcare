<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctor_id' => ['required', 'exists:users,id,role,doctor'],
            'appointment_time' => ['required', 'date', 'after:now'],
            'reason' => ['required', 'string', 'max:1000'],
        ];
    }
}
