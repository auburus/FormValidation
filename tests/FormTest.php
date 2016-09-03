<?php

namespace Auburus\FormValidation\Tests;

use PHPUnit\Framework\TestCase;
use Auburus\FormValidation\Tests\BasicForm;
use Auburus\FormValidation\FormInterface;
use Auburus\FormValidation\Form;
use Auburus\FormValidation\InvalidValidatorException;

use GuzzleHttp\Psr7\Request;

class FormTest extends TestCase
{

    public function testObject()
    {
        $form = new BasicForm();

        $this->assertInstanceOf(Form::class, $form);
        $this->assertInstanceOf(FormInterface::class, $form);
    }

    public function testPropierties()
    {
        $form = new BasicForm();

        $this->assertNull($form->name);
        $this->assertNull($form->password);
        $this->assertNull($form->age);
    }

    public function testGetAttributes()
    {
        $form = new BasicForm();

        $form->password = '1234'; //Secure enough for this test

        $attributes = $form->getAttributes();

        $this->assertArrayHasKey('name', $attributes);
        $this->assertArrayHasKey('password', $attributes);
        $this->assertArrayHasKey('age', $attributes);

        $this->assertSame(null, $attributes['name']);
        $this->assertSame('1234', $attributes['password']);
        $this->assertSame(null, $attributes['age']);
    }

    public function testFromGetRequest()
    {
        // The verb is not important
        $request = new Request('DELETE', 'http://example.com/yeah?name=Jake&age=12');

        $form = BasicForm::fromRequest($request);

        $this->assertEquals('Jake', $form->name);
        $this->assertNull($form->password);
        $this->assertEquals('12', $form->age);
    }

    /**
     * Check that only the attributes defined in rules
     * are able to be populated from request
     */
    public function testAvoidOverridingProperties()
    {
        $request = new Request('GET', 'http://example.com/yeah?age=12&unpopulated=hello');

        $form = BasicForm::fromRequest($request);

        $this->assertNull($form->unpopulated);
        $this->assertEquals('12', $form->age);
    }

    public function testDetectInvalidRules()
    {
        $form = new InvalidForm;

        $this->expectException(InvalidValidatorException::class);
        $form->isValid();
    }
}
