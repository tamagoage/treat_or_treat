<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTreatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'location_id' => 'required|integer',
            'shelf_life_id' => 'required|integer',
            // 'image' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            // 今日以前
            'made_date' => 'required|date|before_or_equal:today',
            // 今日以降
            'pickup_deadline' => 'required|date|after_or_equal:today',
        ];
    }
}
