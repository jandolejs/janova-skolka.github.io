<?php

    namespace Lesson20;

    require_once __DIR__ . '/Validate.php';

    class Name extends ContentType
    {
        function validate($content)
        {
            Validate::required($content, 'Jméno') && Validate::name($content, 'Name');
        }
    }
