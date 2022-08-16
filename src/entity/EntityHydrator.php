<?php

trait EntityHydrator
{
    public function hydrate($donnees)
    {
        foreach ($donnees as $cle => $valeur) {
            $method = 'set' . ucfirst($cle);

            if (method_exists($this, $method)) :
                $this->$method($valeur);
            endif;
        }
    }
}