<?php

namespace App\Http\Controllers;

use App\Dto\GameDto;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Services\GameServiceInterface;

class GameController extends Controller
{
    public function __construct(GameServiceInterface $game)
    {
        $this->game = $game;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = $this->game->getAll();
        
        return view('index',compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required',
        ]);

        $game = new GameDto(
            null,
            $validatedData['name'], 
            $validatedData['price'],
            0
        );

        $this->game->save($game);
   
        return redirect('/games')->with('success', 'Game is successfully saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $game = $this->game->find($id);

        return view('edit', compact('game'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required'
        ]);

        $game = new GameDto(
            $id,
            $validatedData['name'], 
            $validatedData['price'],
            0
        );

        $this->game->save($game);

        return redirect('/games')->with('success', 'Game Data is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game = $this->game->delete($id);

        return redirect('/games')->with('success', 'Game Data is successfully deleted');
    }
}