<?php

    namespace Lesson19;

    require_once __DIR__ . '/Validate.php';

    class Email
    {
    	private $content;

    	function __construct($content)
        {
            Validate::email($content, 'Email');
            $this->content = $content;
        }

        function getContent() {
        	return $this->content;
        }
    }