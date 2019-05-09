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

    public function randomCard (Request $request)
    {
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
