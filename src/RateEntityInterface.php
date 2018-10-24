<?php

namespace Icetee\MNB;

interface RateEntityInterface
{
    public function getDate();
    public function setDate($date);

    public function getUnit();
    public function setUnit($unit);

    public function getCurrency();
    public function setCurrency($currency);

    public function getValue() : float;
    public function setValue($value);
}
