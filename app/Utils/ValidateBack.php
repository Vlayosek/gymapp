<?php

namespace App\Utils;

use Illuminate\Support\Facades\Validator;

trait ValidateBack
{
    public function validateBack($request, $rules, $messages = [])
    {
        $response = true;
        $validator = Validator::make($request, $rules, $messages);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $response = false;
        }
        return [
            'response' => $response,
            'messages' => $messages,
        ];
    }

}
