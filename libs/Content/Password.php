<?php

namespace App\Content;

use App\Validator\Validate;

class Password extends DataObject
{
    protected function validate($content)
    {
        Validate::required($content) && Validate::password($content);
    }
}
