<?php

namespace Auburus\FormValidation;

use Respect\Validation\Exceptions\ExceptionInterface;
use InvalidArgumentException;

class InvalidValidatorException extends InvalidArgumentException implements ExceptionInterface
{
}
