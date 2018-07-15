<?php

namespace Lesson17;

class Escape
    {
        static function html($text)
        {
            return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
        }
    }
?>