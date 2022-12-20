<?php

namespace Spatie\HelpSpace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HelpSpaceRequest extends FormRequest
{
    public function rules()
    {
        return [];
    }

    public function email(): string
    {
        return $this->json('from_contact.value') ?? '';
    }
}
