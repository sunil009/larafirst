<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserProfile extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {

        if($this->method() == 'PUT') {
            $unique = ",slug,$this->slug,slug";
        } else {
            $unique = '';
        }

        return [
            'name'     => 'required',
            'slug'     => 'required | unique:products'.$unique,
            'email'    => 'required | email| unique:users'.$unique,
            'password' => 'required',
            'comfirm_password' => 'required | same:password',
            'status'   => 'required',
        ];
    }
}
