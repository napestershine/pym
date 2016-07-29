<?php

namespace BlogBundle\Model;

use Payum\Core\Model\ArrayObject;

class Orders extends ArrayObject
{
    protected $id;
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}