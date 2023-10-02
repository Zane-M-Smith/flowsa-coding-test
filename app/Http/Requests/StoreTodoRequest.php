<?php

namespace App\Http\Requests;

use App\Enum\Priority;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreTodoRequest extends FormRequest
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
            'title'         => ['required', 'string', 'max:1024'],
            'description'   => ['required', 'string'],
            'priority'      => ['sometimes', new Enum(Priority::class)],
            'deadline'      => ['sometimes', 'nullable', 'after:now']
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
