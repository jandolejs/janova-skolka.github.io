<?php

    namespace Lesson20;

    class Email extends ContentType
    {
        function validate($content)
        {
            Validate::email($content, 'Email');
        }
    }
