<?php

namespace Lesson23;

class Phone extends ContentType
{
    public function validate($content)
    {
        Validate::phone($content);
    }
}
