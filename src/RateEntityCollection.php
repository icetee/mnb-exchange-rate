<?php

namespace Icetee\MNB;

class RateEntityCollection
{
    private $collection = [];

    public function addEntity(RateEntity $entity)
    {
        $this->collection[] = $entity;
    }

    public function removeEntity(RateEntity $entity)
    {
        $id = array_search($entity, $this->collection);

        unset($this->collection[$id]);
    }

    public function findEntity(RateEntity $entity)
    {
        $id = array_search($entity, $this->collection);

        return ($this->collection[$id]) ? $this->collection[$id] : null;
    }

    public function findEntityByCurrency($currency)
    {
        foreach ($this->collection as $ck => $entity) {
            if ($entity->getCurrency() === $currency) {
                return $entity;
            }
        }

        return null;
    }

    public function getCollection()
    {
        return $this->collection;
    }
}
