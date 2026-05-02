<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $equipmentId = $this->route('equipment')?->id ?? $this->route('equipment');

        return [
            'asset_tag' => [
                'required',
                'string',
                'max:100',
                Rule::unique('equipments', 'asset_tag')->ignore($equipmentId),
            ],
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:available,assigned,maintenance,retired'],
            'location' => ['nullable', 'string', 'max:255'],
        ];
    }
}
