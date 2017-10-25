<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BibleSimphonyWord extends Model
{


    public function getLinksAttribute($value)
    {
        $array = explode(';', $value);
        return array_slice($array, 0, count($array)-1);
    }

    public function getEmptysAttribute($value)
    {
        $array = explode(';', $value);
        return array_slice($array, 0, count($array)-1);
    }
}
