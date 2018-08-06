<?php

namespace App\Content;

use App\Validator\Validate;

class Message extends DataObject
{
    protected function validate($content)
    {
        Validate::required($content);
    }
}
