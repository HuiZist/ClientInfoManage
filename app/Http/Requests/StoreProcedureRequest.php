<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProcedureRequest extends FormRequest
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
            'btype.required' => '业务大类不能为空',
            'btype.min' => '业务大类不能少于3个字符',
            'btype.max' => '业务大类不能大于200个字符',
            'stype.required' => '业务小类不能为空',
            'stype.min' => '业务小类不能少于3个字符',
            'stype.max' => '业务小类不能大于200个字符',
            'content.required' => '详细描述不能为空',
            'content.min' => '详细描述不能少于3个字符'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * +7
     */
    public function rules()
    {
        return [
            'btype'=>'required|min:3|max:200',
            'stype'=>'required|min:3|max:200',
            'content'=>'required|min:10'
        ];
    }
}
