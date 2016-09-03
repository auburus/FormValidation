<?php

namespace Auburus\FormValidation;

use Auburus\FormValidation\FormInterface;
use Respect\Validation\Validator;
use Psr\Http\Message\RequestInterface;
use Illuminate\Http\Request;
use Respect\Validation\Exceptions\NestedValidationException;

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

    /**
     * Read the rules function and populates a protected
     * attributes array, and creates all the public
     * properties with the null value by default.
     *
     * It's by property instead of using magic methods,
     * because of a benchmark I read long ago, about access
     * being like 10 times faster.
     * It's not that important, but since the functionality
     * is the same, why not?
     */
    public function __construct()
    {
        $attributes = $this->rules();
        foreach ($attributes as $name => $validator) {
            $this->$name = null;
            $this->attributes[] = $name;
        }
    }

    public static function fromRequest(RequestInterface $request)
    {
        $form = new static();

        $query = $request->getUri()->getQuery();
        $queryParts = explode('&', $query);

        $formAttributes = $form->getAttributes();

        foreach($queryParts as $pair) {
            list($queryParam, $queryValue) = explode('=', $pair);

            if (array_key_exists($queryParam, $formAttributes)) {
                $form->$queryParam = $queryValue;
            }
        }

        return $form;
    }

    public function getAttributes()
    {
        $attributes = [];
        foreach ($this->attributes as $attrName) {
            $attributes[$attrName] = $this->$attrName;
        }

        return $attributes;
    }

    /**
     * Returns the errors generated after the validation.
     * If there were error, are in the form of:
     * [
     *  attributeName1 => [
     *      'error message 1',
     *      'error message 2',
     *      ...
     *  ],
     *  attributeName2 => [
     *      ...
     *  ],
     *  ...
     * ]
     *
     * Right now, the messages are the same messages that Respect\Validation
     * throws.
     * If an attribute doesn't have errors, it won't be in the array.
     * TODO Check i18n or changin messages.
     * If no error is generated, this method returns an empty array.
     *
     * return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Validates the form
     *
     * return bool True if valid, false otherwise.
     */
    public function isValid()
    {
        $rules = $this->rules();

        // Reset errors for each validation
        $this->errors = [];

        foreach ($this->getAttributes() as $attrName => $value) {
            try {
                $validator = $rules[$attrName];
                if (!($validator instanceof Validator)) {
                    // TODO Change to concrete exception
                    throw new InvalidValidatorException('The value in the rules array must be a valid validator object');
                }
                $rules[$attrName]->assert($value);
            } catch (NestedValidationException $e) {
                $this->errors[$attrName] = $e->getMessages();
            }
        }

        return empty($this->errors);
    }

    abstract protected function rules();
}
