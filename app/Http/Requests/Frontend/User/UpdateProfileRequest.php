<?php

namespace App\Http\Requests\Frontend\User;

use App\Helpers\Auth\SocialiteHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateProfileRequest.
 */
class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'      => ['nullable', 'max:191'],
            'last_name'       => ['nullable', 'max:191'],
            'email'           => ['sometimes', 'required', 'email', 'max:191'],
            'avatar_type'     => ['required', 'max:191', Rule::in(array_merge(['gravatar', 'storage'], (array)config('services.allowed_socialites')))],
            'avatar_location' => ['sometimes', 'image', 'max:'.floor(config('medialibrary.max_file_size') / 1024)],
        ];
    }
}
