<?php

namespace Lesson23;

class Email extends ContentType
{
    function validate($content)
    {
        Validate::email($content);
    }
}
