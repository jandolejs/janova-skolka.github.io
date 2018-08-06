<?php

namespace Lesson23;

class Phone extends ContentType
{
    protected function validate($content)
    {
        Validate::phone($content);
    }
}
