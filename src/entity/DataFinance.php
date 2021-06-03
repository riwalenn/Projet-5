<?php


class DataFinance
{
    private $id;
    private $label;
    private $value;
    private $value_percent;
    private $date;
    private $modified_at;
    private $modified_by;
    private $etat;

    public function __construct($donnees = null)
    {
        if (!empty($donnees)) :
            $this->hydrate($donnees);
        endif;
    }

    public function hydrate($donnees)
    {
        foreach ($donnees as $cle => $valeur) {
            $method = 'set' . ucfirst($cle);
            if (method_exists($this, $method)) :
                $this->$method($valeur);
            endif;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValuePercent()
    {
        return $this->value_percent;
    }

    public function setValuePercent($value_percent)
    {
        $this->value_percent = $value_percent;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getDaModifiedAt()
    {
        return $this->modified_at;
    }

    public function setModifiedAt($modified_at)
    {
        $this->modified_at = $modified_at;
    }

    public function getDaModifiedBy()
    {
        return $this->modified_by;
    }

    public function setModifiedBy($modified_by)
    {
        $this->modified_by = $modified_by;
    }

    public function getEtat()
    {
        return $this->etat;
    }

    public function setEtat($etat)
    {
        $this->etat = $etat;
    }
}