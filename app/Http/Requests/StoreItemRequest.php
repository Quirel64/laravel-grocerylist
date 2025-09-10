<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreItemRequest extends FormRequest
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
   public function rules()
{
    return [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category_id' => 'required|array',
        'category_id.*' => 'exists:categories,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        'premium' => 'nullable|boolean',

    ];
}
   
   
    
}
