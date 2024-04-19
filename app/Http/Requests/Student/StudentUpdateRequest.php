<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
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
        $studentId = $this->route('student')->id; // Dapatkan ID siswa yang sedang diperbarui

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students,email,' . $studentId,
            'nisn' => 'required|string|max:20|unique:students,nisn,' . $studentId,
            'gender' => 'required|in:male,female',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Aturan validasi untuk gambar
            'birthdate' => 'required|date',
            'class_room_id' => 'required|exists:class_rooms,id'
        ];
    }
}
