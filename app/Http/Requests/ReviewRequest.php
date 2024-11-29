<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'description' => 'nullable|string|max:1000',
            'rating' => 'nullable|numeric|min:0|max:5',
            'member_id' => 'required|numeric|exists:members,id',
            'book_id' => 'required|numeric|exists:books,id'
        ];
    }
}
