<?php

namespace App\ThirdParty;

class GameCorp
{
    public function getRating(string $gameName) : array
    {
        switch (strtolower($gameName)) {
            case 'monopoly':
                return [
                    'UI' => 123123,
                    'rating' => 3,
                ];
            case 'risk': 
                return [
                    'UI' => 1223,
                    'rating' => 5,
                ];
            default:
                return [
                    'error' => 'Not Found',
                ];
        }
    }

}