<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactSTypeRequest extends FormRequest
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

    public function messages()
    {
        return [
            'stype.required' => '联系小类不能为空',
            'stype.max' => '联系小类不能大于100个字符',
            'stype.max' => '详情不能大于200个字符',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'stype'=>'required|max:100',
            'detail'=>'max:200',
        ];
    }
}
