<?php

namespace App\Repositories;

use app\Dto\GameDto;
use App\Models\Game;

class GameRepository
{
    public function getAll(): array
    {
        $games = Game::all();
        $returnGames = [];

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
        $game = Game::findOrFail($id);

        return new GameDto(
            $game->id,
            $game->name,
            $game->price,
            $game->index
        );
    }

    public function create(GameDto $game) 
    {
        $game = new Game([
            'name' => $game->getName(),
            'price' => $game->getPrice(),
            'index' => $game->getIndex(),
        ]);

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