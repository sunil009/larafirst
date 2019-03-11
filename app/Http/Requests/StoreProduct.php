<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Profile;

class StoreProduct extends FormRequest {

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

      $thumbnail = "";
      if($this->has('thumbnail')){

         $thumbnail = 'required | mimes:jpeg,jpg,bmp,png | max:2048';
      }

      return [
         'title'       => 'required',
         'slug'        => 'required |unique:products'.$unique,
         'description' => 'required',
         'thumbnail'   => $thumbnail,
         'price'       => 'required | numeric',
         'status'      => 'required | numeric',
         'category_id' => 'required',
      ];

   }
}
