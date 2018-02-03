<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTopicRequest extends FormRequest
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
            'product_type.required' => '产品类型不能为空',
            'product_type.max' => '产品类型不能大于200个字符',
            'topic_type.required' => '话术类型不能为空',
            'topic_type.max' => '话术类型不能大于200个字符',
            'source.required' => '话术来源不能为空',
            'source.max' => '话术来源不能大于200个字符',
            'content.required' => '话术详情不能为空',
            'content.min' => '话术详情不能少于3个字符'
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
            'product_type'=>'required|max:200',
            'topic_type'=>'required|max:200',
            'source'=>'required|max:200',
            'content'=>'required|min:10'
        ];
    }
}
