<?php

namespace Auburus\FormValidation\Tests;

use Auburus\FormValidation\Form;
use Respect\Validation\Validator as v;

class BasicForm extends Form
{
    protected function rules()
    {
        return [
            'name' => v::alnum(),
            'password' => v::alnum(),
            'age' => v::numeric(),
        ];
    }
}
