<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
        $id = $this->route('id');

        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'isbn' => 'required|string|size:13|unique:books,isbn' . ($id ? ",$id" : ''),
            'stock' => 'required|integer|min:0',
            'number_of_pages' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|max:2048',
            'publication_date' => 'required|date|before_or_equal:today',
            'category_id' => 'required|integer|exists:categories,id'
        ];
    }
}
