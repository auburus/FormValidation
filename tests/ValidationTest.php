<?php

namespace Auburus\FormValidation\Tests;

use PHPUnit\Framework\TestCase;
use Auburus\FormValidation\Tests\BasicForm;

class ValidationTest extends TestCase
{
    public function testUnsetAttributesValidation()
    {
        $form = new BasicForm();

        $this->assertFalse($form->isValid());
        $errors = $form->getErrors();

        $this->assertArrayHasKey('name', $errors);
        $this->assertArrayHasKey('password', $errors);
        $this->assertArrayHasKey('age', $errors);
    }

    public function testErroneousAttributesValidation()
    {
        $form = new BasicForm();

        $form->name = 'hola12InvalidCHar$';
        $form->password= 'simple';
        $form->age = '-3';

        $this->assertFalse($form->isValid());
        $errors = $form->getErrors();

        $this->assertArrayHasKey('name', $errors);
        $this->assertArrayHasKey('password', $errors);
        $this->assertArrayHasKey('age', $errors);
    }

    public function testSomeAttributesWrongValidation()
    {
        $form = new BasicForm();

        $form->name = 'CorrectName';
        $form->password= 'bad';
        $form->age = '87';

        $this->assertFalse($form->isValid());
        $errors = $form->getErrors();

        $this->assertArrayNotHasKey('name', $errors);
        $this->assertArrayHasKey('password', $errors);
        $this->assertArrayNotHasKey('age', $errors);
    }

    public function testCorrectForm()
    {
        $form = new BasicForm();

        $form->name = 'CorrectName';
        $form->password= 'strongEnough';
        $form->age = '87';

        $this->assertTrue($form->isValid());
        $this->assertEquals([], $form->getErrors());
    }
}
