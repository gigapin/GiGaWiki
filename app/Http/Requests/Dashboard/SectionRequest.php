<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed project_id
 * @property mixed id
 * @property mixed title
 * @property mixed slug
 */
class SectionRequest extends FormRequest
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
            'title' => 'required|max:200',
            'project_id' => 'required',
            'description' => 'nullable|max:5000'
        ];
    }
}
