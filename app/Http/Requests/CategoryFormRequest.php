<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // You can implement authorization logic here if needed.
        return true;  // Return true for now to allow all users
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            // 'slug' => 'required|string|max:255',
            'description' => 'string|nullable',
            'serial_number' => 'required|unique:categories,serial_number,' . $this->category, // Allow update for existing category
            'parent_id' => 'nullable|exists:categories,id', // Ensure parent_id exists in the categories table if provided
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    /**
     * Customize the error messages if needed.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The category name is required.',
            'slug.required' => 'The slug name is required.',
            'description.required' => 'Please provide a description for the category.',
            'serial_number.required' => 'The serial number is required.',
            'serial_number.unique' => 'This serial number is already taken.',
            'image.image' => 'Please upload a valid image file.',
            'parent_id.exists' => 'The selected parent category is invalid.', // Error message for invalid parent_id
        ];
    }
}
