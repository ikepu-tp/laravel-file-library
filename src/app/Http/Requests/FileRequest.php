<?php

namespace ikepu_tp\FileLibrary\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        if ($this->routeIs("*.store")) return [
            "files" => ["array"],
            "files.*" => ["file", "required"],
            "names" => ["array"],
            "names.*" => ["string", "required", "max:250"],
        ];
        if ($this->routeIs("*.update")) return [
            "name" => ["string", "required", "max:250"],
        ];
        return [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [];
    }
}