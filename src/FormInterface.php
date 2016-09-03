<?php

namespace Auburus\FormValidation;

use Psr\Http\Message\RequestInterface;

interface FormInterface
{
    public function getAttributes();
    public function getErrors();
    public function isValid();
    public static function fromRequest(RequestInterface $request);
}
