<?php

namespace App\Content;

use App\Validator\Validate;

class Password extends DataObject
{

    public function __construct($content, bool $alreadyHash = false)
    {
        // Bypass validation when already hash
        $this->checkValidity = !$alreadyHash;
        parent::__construct($content);

        // Don't hash if already hash
        if (!$alreadyHash) {
            $this->content = password_hash($content, PASSWORD_BCRYPT);
        }
    }


    protected function validate($content)
    {
        Validate::required($content) && Validate::password($content);
    }
}
