<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCampaignRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string',
            'goal_amount' => 'required|numeric|min:0',
            'funds_raised' => 'sometimes|numeric|min:0',
            'status' => 'required|in:active,paused',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The campaign title is required.',
            'title.max' => 'The campaign title cannot exceed 255 characters.',
            'description.required' => 'The campaign description is required.',
            'type.required' => 'The campaign type is required.',
            'goal_amount.required' => 'The goal amount is required.',
            'goal_amount.numeric' => 'The goal amount must be a number.',
            'goal_amount.min' => 'The goal amount must be greater than or equal to 0.',
            'funds_raised.numeric' => 'The funds raised must be a number.',
            'funds_raised.min' => 'The funds raised must be greater than or equal to 0.',
            'status.required' => 'The campaign status is required.',
            'status.in' => 'The selected status is invalid.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image may not be greater than 2MB.',
            'start_date.required' => 'The start date is required.',
            'start_date.date' => 'The start date must be a valid date.',
            'end_date.required' => 'The end date is required.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after' => 'The end date must be after the start date.',
        ];
    }
} 