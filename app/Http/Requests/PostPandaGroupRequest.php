<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostPandaGroupRequest
 * @package App\Http\Requests
 */
class PostPandaGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];

        if (isset($this->pandaGroup)) {
            $rules['label'] = 'required|unique:panda_groups,label,' . $this->pandaGroup->id . ',id';
            $rules['name'] = 'required|unique:panda_groups,name,' . $this->pandaGroup->id . ',id';
        } elsE {
            $rules['name'] = 'required|unique:panda_groups,name';
        }

        return $rules;
    }

    /**
     * Prepare for validation.
     */
    public function prepareForValidation()
    {
        $input = array_map('trim', $this->all());

        if (isset($this->pandaGroup)) {
            $input['label'] = str_slug($this->name);
        }
        $this->replace($input);
    }
}
