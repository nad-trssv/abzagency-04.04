<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
             'name' => 'required|string|min:2|max:60',
             'email' => 'required|email:rfc,dns|unique:users,email',
             'phone' => 'required|unique:users,phone|regex:/^\+380\d+$/',
             'position_id' => 'required|exists:positions,id',
             'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120|dimensions:min_width=70,min_height=70',
         ];
     }
 
     public function messages()
     {
         return [
             'name.required' => 'The name field is required.',
             'email.required' => 'User email is required.',
             'email.email' => 'User email must be a valid email according to RFC2822.',
             'email.unique' => 'This email is already taken.',
             'phone.regex' => 'The phone number must start with +380.',
         ];
     }
}
