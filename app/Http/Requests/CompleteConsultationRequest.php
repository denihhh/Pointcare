<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompleteConsultationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'symptoms' => 'required|string|min:5',
            'diagnosis' => 'required|string|min:5',
            'prescription' => 'required|string|min:3',
        ];
    }
}
