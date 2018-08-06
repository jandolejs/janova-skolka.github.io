<?php

namespace Lesson23;

class Email extends ContentType
{
    public function validate($content)
    {
        Validate::email($content);
    }
}
