<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDog extends FormRequest
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
            'name' => 'required|unique:dogs,name,' . $this->route('id') ?? '0',
            'sire' => 'nullable|different:name,dam',
            'dam' => 'nullable|different:name,sire',
            'sex' => 'required|in:male,female',
            'dob' => 'nullable|date_format:Y-m-d',
            'pretitle' => 'nullable|max:32',
            'posttitle' => 'nullable|max:32',
            'reg' => 'nullable|max:64',
            'color' => 'nullable|max:64',
            'markings' => 'nullable|max:64',



            'breeder' => 'nullable|max:32',
            'owner' => 'nullable|max:32',
            'website' => ['nullable', 'url'],
        ];
    }
}
