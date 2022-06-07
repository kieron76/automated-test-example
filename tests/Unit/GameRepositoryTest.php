<?php

use App\Dto\GameDto;
use App\Models\Game;
use App\Repositories\GameRepository;

it('can get all records', function() {

    $game = new StdClass();
    $game->id = 1;
    $game->name = 'Monopoly';
    $game->price = '50';
    $game->index = 3;

    $mock = Mockery::mock(Game::class);
    $mock->shouldReceive('all')
        ->once()
        ->andReturn([
            $game
        ]);

    
    $gameRepo = new GameRepository($mock);
    $games = $gameRepo->getAll();

    expect($games)->toBeArray();

    expect($games[0])->toEqual(new GameDto(1,'Monopoly', 50, 3));
});

it('returns null when no records', function() {

    $mock = Mockery::mock(Game::class);
    $mock->shouldReceive('all')
        ->once()
        ->andReturn(null);

    $gameRepo = new GameRepository($mock);
    $games = $gameRepo->getAll();

    expect($games)->toBeNull();
});