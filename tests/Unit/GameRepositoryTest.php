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

it('can find a game given an id', function() {
    $game = new StdClass();
    $game->id = 1;
    $game->name = 'Monopoly';
    $game->price = '50';
    $game->index = 3;

    $mock = Mockery::mock(Game::class);
    $mock->shouldReceive('findOrFail')
        ->once()
        ->andReturn($game);

    $gameRepo = new GameRepository($mock);
    $game = $gameRepo->find(1);
    expect($game)->toEqual(new GameDto(1,'Monopoly', 50, 3));
});

it('throws exception if id not found', function() {
    $game = new StdClass();
    $game->id = 1;
    $game->name = 'Monopoly';
    $game->price = '50';
    $game->index = 3;

    $mock = Mockery::mock(Game::class);
    $mock->shouldReceive('findOrFail')
        ->andThrow('\Exception', 'Could Not Find', 123);

    $gameRepo = new GameRepository($mock);
    $gameRepo->find(3);
})->throws(\Exception::class);

it ('saves a game', function() {
    $game = new GameDto(4,'Payday', '20', 3);
    
    // the save method on the model should be called
    $mock = Mockery::mock(Game::class);
    $mock->shouldReceive('create');

    $gameRepo = new GameRepository($mock);
    $gameRepo->create($game);
});

it ('updates a game', function() {
    $game = new GameDto(4,'Payday', '20', 3);


    $mock = Mockery::mock(Game::class);

    $foundGameMock = Mockery::mock(Game::class);
    $foundGameMock->shouldReceive('save');
    $foundGameMock->shouldReceive('setAttribute');

    $mock->shouldReceive('findOrFail')
        ->with(4)
        ->once()
        ->andReturn($foundGameMock);


    $gameRepo = new GameRepository($mock);
    $gameRepo->update($game);
});