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
        'category_id' => 'nullable|array',
        'category_id.*' => 'integer|exists:categories,id',
        //'item_id' => 'nullable|integer', tried adding these to see if they threw me an error but just let the request through without doing anything
       // 'item_id.*' => 'integer|exists:items,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        'premium' => 'nullable|boolean',

    ];
}
   
   
    
}
