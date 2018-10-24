<?php

namespace Icetee\MNB;

class RateEntity extends RateEntityAbstract
{
    public function __construct()
    {
      //
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    public function getUnit(): int
    {
        return (int)$this->unit;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getValue() : float
    {
        return floatval(str_replace(',', '.', $this->value));
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCurrency()
    {
        return $this->currency;
    }
}
