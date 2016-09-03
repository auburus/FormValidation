<?php

namespace Auburus\FormValidation\Tests;

use Auburus\FormValidation\Form;
use Respect\Validation\Validator as v;

class InvalidForm extends Form
{

    protected function rules()
    {
        return [
            'name' => v::notEmpty()->alnum(),
            'password' => 'Not a valid validator object',
            'age' => v::numeric()->between(0, 150),
        ];
    }
}
