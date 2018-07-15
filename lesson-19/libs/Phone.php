<?php

    namespace Lesson19;

    require_once __DIR__ . '/Validate.php';

    class Phone
    {
        private $content;

        function __construct($content)
        {
            Validate::required($content, 'Telefon') && Validate::phone($content, 'Telefon');
            $this->content = $content;
        }

        function getContent() {
            return $this->content;
        }
    }