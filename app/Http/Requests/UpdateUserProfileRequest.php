<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserProfileRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user= Auth::user();
        return [
            'name' => 'required',
            'email' => ['required', Rule::unique('users', 'email')->ignore($user->id)],
            
        ];
    }
}
