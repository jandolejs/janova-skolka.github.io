<?php

    namespace Lesson21;

    class Phone extends ContentType
    {
        function validate($content)
        {
            Validate::phone($content, 'Telefon');
        }
    }
