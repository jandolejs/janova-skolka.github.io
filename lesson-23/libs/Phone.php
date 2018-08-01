<?php

namespace Lesson23;

class Phone extends ContentType
{
    function validate($content)
    {
        Validate::phone($content);
    }
}
