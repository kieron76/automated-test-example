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
                $game->index
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
        ($this->model)::create([
            'name' => $game->getName(),
            'price' => $game->getPrice(),
            'index' => $game->getIndex(),
        ]);
    }

    public function update(GameDto $game) 
    {
        //$gameModel = ($this->model)::findOrFail($game->getId());
        $gameModel = ($this->model)::findOrFail(4);

        $gameModel->name = $game->getName();
        $gameModel->price = $game->getPrice();
        $gameModel->index = $game->getIndex();

        $gameModel->save();
    }
}