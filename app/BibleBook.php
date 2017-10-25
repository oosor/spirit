<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BibleBook extends Model
{
    protected $casts = [
        'cr' => 'object',
        'a_1' => 'object',
        'a_2' => 'object',
        'a_3' => 'object',
        'a_4' => 'object',
    ];
}
