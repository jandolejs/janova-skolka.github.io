<?php

namespace App;

use App\Content\Email;
use App\Content\Name;
use App\Content\Password;
use App\Content\Phone;
use App\Content\Username;

class User
{
    /**
     * Flags for `toArray()` to no propagate password in returned Array
     */
    public const WITHOUT_PASSWORD = false;
    /**
     * Flags for `toArray()` to propagate password in returned Array
     */
    public const WITH_PASSWORD = true;

    /**
     * @var Username
     */
    private $username;
    /**
     * @var Name
     */
    private $name;
    /**
     * @var Phone|null
     */
    private $phone;
    /**
     * @var Email|null
     */
    private $email;
    /**
     * @var Password
     */
    private $password;


    /**
     * User constructor.
     * @param Username $username
     * @param Password $password
     * @param Name $name
     * @param Email|null $email
     * @param Phone|null $phone
     */
    public function __construct(Username $username, Password $password, Name $name, ?Email $email = null, ?Phone $phone = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
    }


    /**
     * @param bool $flags
     * @return array
     */
    public function toArray($flags = self::WITHOUT_PASSWORD)
    {
        $array = [
            'name' => (string)$this->name,
            'username' => (string)$this->username,
            'phone' => $this->hasPhone() ? (string)$this->getPhone() : null,
            'email' => $this->hasEmail() ? (string)$this->getEmail() : null,
        ];

        if ($flags === self::WITH_PASSWORD) {
            $array['password'] = (string)$this->password;
        }

        return $array;
    }


    /**
     * @return Username
     */
    public function getUsername()
    {
        return $this->username;
    }


    /**
     * @return Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function hasPhone()
    {
        return $this->phone !== null;
    }

    /**
     * @return Phone|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param Phone|null $value
     */
    public function setPhone(?Phone $value)
    {
        $this->phone = $value;
    }

    /**
     * @return bool
     */
    public function hasEmail()
    {
        return $this->email !== null;
    }

    /**
     * @return Email|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param Email|null $value
     */
    public function setEmail(?Email $value)
    {
        $this->email = $value;
    }
}
