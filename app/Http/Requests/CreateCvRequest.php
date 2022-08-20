<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class CreateCvRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'application_date' => 'bail|required|date',
            'date_interview' => 'bail|required|date',
            'name_surname' => 'bail|required|string',
            'birth_date' => 'bail|required|date',
            'proffession' => 'bail|required|string',
            'phone_numbers' => 'bail|required|numeric',
            'social_sites' => 'bail|required',
        ];
    }
    public function messages() {
        return [
            'application_date.required' => 'Դիմելու ամսաթիվ դաշտը դատարկ է',
            'date_interview.required' => 'Հարցազրույցի ամսաթիվ դաշտը դատարկ է',
            'name_surname.required' => 'Անուն Ազգանունի դաշտը դատարկ է',
            'name_surname.string' => 'Անուն Ազգանուն դաշտը չպետք է պարունակի թվեր',
            'birth_date.required' => 'Ծննդյան Ամսաթիվ դաշտը դատարկ է',
            'proffession.required' => 'Մասնագիտություն դաշտը դատարկ է',
            'proffession.string' => 'Մասնագիտություն դաշտը չպետք է պարունակի թվեր',
            'phone_numbers.required' => 'Հեռախոսահամար դաշտը դատարկ է',
            'phone_numbers.numeric' => 'Հեռախոսահամար դաշտը չպետք է պարունակի տառեր',
            'social_sites.required' => 'Սոցիալական կայքերի հղումները դաշտը դատարկ է',
        ];
    }
}
