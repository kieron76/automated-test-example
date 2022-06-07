<?php

namespace App\Repositories;

use App\Dto\GameDto;
use App\Models\Game;
use Illuminate\Database\Eloquent\Model;

class GameRepository
{

    public function __construct(Model $model)
    {
       $this->model = get_class($model);
    }

    public function getAll(): ?array
    {
        $games = ($this->model)::all();
        $returnGames = [];

        if (!$games) {
            return null;
        }

        foreach ($games as $game) {
            $returnGames[] = new GameDto(
                $game->id,
                $game->name,
                $game->price,
                $game->price
            );
        }

        return $returnGames;
    }

    public function find(int $id): GameDto
    {
        $game = ($this->model)::findOrFail($id);

        return new GameDto(
            $game->id,
            $game->name,
            $game->price,
            $game->index
        );
    }

    public function create(GameDto $game) 
    {
        $game = new $this->model;

        $game->name = $game->getName();
        $game->price = $game->getPrice();
        $game->index = $game->getIndex();

        $game->save();
    }

    public function update(GameDto $game) 
    {
        $game = $this->find($game->getId());

        $game->name = $game->getName();
        $game->price = $game->getPrice();
        $game->index = $game->getIndex();

        $game->save();
    }
}