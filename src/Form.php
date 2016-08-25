<?php

namespace Auburus\FormValidation;

use Auburus\FormValidation\FormInterface;
use Respect\Validation\Validator;
use Psr\Http\Message\RequestInterface;

abstract class Form implements FormInterface
{
    /**
     * array Form attributes
     */
    protected $attributes;

    /**
     * array Errors after validation
     */
    protected $errors;

    public function __construct()
    {
        $attributes = $this->rules();
        foreach ($attributes as $name => $validator) {
            $this->attributes[$name] = null;
        }
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }

        // TODO Change to a concrete exception
        throw new \Exception("Property {$name} not found");
    }

    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->attributes)) {
            $this->attributes[$name] = $value;
        } else {
            // TODO Change to a concrete exception
            throw new \Exception("Property {$name} not found");
        }
    }

    public static function fromRequest(RequestInterface $request, $httpMethod = null)
    {
        return null;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function isValid()
    {
        $rules = $this->rules;
        foreach ($this->attributes as $attribute => $value) {
            try {
                $validator = $rules[$attribute];
                if (!($validator instanceof Validator)) {
                    // TODO Change to concrete exception
                    throw new Exception('The value in the rules array must be a valid validator object');
                }
                $rules[$attribute]->assert($value);
            } catch (NestedValidationException $e) {
                $this->errors[$attribute] = $e->getMessages();
            }
        }

        return empty($this->errors);
    }

    abstract protected function rules();
}
