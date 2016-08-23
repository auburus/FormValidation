<?php

namespace Auburus\FormValidation;

use Auburus\FormValidation\FormInterface;
use Psr\Http\Message\RequestInterface;

class Form implements FormInterface
{
    public function __construct()
    {

    }

    public static function fromRequest(RequestInterface $request, $httpMethod = null)
    {
        return null;
    }

    public function getAttributes()
    {
        return [];
    }

    public function getErrors()
    {
        return [];
    }

    public function isValid()
    {
        return false;
    }
}
