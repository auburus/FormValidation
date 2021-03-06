<?php

namespace Auburus\FormValidation\Tests;

use Auburus\FormValidation\Form;
use Respect\Validation\Validator as v;

class BasicForm extends Form
{
    /**
     * This property can't be automatically
     * populated using the fromRequest static
     * method, since it doesn't have any rule
     * associated.
     */
    public $unpopulated;

    protected function rules()
    {
        return [
            'name' => v::notEmpty()->alnum(),
            'password' => v::alnum()->length(8, null, true),
            'age' => v::numeric()->between(0, 150),
        ];
    }
}
