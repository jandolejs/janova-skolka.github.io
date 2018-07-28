<?php

    namespace Lesson21;

    class Email extends ContentType
    {
        function validate($content)
        {
            Validate::email($content, 'Email');
        }
    }
