<?php

namespace App\Http\Requests\Services\Key;

use App\Models\Services\Key;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class Update extends FormRequest
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
            'id' => ['required', 'numeric', function ($attribute, $value, $fail) {
                if (Key::whereKeyID($value)->whereKeyOwnerID(auth()->user()->id)->doesntExist()) {
                    $fail('The selected id is invalid.');
                }
            }],
            'name' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                $existing_key = Key::whereKeyName($value)->whereKeyOwnerID(auth()->user()->id);
                if ($existing_key->exists() && $existing_key->first()->id != $this->id) {
                    $fail('The '.$attribute.' has already been taken');
                }
            }],
            'generate_key' => ['nullable', 'boolean'],
        ];
    }
}
