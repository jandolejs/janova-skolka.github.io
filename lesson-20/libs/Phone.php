<?php

    namespace Lesson20;

    require_once __DIR__ . '/Validate.php';

    class Phone extends ContentType
    {
        function validate($content)
        {
            Validate::phone($content, 'Telefon');
        }
    }
