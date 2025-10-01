<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // خليها true عشان تسمح بالطلب
    }

public function rules(): array
{
    return [
        'user_id'       => 'required|exists:users,id', // لازم يبقى id موجود في جدول users
        'name'          => 'required|string|max:255',
        'email'         => 'required|email|unique:profiles,email',
        'phone'         => 'nullable|string|max:20',
        'date_of_birth' => 'nullable|date',
        'bio'           => 'nullable|string',
    ];
}

}
