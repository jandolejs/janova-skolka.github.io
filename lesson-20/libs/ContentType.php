<?php

    namespace Lesson20;

    class ContentType
    {
    	protected $content;

    	function __construct($content)
        {
            $this->validate($content);
            $this->content = $content;
        }

        function validate($content)
        {
        }

        function getContent() {
        	return $this->content;
        }

        function __toString() {
            return $this->getContent();
        }
    }
