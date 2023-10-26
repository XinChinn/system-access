<?php

namespace App\Http\Requests\Services\Key;

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
            'name' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                if (Key::whereKeyName($value)->whereKeyOwnerID(auth()->user()->id)->exists()) {
                    $fail('The '.$attribute.' has already been taken');
                }
            }],
        ];
    }
}
