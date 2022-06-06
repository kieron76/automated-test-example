<?php

namespace App\Services;

use App\Dto\GameDto;

interface GameServiceInterface
{

    public function getAll() : array;
    public function save(GameDto $game);
    public function find(int $id) : GameDto;

}