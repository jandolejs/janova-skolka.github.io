<?php

    namespace Lesson20;

    class Phone extends ContentType
    {
        function validate($content)
        {
            Validate::phone($content, 'Telefon');
        }
    }
