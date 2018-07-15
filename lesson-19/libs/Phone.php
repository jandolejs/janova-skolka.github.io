<?php

    namespace Lesson19;

    require_once __DIR__ . '/Validate.php';

    class Phone extends ContentType
    {
        function validate($content)
        {
            Validate::required($content, 'Telefon') && Validate::phone($content, 'Telefon');
        }
    }