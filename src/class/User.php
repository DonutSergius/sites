<?php

class User
{
    private $nickname;
    private $first_name;
    private $last_name;
    private $role;
    private $date_created;
    private $password;
    private $email;

    public function __construct(
        $nickname,
        $first_name,
        $last_name,
        $role,
        $date_created,
        $password,
        $email,
    ) {
        $this->nickname = $nickname;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->role = $role;
        $this->date_created = $date_created;
        $this->password = $password;
        $this->email = $email;
    }

    public function toArray()
    {
    }
}
