<?php

namespace App\Http\Requests\Services\Key\Restrictions\Website;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class Listing extends FormRequest
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
            'search' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'redirect_link' => ['nullable', 'url', 'max:255'],
            /** defualt filter for listing */
            'limit' => ['nullable', 'numeric', 'max:255'],
            'offset' => ['nullable', 'numeric', 'max:255'],
            'page' => ['nullable', 'numeric', 'max:255'],
            'orderBy.*.field' => ['nullable', 'string', 'max:255'],
            'orderBy.*.type' => ['nullable', 'string', 'max:255', 'in:asc,ASC,dsc,DSC'],
        ];
    }
}
