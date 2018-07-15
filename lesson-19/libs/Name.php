<?php

    namespace Lesson19;

    require_once __DIR__ . '/Validate.php';

    class Name
    {
    	private $content;

    	function __construct($content)
        {
            Validate::required($content, 'Jméno') && Validate::name($content, 'Name');
            $this->content = $content;
        }

        function getContent() {
        	return $this->content;
        }
    }