<?php

namespace Auburus\FormValidation\Tests;

use PHPUnit\Framework\TestCase;
use Auburus\FormValidation\Tests\BasicForm;
use Auburus\FormValidation\FormInterface;
use Auburus\FormValidation\Form;

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

    public function testSymfonyRequest()
    {
        $form = new BasicForm();

        $form->populateFromSymfonyRequest(['holaaa']);
    }
}
