<?php

namespace Lesson22;

class Phone extends ContentType
{
    function validate($content)
    {
        Validate::phone($content);
    }
}
