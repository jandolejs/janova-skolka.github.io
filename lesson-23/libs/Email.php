<?php

namespace Lesson23;

class Email extends ContentType
{
    protected function validate($content)
    {
        Validate::email($content);
    }
}
