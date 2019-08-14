<?php
namespace App\Models;

class User extends BaseModel
{
    public $name;

    public $email;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
}
