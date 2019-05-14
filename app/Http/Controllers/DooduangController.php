<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dooduang;
use Storage;
use Illuminate\Support\Arr;

class DooduangController extends Controller
{
    public $card;
    public function __construct() 
    {
        $this->card = json_decode(Storage::get('public/card.json'),true);
    }
    public function index (Request $request)
    {
        return view('dooduang');
    }

    public function getCard (Request $request)
    {
        return response()-json($this->card);
    }

    public function switchCard (Request $request)
    {
        $age = $request->age;
        $card = $this->card;
        shuffle($card);
        for($i=1; $i <= $age; $i++)
        {        
            $i = rand(1,89);
            $i = 100 - $i;
            $cardSwitch = [];
            for($i; $i <= 89;$i++)
            {
                $cardSwitch[$i] = $card[$i];
                $card = array_except($card, [$i]);
            }
            $card = array_merge($cardSwitch, $card);
        }
        return response()->json($card);
    }

    public function usedCard (Request $request)
    {
        $cards = $request->cards;
        $usedCards = [];
        for($i=0;$i <=9;$i++)
        {
            $usedCards[] = $cards[$i];
            unset($cards[$i]);
        }
        $cards = array_values($cards);
        return response()->json(['cards' => $cards, 'used_cards' => $usedCards]);
    }

    public function randomCard (Request $request)
    {
        $card = [];
        for($i=1; $i <= 90; $i++)
        {
            $card[] = [
                'id' => $i,
                'name' => 'card'.$i,
                'info' => 'xxxx',
                'img' => $i.'.jpg'
            ];
        }
        echo json_encode($card);
        exit();
        $card = [];
        for($i = 1; $i <= 10; $i++)
        {
            $cardRandom = array_rand($this->card,1);
            if(!in_array($cardRandom, $card))
            {
                $card[] = $cardRandom;
            }else{
                $cardRandom = array_rand($this->card,1);
                if(!in_array($cardRandom, $card))
                {
                    $card[] = $cardRandom;
                }else{
                    $cardRandom = array_rand($this->card,1);
                    if(!in_array($cardRandom, $card))
                    {
                        $card[] = $cardRandom;
                    }else{
                        $cardRandom = array_rand($this->card,1);
                        if(!in_array($cardRandom, $card))
                        {
                            $card[] = $cardRandom;
                        }
                    }
                }
            }
        }

        // $cardTotal = Arr::except($this->card, $card);
        $result = [];
        foreach($card as $data)
        {
            $result[] = $this->card[$data];
        }

        return response()->json($result);
    }
}
