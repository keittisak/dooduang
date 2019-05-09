<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dooduang extends Model
{
    public function card () {
        return [
            1 => [
                'name' => 'card 1',
                'info' => 'xxx',
            ],
            2 => [
                'name' => 'card 2',
                'info' => 'xxx',
            ],
            3 => [
                'name' => 'card 3',
                'info' => 'xxx',
            ],
            4 => [
                'name' => 'card 4',
                'info' => 'xxx',
            ],
            5 => [
                'name' => 'card 5',
                'info' => 'xxx',
            ],
            6 => [
                'name' => 'card 6',
                'info' => 'xxx',
            ]
        ];
    }
}
