<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use App\Enums\Status;
use Illuminate\Validation\Rules\Enum;

class CustomersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'dni' => 'required|string|max:45|unique:customers,dni',
            'id_reg' => 'required|numeric',
            'id_com' => 'required|numeric',
            'email' => 'required|email|unique:customers,email|max:120',
            'name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'address' => 'nullable|string|max:255',
            'date_reg' => 'required|date',
            'status' => ['required', new Enum(Status::class)]
        ];
    }

    public function messages(): array
    {
        return [
            'id_reg.required' => 'Region id is required',
            'id_com.required' => 'Commune id is required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 422));
    }
}
