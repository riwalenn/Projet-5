<?php


class DataFinance
{
    use EntityHydrator;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel($label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getValuePercent(): ?float
    {
        return $this->value_percent;
    }

    public function setValuePercent($value_percent): self
    {
        $this->value_percent = $value_percent;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDaModifiedAt()
    {
        return $this->modified_at;
    }

    public function setModifiedAt($modified_at): self
    {
        $this->modified_at = $modified_at;

        return $this;
    }

    public function getDaModifiedBy()
    {
        return $this->modified_by;
    }

    public function setModifiedBy($modified_by): self
    {
        $this->modified_by = $modified_by;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat($etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}