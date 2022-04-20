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
        $user = User::where('id', Auth::id())->first();

        return [
            'name' => [
                'required',
                'max:200',
                //Rule::unique('projects')->ignore($user)
                ],
            'subject_id' => 'required',
            'description' => 'nullable|max:5000',
            'featured' => 'nullable|image'
        ];
    }
}
