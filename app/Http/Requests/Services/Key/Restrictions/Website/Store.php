<?php

namespace App\Http\Requests\Services\Key\Restrictions\Website;

use App\Models\Services\Key;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class Store extends FormRequest
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
        return [
            'key_id' => ['required', 'numeric', function ($attribute, $value, $fail) {
                if (Key::whereKeyID($value)->whereKeyOwnerID(auth()->user()->id)->doesntExist()) {
                    $fail('The selected key id is invalid.');
                }
            }],
            'website' => ['required', 'url', 'max:255'],
            'redirect_link' => ['nullable', 'url', 'max:255'],
        ];
    }
}
