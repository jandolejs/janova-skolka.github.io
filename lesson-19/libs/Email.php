<?php

    namespace Lesson19;

    require_once __DIR__ . '/Validate.php';

    class Email extends ContentType
    {
        function validate($content)
        {
            Validate::email($content, 'Email');
        }
    }