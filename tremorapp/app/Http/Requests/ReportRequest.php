<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Performs validation of the incoming request
 *
 * @access public
 * @package App\Http\Request
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */
class ReportRequest extends FormRequest
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
            'pin' => 'required',
        ];
    }

    /**
     * Validation message for respective field
     *
     * @param: void
     * @param: array
     */
    public function messages()
    {
        return [
            'pin.required' => 'Please enter your pin number',
        ];
    }
}
