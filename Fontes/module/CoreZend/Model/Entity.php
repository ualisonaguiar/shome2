<?php

namespace CoreZend\Entity;

use Zend\Stdlib\Hydrator;

class Entity
{

    public function toArray()
    {
        $hydrator = new Hydrator\ClassMethods();
        $hydrator->setUnderscoreSeparatedKeys(false);
        return $hydrator->extract($this);
    }

}
