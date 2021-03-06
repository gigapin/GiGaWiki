<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
      return [
        'user_id' => ['exists:App\Models\User,id'],
        'name' => [
            'max:200',
            'min:3', 
            Rule::unique('subjects')
                ->ignore($this->name, 'name')
            ],
        'slug' => ['string'],
        'description' => ['nullable', 'max:5000'],
        'featured' => [
            'nullable', 
            'image', 
            Rule::dimensions()
                ->maxWidth(1921)
                ->minWidth(99)
                ->maxHeight(1281)
                ->minHeight(99)
            ]
        ];
    }
}
