<?php

namespace App\Util;

use App\Entity\Wish;

class Censurator{

    private $insultes=['merde','chier','putain'];

    /**
     * purify : Verifie si la description et le titre ne comporte pas de mots deplacé a partir d'une liste de mot
     *
     * @param Wish $wish : wish a verifier
     * @return Wish : wish apres la censure
     */
    public function purify(Wish $wish):Wish
    {
        foreach ($this->insultes as $insulte){

            //Verification dans la description
            if (str_contains($wish->getDescription(), $insulte)) {
                $wish->setDescription(str_replace($insulte, "*", $wish->getDescription()));
            }

            //Verification dans le titre
            if (str_contains($wish->getTitle(), $insulte)) {
                $wish->setTitle(str_replace($insulte, "*", $wish->getTitle()));
            }
        }

       return $wish;
    }

}