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
            'name' => v::alnum(),
            'password' => v::alnum(),
            'age' => v::numeric(),
        ];
    }
}
