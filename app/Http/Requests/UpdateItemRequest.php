<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
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
        'name' => 'required|max:255',
        'description' => 'nullable',
         'category_id' => 'required|array',
        'category_id.*' => 'exists:categories,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        
        ];

    }
}
