<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' =>     ['required', 'string', 'max:255',],
            'email' =>    ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
      $response = new JsonResponse(
              [
                  'message' => 'Validation has failed', 
                  'errors' => $validator->errors()
              ], 422);

      throw new ValidationException($validator, $response);
    }
}
