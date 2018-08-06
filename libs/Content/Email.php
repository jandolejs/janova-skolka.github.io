<?php

namespace App\Content;

use App\Validator\Validate;

class Email extends DataObject
{
    protected function validate($content)
    {
        Validate::email($content);
    }
}
