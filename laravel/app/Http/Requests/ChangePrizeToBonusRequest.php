<?php

namespace App\Http\Requests;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Http\FormRequest;

class ChangePrizeToBonusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->prizes()->where('id', $this->id)->exists();
    }

    /**
     * @throws AuthenticationException
     */
    protected function failedAuthorization()
    {
        throw new AuthenticationException('Указанный приз не принадлежит вам');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['integer', 'min:1', 'required', 'exists:App\Models\Prize,id']
        ];
    }

    public function messages()
    {
        return [
            'id.integer' => 'Неверный ID приза',
            'id.min' => 'Неверный ID приза',
            'id.required' => 'Неверный ID приза',
            'id.exists' => 'Неверный ID приза',
        ];
    }
}
