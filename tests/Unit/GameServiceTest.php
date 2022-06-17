<?php

use App\Repositories\GameRepository;
use App\Services\GameService;
use App\ThirdParty\GameCorp;
use App\Dto\GameDto;

it('calls the third party, saves and generates the correct index', function() {
    $gameToSave = new GameDto(null,'Risk', '5', 2);

    $gameApi = Mockery::mock(GameCorp::class);
    $gameApi->shouldReceive('getRating')
        ->andReturn(['rating' => 3]);

    $gameRepo = Mockery::mock(GameRepository::class);
    $gameRepo->shouldReceive('create');


    $gameService = new GameService($gameRepo, $gameApi);
    $savedGame = $gameService->save($gameToSave);

    expect($savedGame->index)->toBe(15);
});

it('calls the third party, but game not found', function() {
    $gameToSave = new GameDto(null,'payday', '5', 2);

    $gameApi = Mockery::mock(GameCorp::class);
    $gameApi->shouldReceive('getRating')
        ->andReturn(['error' => 'Not Found']);

})->throws(\Exception::class);