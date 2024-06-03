<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class FilterTicketRequest extends FormRequest
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
            'operator_id' => 'nullable|int|exists:operators,id',
            'code' => 'nullable|numeric|digits_between:1,10|exists:tickets,code',
            'category_id' => 'nullable|int|exists:categories,id',
            'statuses' => 'nullable|array',
            'statuses.*' => 'nullable|string|in:closed,queued,in progress,assigned',
            'dateStart' => 'nullable|date',
            'dateEnd' => 'nullable|date|after_or_equal:dateStart',
        ];
    }
}
