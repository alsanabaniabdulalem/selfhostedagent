<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Keep authorization simple for MVP; add role checks here later.
        return true;
    }

    public function rules(): array
    {
        return [
            'asset_tag' => ['required', 'string', 'max:100', 'unique:equipments,asset_tag'],
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:available,assigned,maintenance,retired'],
            'location' => ['nullable', 'string', 'max:255'],
        ];
    }
}
