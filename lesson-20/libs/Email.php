<?php

    namespace Lesson20;

    require_once __DIR__ . '/Validate.php';

    class Email extends ContentType
    {
        function validate($content)
        {
            Validate::email($content, 'Email');
        }
    }
