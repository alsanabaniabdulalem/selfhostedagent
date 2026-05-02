<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'equipment_id' => ['required', 'exists:equipments,id'],
            'user_id' => ['required', 'exists:users,id'],
            'assigned_at' => ['required', 'date'],
            'due_at' => ['nullable', 'date', 'after_or_equal:assigned_at'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
