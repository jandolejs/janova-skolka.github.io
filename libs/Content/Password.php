<?php

namespace App\Content;

use App\Validator\Validate;

class Password extends DataObject
{

    public function __construct($content)
    {
        parent::__construct($content);
        $this->content = password_hash($content, PASSWORD_BCRYPT);
    }

    protected function validate($content)
    {
        Validate::required($content) && Validate::password($content);
    }

    public function getHash()
    {
        return $this->content;
    }
}
