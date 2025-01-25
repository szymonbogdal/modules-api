<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules\CssDimension;
use App\Rules\CssColor;

class ModuleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'width' => ['required', new CssDimension()],
            'height' => ['required', new CssDimension()],
            'color' => ['required', new CssColor()],
            'link' => ['required', 'url'],
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'width' => is_numeric($this->input('width')) ? $this->input('width') . 'px' : $this->input('width'),
            'height' => is_numeric($this->input('height')) ? $this->input('height') . 'px' : $this->input('height'),
        ]);
    }

    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Validation failed.',
            'errors' => $validator->errors()
        ], 422));
    }
}
