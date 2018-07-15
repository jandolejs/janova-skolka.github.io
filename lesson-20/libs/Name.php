<?php

    namespace Lesson20;

    class Name extends ContentType
    {
        function validate($content)
        {
            Validate::required($content, 'Jméno') && Validate::name($content, 'Name');
        }
    }
