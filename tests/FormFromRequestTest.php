<?php

namespace Auburus\FormValidation\Tests;

use PHPUnit\Framework\TestCase;
use Auburus\FormValidation\Tests\BasicForm;
use GuzzleHttp\Psr7\Request;

class FormTest extends TestCase
{
    public function testConstructFromRequest()
    {
        $request = new Request('GET', 'http://asdf.co');
    }

    public function testFromGetRequest()
    {

    }

    public function testFromPostRequest()
    {

    }

    public function testFromPutRequest()
    {

    }

    public function testFromDeleteRequest()
    {

    }
}
