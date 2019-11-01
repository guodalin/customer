<?php

namespace App\Http\Requests\Backend\Auth\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateUserRequest.
 */
class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->route('user');

        return [
            'username'   => ['required', 'max:191', Rule::unique('users')->ignore($user)],
            'mobile'     => ['nullable', Rule::unique('users')->ignore($user)],
            'email'      => ['required', 'email', 'max:191', Rule::unique('users')->ignore($user)],
            'first_name' => ['nullable', 'max:191'],
            'last_name'  => ['nullable', 'max:191'],
            'roles'      => ['required', 'array'],
        ];
    }
}
