<?php

    namespace Lesson20;

    class Message extends ContentType
    {
        function validate($content)
        {
            Validate::required($content, 'Message') && Validate::name($content, 'Message');
        }
    }
