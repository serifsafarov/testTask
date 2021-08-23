<?php

namespace App\Http\Requests;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Http\FormRequest;

class WinPrizeRequest extends FormRequest
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
     * @throws AuthenticationException
     */
    protected function failedAuthorization()
    {
        throw new AuthenticationException('Вы уже получали приз');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
