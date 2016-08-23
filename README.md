# FormValidation

This project aims to provide a wrapper over [Respect/Validaton](https://github.com/Respect/Validation) for validate attributes
as a whole.

## Install
When something works, there will be a composer package.

## Documentation

Right now, this is what IT WILL BE. It's not implemented yet. (Documentation-Driven Development)

The idea behind this is create your own classes where you want, but make them extend `Auburus\Form`.

```php
<?php
// src/Form/UserForm.php

namespace App\Form;

use Auburus\Form;
use Respect\Validation as v;

class UserForm extends Form
{
    protected function rules()
    {
        return [
            'username' => v::notEmpty()->alnum()->noWhitespace(),
            'password' => v::notEmpty()->length(8, 20),
            'password2' => v::identical($this->password), //Every key you define is accessible as a property
            'remindMe' => v::boolVal(),
        ];
    }
}
```

And then, in your controller...

```php
<?php
// src/Controllers/UserController.php

namespace App\Controllers;

use Auburus\Form;
use Psr\Http\Message\RequestInterface;

class UserController extends Controller
{
// ...
public action create()
{
    $form = Form::fromRequest(RequestInterface $request);
    // You can also force a specific HTTP Verb, to only retrieve params from there
    $form = Form::fromRequest(RequestInterface $request, 'DELETE');
    
    if (!$form->isValid()) {
        $errors = $form->getErrors(); //Array of errors, more info about this later
        
        //...
    }
    
    $validAttributes = $form->getAttributes();
    // Do something with them
    // ...
}
```
