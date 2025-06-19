<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator; // Ensure this is imported

class SiteSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // For PATCH requests where only a subset of fields might be passed:
        // Use 'sometimes|required|...' for fields that must be present IF they are sent.
        // Use 'sometimes|nullable|...' for fields that can be sent as null/empty IF they are sent.
        // Use 'sometimes|...' for file uploads where absence means "no change".

        return [
            'site_name'           => 'sometimes|required|string|min:4',
            'site_short_name'     => 'sometimes|required|string|min:2',
            'site_logo'           => 'sometimes|nullable|image|max:2048', // Assuming optional file upload, max 2MB
            'site_favicon'        => 'sometimes|nullable|image|max:2048', // Assuming optional file upload, max 2MB
            'env'                 => 'sometimes|required|string',
            'debug'               => 'sometimes|required|boolean',
            'debugbar'            => 'sometimes|required|boolean',
            'audit'               => 'sometimes|required|boolean',
            'timezone'            => 'sometimes|required|string', // Timezone values are typically strings
            'date_format'         => 'sometimes|required|string',
            'time_format'         => 'sometimes|required|string',
            'sms_api_url'         => 'sometimes|required|url',
            'sms_api_key'         => 'sometimes|required|string', // Assuming key is a string
            'sms_api_secret'      => 'sometimes|nullable|string', // Optional, but if present must be a string (can be null/empty)
            'sms_api_status_code' => 'sometimes|required|string', // Assuming status code is a string (e.g., '200')
            'sms_api_sender_id'   => 'sometimes|required|string', // Assuming sender ID is a string


            // These fields are from contact-information-setting.blade.php but are NOT office_infos
            'email'           => 'sometimes|required|email',
            'phone'           => 'sometimes|required|numeric',
            'whatsapp'        => 'sometimes|required|numeric',
            'address'         => 'sometimes|required|string',
            'sort_description' => 'sometimes|required|string',
            'description'     => 'sometimes|required|string',
            // Office Infos (entire array might not be passed in the request)
            'office_infos' => 'sometimes|array', // The array itself is optional.

            // Nested Office Infos fields (these are required IF the 'office_infos' array is submitted)
            // Do NOT use 'sometimes' here. The 'sometimes' on the parent 'office_infos' handles
            // the conditional validation of the entire array block.
            'office_infos.*.country'     => 'nullable|string',
            'office_infos.*.location'    => 'nullable|string',
            'office_infos.*.whatsapp'    => 'nullable|numeric',
            'office_infos.*.phone'       => 'nullable|numeric',
            'office_infos.*.email'       => 'nullable|email',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * These are base attributes. The specific array item attributes will be set
     * dynamically as custom messages in withValidator.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            // General Site Settings
            'site_name'           => 'Site Name',
            'site_short_name'     => 'Site Short Name',
            'site_logo'           => 'Site Logo',
            'site_favicon'        => 'Site Favicon',
            'env'                 => 'Environment',
            'debug'               => 'Debug Mode',
            'debugbar'            => 'Debugbar Enabled',
            'audit'               => 'Audit Logging',

            // Contact Information Settings (from contact-information-setting.blade.php)
            'email'               => 'Email',
            'phone'               => 'Phone',
            'whatsapp'            => 'Whatsapp Number',
            'address'             => 'Main Location Address',
            'sort_description'    => 'Short Description',
            'description'         => 'Description',

            // Time Settings
            'timezone'            => 'Timezone',
            'date_format'         => 'Date Format',
            'time_format'         => 'Time Format',

            // SMS API Settings
            'sms_api_url'         => 'SMS API URL',
            'sms_api_key'         => 'SMS API Key',
            'sms_api_secret'      => 'SMS API Secret',
            'sms_api_status_code' => 'SMS API Status Code',
            'sms_api_sender_id'   => 'SMS API Sender ID',

            // Generic attributes for office infos. These are overridden by withValidator messages.
            'office_infos.*.country'  => 'Country',
            'office_infos.*.email'    => 'Email',
            'office_infos.*.phone'    => 'Phone',
            'office_infos.*.whatsapp' => 'Whatsapp Number',
            'office_infos.*.location' => 'Location',
        ];
    }

    /**
     * Configure the validator instance to dynamically set custom messages for array fields.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $officeInfos = $this->input('office_infos');

            // Only proceed if 'office_infos' array was actually submitted AND is an array
            if ($this->has('office_infos') && is_array($officeInfos)) {
                $customMessages = []; // Initialize an array to hold our custom messages

                foreach ($officeInfos as $key => $officeInfo) {
                    $officeNumber = $key + 1; // For user-friendly numbering (e.g., Office 1, Office 2)

                    // Define custom messages for each rule that applies to the field
                    // Format: "field.index.rule" => "Your custom message"
                    $customMessages["office_infos.{$key}.country.required"] = "The Country for Office " . $officeNumber . " is required.";
                    $customMessages["office_infos.{$key}.country.string"]   = "The Country for Office " . $officeNumber . " must be a string.";

                    $customMessages["office_infos.{$key}.email.required"] = "The Email for Office " . $officeNumber . " is required.";
                    $customMessages["office_infos.{$key}.email.email"]    = "The Email for Office " . $officeNumber . " must be a valid email address.";

                    $customMessages["office_infos.{$key}.phone.required"] = "The Phone for Office " . $officeNumber . " is required.";
                    $customMessages["office_infos.{$key}.phone.numeric"]  = "The Phone for Office " . $officeNumber . " must be a number.";

                    $customMessages["office_infos.{$key}.whatsapp.required"] = "The Whatsapp Number for Office " . $officeNumber . " is required.";
                    $customMessages["office_infos.{$key}.whatsapp.numeric"]  = "The Whatsapp Number for Office " . $officeNumber . " must be a number.";

                    $customMessages["office_infos.{$key}.location.required"] = "The Location for Office " . $officeNumber . " is required.";
                    $customMessages["office_infos.{$key}.location.string"]   = "The Location for Office " . $officeNumber . " must be a string.";
                }

                // Merge the dynamically generated messages with any existing custom messages on the validator
                // customMessages is a public property on the Validator instance in Laravel 9, 10, 11, 12
                $validator->customMessages = array_merge($validator->customMessages, $customMessages);
            }
        });
    }
}
