<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactBTypeRequest extends FormRequest
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
            'btype.required' => '联系大类不能为空',
            'btype.max' => '联系大类不能大于100个字符',
            'detail.max' => '详情不能大于200个字符',
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
            'btype'=>'required|max:100',
            'detail'=>'max:200',
        ];
    }
}
