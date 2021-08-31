<?php

namespace App\Event;

class InscriptionEvent
{
    public const NAME='mail.event';

    private $user;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }


    public function __construct($user){
     $this->user=$user;
    }


}