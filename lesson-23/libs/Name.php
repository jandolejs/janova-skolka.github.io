<?php

namespace Lesson23;

class Name extends ContentType
{
    function validate($content)
    {
        Validate::required($content) && Validate::name($content);
    }
}
