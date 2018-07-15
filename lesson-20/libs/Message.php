<?php

    namespace Lesson20;

    require_once __DIR__ . '/Validate.php';

    class Message extends ContentType
    {
        function validate($content)
        {
            Validate::required($content, 'Message') && Validate::name($content, 'Message');
        }
    }
