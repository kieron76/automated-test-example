<?php

namespace App\Services;

use App\Dto\GameDto;
use App\Repositories\GameRepository;
use App\ThirdParty\GameCorp;

class GameService implements GameServiceInterface
{
    public function __construct(
        GameRepository $gameRepository,
        GameCorp $gameCorp
    ) {
        $this->gameRepository = $gameRepository;
        $this->gameCorp = $gameCorp;
    }

    public function getAll() : array
    {
        return $this->gameRepository->getAll();
    }

    public function save(GameDto $game) : array
    {
        try {
            $response = $this->gameCorp->getRating($game->getName());

            // as part of the demo, refactor this
            $rating = $response['rating'];
        } catch (Exception $e) {
            throw new Exception("Unable to get the rating for this game");
        }

        $game = new GameDto(
            $game->getId(),
            $game->getName(),
            $game->getPrice(),
            $this->generateIndex($game->getPrice(), $rating)
        );

        try {
        
            if ($this->gameRepository->find($game->getId())) {
                $this->gameRepository->update($game);
            } else {
                $this->gameRepository->create($game);
            }

        } catch (Exception $e) {
            throw new Exception("Unable to save at this time, please try again later");
        }

    }

    public function find(int $id) : GameDto
    {
        return $this->gameRepository->find($id);
    }

    protected function generateIndex(int $price, int $rating)
    {
        return $price * $rating;
    }
} 