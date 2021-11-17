<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdOfferRequest extends FormRequest
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
        $route = $this->route()->getName();

        $rule = [
            'title' => 'required|string|max:50',
            'area_id' => 'required|exists:areas,id',
            'remaining_amount' => 'required|after:yesterday',
            'description' => 'required|string|max:2000',
            'status' => 'nullable|boolean',
        ];

        if ($route === 'ad_offer.update') {
            $rule['remaining_amount'] = 'required|date';
        }

        return $rule;
    }
}
