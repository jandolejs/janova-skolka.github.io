<?php

namespace Lesson22;

class Escape
{
    static function html($text)
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}
