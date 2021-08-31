<?php

namespace App\Util;

class MailLogger
{
    // La valeur du mail est declare au niveau du service.yaml
    private $adminEmail = "admin@eni.fr";

    /**
     * @return string
     */
    public function getAdminEmail(): string
    {
        return $this->adminEmail;
    }

    /**
     * @param string $adminEmail
     */
    public function setAdminEmail(string $adminEmail): void
    {
        $this->adminEmail = $adminEmail;
    }

    public function sendMail(){
        return $this->adminEmail;
    }
}