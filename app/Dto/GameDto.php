<?php

namespace App\Dto;

class GameDto
{
    public function __construct(int $id = null, String $name, int $price, int $index = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->index = $index;
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getPrice() : int
    {
        return $this->price;
    }

    public function getIndex() : int
    {
        return $this->index;
    }
}