<?php

namespace App\Http\Requests\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * @property mixed name
 * @property mixed $image_id
 */
class ProjectRequest extends FormRequest
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
                //'unique:projects',  
                Rule::unique('projects')
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
